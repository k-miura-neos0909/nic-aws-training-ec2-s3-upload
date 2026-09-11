# AWS研修① EC2＋S3連携によるファイルアップロードと公開

## 概要
EC2 上の PHP アプリから IAM ロールを用いて Amazon S3 へ安全に画像をアップロードし、署名付き URL で閲覧・プレビュー表示するシステムです。AWS 無料枠の範囲内で構築しています。

---

## 主な機能・仕様

* **画像アップロード機能**: `upload_form.html` から送られた画像を `api.php` で処理。拡張子・MIME タイプのサーバーサイドバリデーションを実施（JPG, PNG, GIF, WebP 対応）。
* **S3 連携とプレビュー**: AWS SDK for PHP を使用して S3 へ保存し、プレビュー用の署名付き URL を動的生成して返却。
* **IAM ロール認証**: EC2 に IAM ロールを付与し、コード内にアクセスキーを保持しない安全な設計を採用。
* **ネットワークセキュリティ**: セキュリティグループで HTTP (80) および SSH (22) のみを許可。

---

## 技術スタック

* **インフラ**: AWS (EC2: `t2.micro` / `t3.micro`, S3, IAM Role, VPC)
* **OS / Web**: Amazon Linux 2023 / Apache / PHP 8.x (AWS SDK for PHP)

---

## リポジトリ構成

* `upload_form.html`: 画像アップロード画面
* `api.php`: アップロード処理・S3 連携ロジック
* `config.php`: S3 バケット・リージョン設定
* `php-s3-app.drawio`: システム構成図データ