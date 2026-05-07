# Laravel Linux Deployment Progress

## 目的

WSL2 上の Ubuntu 環境を使用し、  
Laravel プロジェクトの Linux 上での一連のデプロイ・動作確認を行う。

## 実施内容

- WSL2 上に Ubuntu 環境を構築
- PHP / Composer / MySQL / Node.js をインストール
- MySQL データベースおよびユーザーを設定
- GitHub から Laravel プロジェクトを clone
- composer install を実行
- npm install を実行
- APP_KEY を生成
- .env を設定
- migration / seeder を実行
- MySQL 権限エラーを解決
- Vite manifest エラーを解決
- Linux 環境上で Laravel アプリケーションの起動確認

## 学習内容

- Windows 環境と Linux 環境の違い
- Vite build が必要な理由
- Laravel の環境変数構成
- Ubuntu 上の MySQL 認証方式
- Git clone と ZIP ダウンロードの違い
- Laravel のローカル Linux デプロイ手順

## 次のステップ

- リソース分離の検討
- Docker Compose 化
- EC2 へのデプロイ
- Terraform によるインフラ構築