<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像アップロード</title>
</head>
<body>
    <h2>画像ファイルのアップロード</h2>
    <!-- enctype="multipart/form-data" が必須です -->
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="submit">アップロード</button>
    </form>
</body>
</html>