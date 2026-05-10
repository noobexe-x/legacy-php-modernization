#!/usr/bin/env bash
# 一括停止・削除（ボリュームは保持。データごと消す場合は docker compose down -v）
set -euo pipefail
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$ROOT"

docker compose down "$@"
echo "[docker-down] コンテナを停止しました。"
