#!/bin/sh
set -e
cd /var/www/html

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

if [ ! -f vendor/autoload.php ]; then
  echo "[docker] composer install を実行中..."
  composer install --no-interaction --prefer-dist
  chown -R www-data:www-data vendor
fi

if [ ! -f .env ] && [ -f .env.example ]; then
  echo "[docker] .env.example から .env をコピーします"
  cp .env.example .env
fi

if [ -f .env ] && ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
  echo "[docker] php artisan key:generate を実行します"
  php artisan key:generate --force || true
fi

# リポジトリに public/build が無い場合、ビルド済みアセットをイメージから補う（bind mount 上書き後）
if [ ! -f public/build/manifest.json ] && [ -d /opt/laravel-public-build ]; then
  if [ "$(ls -A /opt/laravel-public-build 2>/dev/null)" ]; then
    echo "[docker] public/build をイメージ内アセットで補完します"
    mkdir -p public/build
    cp -a /opt/laravel-public-build/. public/build/
  fi
fi

echo "[docker] データベースマイグレーション"
n=0
while [ "$n" -lt 60 ]; do
  if php artisan migrate --force; then
    echo "[docker] migrate 完了"
    break
  fi
  n=$((n + 1))
  if [ "$n" -eq 60 ]; then
    echo "[docker] エラー: migrate が繰り返し失敗しました（DB 接続・権限を確認）"
    exit 1
  fi
  echo "[docker] DB 待機中... ($n/60)"
  sleep 2
done

php artisan storage:link 2>/dev/null || true

exec docker-php-entrypoint "$@"
