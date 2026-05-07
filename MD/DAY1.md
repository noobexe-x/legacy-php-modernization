# Laravel Linux Deployment & Web Server Test

## 目的

WSL2 上の Ubuntu 環境を利用し、  
Laravel アプリケーションの Linux デプロイおよび  
Web サーバー構成の動作検証を行う。

---

## 実施内容

- WSL2 上に Ubuntu 環境を構築
- PHP / Composer / MySQL / Node.js をインストール
- Laravel プロジェクトの Linux 環境デプロイ
- GitHub から Laravel プロジェクトを clone
- composer install を実行
- npm install を実行
- APP_KEY を生成
- .env を設定
- migration / seeder を実行
- MySQL 権限エラーを解決
- Vite manifest エラーを解決
- Laravel アプリケーションの起動確認
- Nginx + PHP-FPM 環境を構築
- Apache と Nginx のポート競合を調査
- Linux 上での Web サーバー切替動作を検証
- Laravel を Nginx 経由で動作確認

---

## 学習内容

- Windows 環境と Linux 環境の違い
- Laravel の Linux デプロイ手順
- Vite build が必要な理由
- Laravel の環境変数構成
- Ubuntu 上の MySQL 認証方式
- Git clone と ZIP ダウンロードの違い
- Linux における Web サーバー構成
- Nginx / Apache / PHP-FPM の役割
- 80 ポート競合の調査方法
- PHP-FPM のプロセスプール構造
- Web リクエストの基本フロー

---

## 構成イメージ

Browser
↓
Nginx
↓
PHP-FPM
↓
Laravel
↓
MySQL

---

## 次のステップ

- リソース分離の検討
- Docker Compose 化
- EC2 へのデプロイ
- S3 / RDS 構成検証
- Route53 による名前解決
- Terraform によるインフラ構築