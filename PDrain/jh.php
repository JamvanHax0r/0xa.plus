<?php
if (isset($_GET['file'])) {
    $id = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['file']);
    $url = "https://pd.gamedrive.org/api/file/" . $id;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) {
        if (stripos($header, 'Content-Disposition:') === 0 || stripos($header, 'Content-Type:') === 0 || stripos($header, 'Content-Length:') === 0) {
            header($header, false);
        }
        return strlen($header);
    });
    curl_exec($ch);
    curl_close($ch);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => false, 'error' => 'Akses ditolak!']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$url = isset($input['url']) ? trim($input['url']) : '';

if (empty($url)) {
    echo json_encode(['status' => false, 'error' => 'URL target tidak boleh kosong!']);
    exit;
}

preg_match('/pixeldrain\.com\/(u|file)\/([a-zA-Z0-9_-]+)/i', $url, $matches);
if (!isset($matches[2])) {
    echo json_encode(['status' => false, 'error' => 'URL Pixeldrain tidak valid, harap periksa kembali!']);
    exit;
}
$id = $matches[2];

$bypassUrl = "https://pd.gamedrive.org/api/file/" . $id;

$ch = curl_init($bypassUrl);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36');
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$headResponse = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 && $httpCode !== 206) {
     echo json_encode(['status' => false, 'error' => 'Gagal nembus file! Mungkin limit dewa atau ID mati. (HTTP ' . $httpCode . ')']);
     exit;
}

$size = 0;
$filename = $id . '_zeawin';
if (preg_match('/Content-Length: (\d+)/i', $headResponse, $m)) $size = (int)$m[1];
if (preg_match('/filename="([^"]+)"/i', $headResponse, $m)) $filename = $m[1];
else if (preg_match('/filename=([^;\r\n]+)/i', $headResponse, $m)) $filename = trim($m[1], ' "\'');

function formatBytes($bytes) {
    if ($bytes == 0) return '0 B';
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $pow = floor(log($bytes) / log(1024));
    return round($bytes / pow(1024, $pow), 2) . ' ' . $units[$pow];
}

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$basePath = dirname($_SERVER['REQUEST_URI']) === '/' || dirname($_SERVER['REQUEST_URI']) === '\\' ? '' : dirname($_SERVER['REQUEST_URI']);
$proxyLink = $protocol . $host . $basePath . '/jh.php?file=' . $id;

echo json_encode([
    'Developers' => 'JH a.k.a Dhika',
    'Kesayangan' => 'Fiony Alveria',
    'status' => true,
    'data' => [
        'id' => $id,
        'nama_file' => $filename,
        'ukuran' => $size > 0 ? formatBytes($size) : 'Unknown',
        'link_original' => $url,
        'link_bypass' => $proxyLink
    ]
], JSON_PRETTY_PRINT);
?>
