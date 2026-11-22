<?php
/**
 * Live Instagram follower count for @viewsofvgm.
 * Returns JSON: {"followers":395,"posts":451,"updated":"...","source":"graph-api"}
 *
 * Uses the official Instagram Graph API (requires a Business/Creator account linked
 * to a Facebook Page). Put IG_USER_ID and IG_ACCESS_TOKEN in api/config.php
 * (see config.example.php). Results are cached for an hour.
 * Without config, it returns 503 and the website shows its fallback number.
 */
header('Content-Type: application/json');
header('Cache-Control: public, max-age=600');

const CACHE_SECONDS = 3600;
$cacheFile = sys_get_temp_dir() . '/viewsofvgm_followers.json';

if (is_file(__DIR__ . '/config.php')) require __DIR__ . '/config.php';

if (is_file($cacheFile) && time() - filemtime($cacheFile) < CACHE_SECONDS) {
    readfile($cacheFile);
    exit;
}

$result = null;
if (defined('IG_USER_ID') && defined('IG_ACCESS_TOKEN') && IG_USER_ID && IG_ACCESS_TOKEN) {
    $ch = curl_init('https://graph.facebook.com/v19.0/' . rawurlencode(IG_USER_ID) .
        '?fields=followers_count,media_count&access_token=' . urlencode(IG_ACCESS_TOKEN));
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10]);
    if (defined('CA_BUNDLE')) curl_setopt($ch, CURLOPT_CAINFO, CA_BUNDLE);
    $json = json_decode((string) curl_exec($ch), true);
    curl_close($ch);
    if (isset($json['followers_count'])) {
        $result = ['followers' => (int) $json['followers_count'], 'posts' => $json['media_count'] ?? null, 'source' => 'graph-api'];
    }
}

if ($result) {
    $result['updated'] = gmdate('c');
    $out = json_encode($result);
    @file_put_contents($cacheFile, $out);
    echo $out;
} elseif (is_file($cacheFile)) {
    readfile($cacheFile); // last known value
} else {
    http_response_code(503);
    echo json_encode(['error' => 'not configured']);
}
