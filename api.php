<?php
header('Content-Type: application/json');
require __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;

$config = require __DIR__ . '/config.php';

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['message' => '画像が選択されていないか、エラーが発生しました。']);
    exit;
}

$file = $_FILES['image'];

// 1. 画像形式（MIMEタイプ）のチェック
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file['tmp_name']);

if (!in_array($mimeType, $allowedMimeTypes, true)) {
    echo json_encode(['message' => 'エラー: JPEG, PNG, GIF, WebP 形式の画像のみアップロード可能です。']);
    exit;
}

// 2. S3 保存処理
$s3Key = 'uploads/' . time() . '_' . basename($file['name']);

try {
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => $config['region'],
    ]);

    $s3->putObject([
        'Bucket'      => $config['bucket'],
        'Key'         => $s3Key,
        'SourceFile'  => $file['tmp_name'],
        'ContentType' => $mimeType,
    ]);

    $cmd = $s3->getCommand('GetObject', ['Bucket' => $config['bucket'], 'Key' => $s3Key]);
    $request = $s3->createPresignedRequest($cmd, '+15 minutes');

    echo json_encode([
        'message' => 'アップロード成功！',
        'url' => (string)$request->getUri()
    ]);
} catch (Exception $e) {
    echo json_encode(['message' => 'S3 エラー: ' . $e->getMessage()]);
}