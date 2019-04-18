# VK Coin API

Задать вопрос можно в [беседе](https://vk.me/join/AJQ1d6PnhgV0xKfFdpK3ChdC). 
Библиотека для работы с VK Coin API. Основана на "[документации](https://vk.com/@hs-marchant-api)", 
и библиотеке [Матвея Вишневсого](https://github.com/slmatthew/vk-coin-php).

  ![VERSION][IMGVERSION]
  ![PHP][IMGPHP]
  ![LICENSE][IMGLICENSE]
  
## Подключение

```bash
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

| Имя       | Псевдоним          |  Описание                               |
|-----------|--------------------|-----------------------------------------|
| tx        | getTransactions    | Список транзакций                       |
| tx        | transactions       | Список транзакций                       |
| link      | getPayLink         | Платежная ссылкка                       |
| link      | getLink            | Платежная ссылкка                       |
| send      | transfer           | Отправка перевода                       |
| send      | sendTransfer       | Отправка перевода                       |
| send      | pay                | Отправка перевода                       |
| alias     | getAliases         | Список псевдонимов                      |
| alias     | aliases            | Список псевдонимов                      |
| score     | getBalance         | Баланс игрока                           |
| score     | balance            | Баланс игрока                           |

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
## Error code 100

В случай если библиотеке не удалось получить данные c сервера, и т.д. (ошибки curl).
Будет выдана 100 ошибка:

```json
{"status":false,
      "error":{
        "code":100,
        "message":"Описание ошибки."
      }
}
```

## Получение списка транзакций
Пример:
```php
    $coin->api('getTransactions', ['type' => 2, 'last' => -1]);
```

| Параметр     | Тип    |
|--------------|--------|
| type      | int    |
| last      | int    |

## Перевод
Пример:
```php
$coin->api('sendTransfer',['to' => 211984675,'amount'=>$coin->toCoin(1)]);
```

| Параметр     | Тип    | Описание                                             |
|--------------|--------|------------------------------------------------------|
| to           | int    | ID пользователя, которому будет отправлен перевод       |
| amount       | int    | Сумма перевода в тысячных долях (500 = 0,500 коин)   |

## Получение баланса
Пример:
```php
$coin->api('getBalance');
$coin->api('getBalance',['userIds' => [211984675]]);
$coin->api('getBalance'); //Для вывода баланса текущего пользователя
```

| Параметр     | Тип    |
|--------------|--------|
| userIds      | array  |

## Получение ссылки на оплату
Пример:
```php
   $coin->api('getPayLink');
   $coin->api('getLink', ['sum' => 15000]);
   $coin->api('link', ['sum' => 15000, 'payload' => 123456]);
   $coin->api('link', [
        'sum' => 15000,
        'payload' => 0,
        'fsum' => false
    ]);
```

| Параметр     | Тип     | Описание                                                                       |                                                                                              
|--------------|--------|---------------------------------------------------------------------------------|
| sum          | int    | Сумма перевода                                                                  |
| payload      | int    | Любое число от -2000000000 до 2000000000. Поставь 0, дальше сделаем все сами ;) |
| fsum         | bool   | Фиксация суммы перевода                                                         |
| hex          | bool   | Генерация hex-ссылки                                                            |


## функции библиотеки

* **Получение Key**

```php
$coin->getKey();
```

* **Получение MerchantId**

```php
$coin->getMerchantId();
```

* **Перевод числа с плавающей кочкой в коины**

```php
$coin->toCoin(100.000); //100000
$coin->toCoin(100.435); //100435
``` 

Пример: отправка 1 коина (1.000) пользователю:

```php
$coin->api('sendTransfer',['to' => 211984675,'amount'=>$coin->toCoin(1)]);//1000
```

* **Перевод коинов в число с плавающей кочкой**

```php
$coin->toFloat(100000); //100.000
$coin->toFloat(100435); //100.435
```

Пример: запрос баланса мерча, разбор ответа, конвертация в float:

```php
$coin->toFloat($coin->api('balance')['response'][211984675]); //float(124414.662)
```

* **Получение процента (A) от числа (B)**

```php
$coin->toFloat($coin->getPercent(75, $coin->toCoin(1)));//75% от 1 коина (1,000)
``` 

Пример: 75% от 10.000 VKC = 7.500 VKC

```php
$coin->toFloat($coin->getPersent(75, $coin->toCoin(10)));
```   

* **Процент числа A от числа B**

```php
//Сколько процентов занимает 1 коин от 100 коинов
$coin->whatPercent($coin->toFloat(1),$coin->toFloat(100));
```

Пример: во сколько процетов баланс магазина id539620705 больше баланса магазина id211984675. 

```php
    $coin->whatPercent($coin->toFloat($coin->api('balance',['userIds'=>[539620705]])['response'][539620705]),
        $coin->toFloat($coin->api('balance')['response'][211984675]));   
```   

[IMGPHP]: https://img.shields.io/badge/PHP-7.1%5E-brightgreen.svg?style=for-the-badge
[IMGLICENSE]: https://img.shields.io/badge/LICENSE-MIT-yellow.svg?style=for-the-badge
[IMGVERSION]: https://img.shields.io/badge/LAST%20VERSION-1.2.0-red.svg?style=for-the-badge
