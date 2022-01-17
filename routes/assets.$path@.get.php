<?php

use Ekok\Utils\Str;

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Request\headers;

$dir = $fun['project_dir'] . '/resources/';
$len = strlen($dir);
$test = Str::fixslashes(realpath($dir . $params['path']));

($test && 0 === strncasecmp($dir, $test, $len) && is_file($test) && $len < strlen($test)) || not_found();
!session_id() || session_write_close();
header_remove();

$lastModifiedTime = filemtime($test);
$size = filesize($test);
$max = $size - 1;
$bytes = array(0, $max);

header('Last-Modified: ' . gmdate("D, d M Y H:i:s", $lastModifiedTime) . " GMT");

if (($since = headers('if-modified-since')) && strtotime($since) === $lastModifiedTime) {
    header("HTTP/1.1 304 Not Modified", true, 304);
    exit();
}

if ($range = headers('range')) {
    if (0 !== strncmp($range, 'bytes=', 6)) {
        header('HTTP/1.1 416 Requested Range Not Satisfiable', true, 416);
        header('Content-Range: bytes */' . $size); // Required in 416.

        exit();
    }

    $check = array_filter(explode('-', strstr(substr($range, 6) . ',', ',', true)));

    sort($check);

    $bytes = $check + $bytes;

    if ($bytes[0] >= $bytes[1] || $bytes[0] < 0 || $bytes[1] > $max) {
        header('HTTP/1.1 416 Requested Range Not Satisfiable', true, 416);
        header('Content-Range: bytes */' . $size);

        exit();
    }

    header('HTTP/1.1 206 Partial Content', true, 206);
    header('Content-Range: bytes ' . sprintf('%u-%u/%u', $bytes[0], $bytes[1], $size));
}

$fp = fopen($test, 'rb');
$contentLength = $bytes[1] - $bytes[0] + 1;
$mimes = array(
    'css' => 'text/css',
    'gif' => 'image/gif',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'js' => 'application/x-javascript',
    'png' => 'image/png',
    'svg' => 'text/xml-svg',
    'txt' => 'text/plain',
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
);
$mime = $mimes[ltrim(strrchr($test, '.'), '.')] ?? 'application/octet-stream';

header('Accept-Ranges: bytes');
header('Content-Length: ' . sprintf('%u', $contentLength));
header('Content-Type: ' . $mime);
header('Cache-Control: public, max-age=604800');
header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 604800) . " GMT");

if ($bytes[0] > 0) {
    fseek($fp, $bytes[0]);
}

$sentSize = 0;

while (!feof($fp) && (connection_status() === CONNECTION_NORMAL)) {
    $readingSize = $contentLength - $sentSize;
    $readingSize = min($readingSize, 512 * 1024);

    if ($readingSize <= 0) {
        break;
    }

    $data = fread($fp, $readingSize);

    if (!$data) {
        break;
    }

    $sentSize += strlen($data);

    echo $data;
    flush();
}

fclose($fp);
exit();
