#!/usr/bin/env bash
# docker compose up -d --build と同等。マイグレーション等は php コンテナの entrypoint 内で実行されます。
set -euo pipefail
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$ROOT"

echo "[docker-up] docker compose up -d --build"
docker compose up -d --build

echo ""
echo "[docker-up] 完了。ブラウザ: http://localhost:8080"
echo "[docker-up] フロントをホストで更新した場合: npm run build または docker compose --profile assets run --rm node"
