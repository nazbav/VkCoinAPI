# VK Coin PHP

Библиотека для работы с VK Coin API. Основана на "[документации](https://vk.com/@hs-marchant-api)", и примерах.

  ![VERSION][IMGVERSION]
  ![BUID][IMGBUID]
  ![PHP][IMGPHP]
  ![LICENSE][IMGLICENSE]
  
## Подключение

```php
composer require nazbav/vk-coin-api
```

1. Через Composer:
```php
include "../vendor/autoload.php";

$coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "45vyv45KJMKouj9retghrebtvrhtrehryvt54ONopiino");
```
1. С обработкой исключений:
```php

include "../vendor/autoload.php";

try {
    $coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "45vyv45KJMKouj9retghrebtvrhtrehryvt54ONopiino");
//ваш код...
} catch (VkCoinException $e) {
    echo $e;
}
```

| Параметр       | Тип    | Описание                                             |
|----------------|--------|------------------------------------------------------|
| $merchantId    | int    | ID странички, для которой был получен платёжный ключ |
| $key           | string | Платёжный ключ                                       |
| $checkResponse | string | Отлов ошибок, по умолчанию `true`(см. `Получение ошибок`).                                      |

## Функции

Для получения данных неоходимо выполнить функцию вида:

```php
   $coin->api('метод или псевдоним', [массив параметров]);
```

## Псевдонимы (Aliases)

Их вы можете указывать в параметре метода, для упращения работы.

| Имя      | Псевдоним          |  Описание                               |
|----------|--------------------|-----------------------------------------|
| tx       | getTransactions    | Список транзакций                       |
| tx       | transactions       | Список транзакций                       |
| link     | getPayLink         | Платежная ссылкка                       |
| link     | getLink            | Платежная ссылкка                       |
| send     | transfer           | Отправка перевода                       |
| send     | sendTransfer       | Отправка перевода                       |
| alias    | getAliases         | Список псевдонимов                      |
| alias    | aliases            | Список псевдонимов                      |
| score    | getBalance         | Баланс игрока                           |
| score    | balance            | Баланс игрока                           |

## Формат ответа

| Имя поля     | Тип    |  Описание                                                                   |
|--------------|--------|-----------------------------------------------------------------------------|
| status       | bool   | `true`, если запрос выполнен без критических ошибок.                        |
| response     | array  | Массив с данными (за место него может быт выдан `error`)                    |
| error        | array  | Для получения этого массива см. `Получение ошибок`

Данному формату не подчиняются методы link и alias.

## Получение ошибок

По стандарту библиотека сама обрабатывает ошибки и выдает VkCoinException на этот счет.
Для того чтобы самостоятельно обрабатывать ошибки необходимо передать всего один параметр при инициализации:

```php
include "../vendor/autoload.php";

$coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "45vyv45KJMKouj9retghrebtvrhtrehryvt54ONopiino", true);
```

## Получение списка транзакций
Пример:
```php
    $coin->api('getTransactions', ['type' => 2, 'last' => -1]);
```

| Параметр     | Тип    |
|--------------|--------|
| tx_type      | int    |
| last_tx      | int    |

## Перевод
Пример:
```php
$coin->api('sendTransfer',['to' => 211984675,'amount'=>10000]);
```

| Параметр     | Тип    | Описание                                             |
|--------------|--------|------------------------------------------------------|
| to_id        | int    | ID пользователя, которому будет отправлен перевод    |
| amount       | int    | Сумма перевода в тысячных долях (500 = 0,500 коин)   |

## Получение баланса
Пример:
```php
$coin->api('getBalance',['userIds' => [211984675]]);
```

| Параметр     | Тип    |
|--------------|--------|
| userIds      | array  |

## Получение ссылки на оплату
Пример:
```php
    var_dump($coin->api('getPayLink'));
    var_dump($coin->api('getLink', ['sum' => 15000]));
    var_dump($coin->api('link', ['sum' => 15000, 'payload' => 123456]));
    var_dump($coin->api('link', [
        'sum' => 15000,
        'payload' => 0,
        'fsum' => false
    ]));
```

| Параметр     | Тип     | Описание                                                                       |                                                                                              
|--------------|--------|---------------------------------------------------------------------------------|
| sum          | int    | Сумма перевода                                                                  |
| payload      | int    | Любое число от -2000000000 до 2000000000. Поставь 0, дальше сделаем все сами ;) |
| fsum         | bool   | Фиксация суммы перевода                                                         |
| hex          | bool   | Генерация hex-ссылки                                                            |

[IMGPHP]: https://img.shields.io/badge/PHP-5.4%5E-brightgreen.svg?style=for-the-badge
[IMGLICENSE]: https://img.shields.io/badge/LICENSE-MIT-yellow.svg?style=for-the-badge
[IMGVERSION]: https://img.shields.io/badge/LAST%20VERSION-1.0.0-blue.svg?style=for-the-badge
[IMGBUID]: https://img.shields.io/badge/LAST%20BUILD-16.04.19-red.svg?style=for-the-badge
