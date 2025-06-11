#!/usr/bin/env bash
set -euo pipefail

# Ensure required binaries are available
if ! command -v php >/dev/null; then
  echo "php command not found. Please install PHP 8.2 or newer." >&2
  exit 1
fi

if ! command -v composer >/dev/null; then
  echo "Composer nicht gefunden, versuche Installation \u00fcber getcomposer.org..." >&2
  if command -v curl >/dev/null; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir="/usr/local/bin" --filename="composer"
  else
    echo "curl command not found. Bitte Composer manuell installieren." >&2
    exit 1
  fi
fi

# Install PHP dependencies
composer install

# Activate the extension within TYPO3
vendor/bin/typo3 extension:activate equed_core

# Migrate database schema
vendor/bin/typo3 database:updateschema

# Flush caches
vendor/bin/typo3 cache:flush
