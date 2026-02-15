# ZOO Shipping Calculator

## 1. Огляд проекту

Цей проєкт реалізує калькулятор вартості доставки для компанії ZOO.
Він дозволяє розраховувати ціну доставки для різних перевізників за їхніми правилами.

- Backend: Symfony (PHP 8+)
- Frontend: Vue.js (мінімальний UI)
- Архітектура: OOP, SOLID-friendly, використовується патерн стратегій для перевізників
- Інфраструктура: Docker + docker-compose
- Тестування: PHPUnit

Підтримувані перевізники:

- TransCompany: ≤10кг → 20 EUR, >10кг → 100 EUR
- PackGroup: 1 EUR за 1 кг

Система розширювана — додавання нового перевізника вимагає лише створення нової стратегії.

## 2. Функціонал

Backend API:

POST /api/shipping/calculate

Запит (JSON):
```
{
  "carrier": "transcompany",
  "weightKg": 12.5
}
```

Відповідь (успіх):
```
{
  "carrier": "transcompany",
  "weightKg": 12.5,
  "currency": "EUR",
  "price": 100
}
```

Відповідь (помилка):
```
{
  "error": "Unsupported carrier"
}
```

Frontend:

- Поле для ваги посилки
- Випадаючий список для вибору перевізника
- Кнопка "Розрахувати ціну"
- Область для виводу результату або помилки

## 3. Архітектура

- CarrierStrategyInterface: метод calculatePrice(float $weightKg): float
- Конкретні класи стратегій: TransCompanyStrategy, PackGroupStrategy
- ShippingCalculatorService: приймає slug перевізника і вагу, виконує обрану стратегію
- CarrierFactory: динамічно повертає правильну стратегію
- Контролер: endpoint /api/shipping/calculate
- Валідація: Symfony Validator для перевірки payload

Додавання нового перевізника відбувається додавнням класу який реалізує CarrierStrategyInterface

## 4. Docker Setup

Сервіси:

- php: Symfony backend
- nginx: reverse proxy
- node: Vue frontend
- postgres: база даних

Запуск контейнерів:

docker-compose up --build

- Symfony API: http://localhost:8080
- Vue frontend: http://localhost:3000 (dev)

Білд фронтенду для продакшн:

docker-compose run --rm node
# Виконує npm install та npm run build, результат потрапляє в backend/public

## 5. Розробка

Backend:

docker-compose exec php bash
composer install

Frontend:

docker-compose exec node bash
npm install

## 6. Тестування

Запуск PHPUnit:

docker-compose exec php bash
php bin/phpunit

Тести включають:

- Unit-тести для стратегій перевізників
- Unit/Integration тести для ShippingCalculatorService
- Тести API endpoint