# React + Symfony SPA (метафорические карты)

## Что уже сделано

- **Главная страница**: список упражнений карточками (адаптив: 1/2/3 колонки).
- **Меню-заготовка**: `Упражнения / Статьи / Контакты / Войти`, лого слева.
- **Алые тона**: через CSS variables (легко менять).
- **Данные из БД**: Symfony API `GET /api/exercises`.
- **Сидер**: упражнения добавлены через fixtures (`backend/src/DataFixtures/AppFixtures.php`).

## Где менять тексты

- **Тексты фронтенда (лого/меню/вступление)**: `frontend/src/content.ts`
- **Описания упражнений (сидер)**: `backend/src/DataFixtures/AppFixtures.php`

## Как запустить через Docker

Сборка и запуск:

```bash
docker build -t mac-spa .
docker run --rm -p 8080:8080 mac-spa
```

Открыть в браузере: `http://localhost:8080`

При первом старте контейнер сам:

- применит миграции,
- загрузит fixtures в SQLite (`backend/var/app.db` внутри контейнера).

## Запуск в dev-режиме (без Docker)

Фронтенд:

```bash
cd frontend
npm install
npm run dev
```

API (Symfony) в этой среде может потребовать расширение PHP `ext-xml`.

