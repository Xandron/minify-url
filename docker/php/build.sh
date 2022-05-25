#!/usr/bin/env bash

set -o pipefail

echo -e "\n\033[1mНачало сборки\033[0m"

echo -e "Проверяем наличие файла конфигурации \".env.local\""
if [ ! -f .env.local ]; then
  echo -e "Файл \".env.local\" не найден. Создаем файл конфигурации из файла \".env.dev\""
  cp .env.test .env.local
fi
echo -e "Проверяем что приложение сконфигурировано для \"test\" или \"dev\" окружения (в \".env.local\" APP_ENV=dev)"
export $(grep -v '^#' .env.local | xargs)
if [[ ! "$APP_ENV" = "dev" ]] && [[ ! "$APP_ENV" = "test" ]]; then
  echo -e "APP_ENV=$APP_ENV. Работа скрипта в этом окружении не предусмотрена. Завершение"
  exit 1
fi
echo -e "Чистим var/* и tests/_output/*"
rm -rf var/* tests/_output/*
echo -e "Выполняем \"composer install\""
composer validate --strict
composer install

echo -e "Проверяем что приложение сконфигурировано для работы с тестовой БД (warranty-dev)"
if [[ $DATABASE_URL == *"/warranty-dev"* ]]; then
  echo -e "Пересоздаем БД"
  php bin/console doctrine:database:drop --if-exists --force
  php bin/console doctrine:database:create
  echo -e "Выполняем миграции"
  php bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing
  echo -e "Создаем пользователя api (test\123456)"
  php bin/console doctrine:query:sql "$(< tests/_data/sql/users.sql)"
else
  echo -e "Используется не тестовая БД, пересоздание БД и добавление пользователя api было проигнорировано (DATABASE_URL=$DATABASE_URL)"
  echo -e "Выполняем миграции"
  php bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing
fi

echo -e "Чистим кеши doctrine"
php bin/console doctrine:cache:clear-query --flush
php bin/console doctrine:cache:clear-result --flush
php bin/console doctrine:cache:clear-metadata --flush

echo -e "\n\033[1mСборка завершена\033[0m\n"

