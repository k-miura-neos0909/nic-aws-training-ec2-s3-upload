<?php
$uploadDir = 'uploads/';

// 保存用ディレクトリが存在しない場合は作成
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $targetPath = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $message = '画像のアップロードに成功しました！';
        } else {
            $message = 'ファイルの保存に失敗しました。';
        }
    } else {
        $message = 'アップロードエラーが発生しました。エラーコード: ' . $file['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アップロード結果</title>
</head>
<body>
    <h2>結果</h2>
    <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <a href="upload_form.php">フォームに戻る</a>
</body>
</html>