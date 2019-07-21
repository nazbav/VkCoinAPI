# VK Coin API

Задать вопрос можно в [беседе](https://vk.me/join/AJQ1d6PnhgV0xKfFdpK3ChdC). 
Библиотека для работы с VK Coin API. Основана на "[документации](https://vk.com/@hs-marchant-api)".

![](https://img.shields.io/packagist/php-v/nazbav/vk-coin-api?color=FF6F61&style=for-the-badge)
![](https://img.shields.io/github/release/nazbav/vk-coin-api.svg?color=green&style=for-the-badge)
![](https://img.shields.io/github/last-commit/nazbav/vk-coin-api.svg?style=for-the-badge)
![](https://img.shields.io/github/repo-size/nazbav/vk-coin-api.svg?color=green&style=for-the-badge)
![](https://img.shields.io/github/commit-activity/m/nazbav/vk-coin-api.svg?style=for-the-badge)
[![](https://img.shields.io/packagist/dt/nazbav/vk-coin-api.svg?style=for-the-badge)](https://packagist.org/packages/nazbav/vk-coin-api/)
[![](https://img.shields.io/github/issues/nazbav/vk-coin-api.svg?style=for-the-badge)](https://github.com/nazbav/vk-coin-api/issues)

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
| $checkResponse | string | Отлов ошибок, по умолчанию `true`(см. `Получение ошибок` ниже).                                      |

## Функции

#### CallBack | Транзакции

Установка callBack.

```php
    $coin->callBack('https://example.org/callback');
```

Удаление callBack.
```php
    $coin->callBack();
```


| Параметр | Тип    | Описание                       |
|----------|--------|--------------------------------|
| url      | string | Адрес для отправки уведомлений |

Валидация запроса:
```php
$request = json_decode(file_get_contents('php://input'), true);

// Проверка наличия полей: id, from_id, amount, payload, key
if (!empty($request) &&
    //...
    isset($request['key'])
) {

    if ($coin->getFunc()->validationKey(
        $request['id'],
        $request['from_id'],
        $request['amount'],
        $request['payload'],
        $request['key']
    )) {
//Код...
    }
}

```

| Параметр | Тип    | Описание                            |
|----------|--------|-------------------------------------|
| id       | int    | номер транзакции                    |
| from_id  | int    | от кого                             |
| amount   | int    | Количество                          |
| payload  | int    | Число от -2000000000 до 2000000000. |
| key      | string | Ключ                                |

Получение списка неудавшихся запросов
```php
    $coin->logs();
```

| Параметр | Тип    | Описание                       |
|----------|--------|--------------------------------|
| status   | int    | Получение логов                |

#### Настройка магазина

Установка названия магазина
```php
    $coin->setName('CoinShop');
```

| Параметр | Тип    | Описание          |
|----------|--------|-------------------|
| name     | string | Название магазина |


#### Получение списка транзакций
Пример:
```php
    $coin->tx(); //type 1 -- получение транзакций по ссылке
    $coin->tx(2, -1); // получение транзакций магазина (первые 100)
```

| Параметр     | Тип    |
|--------------|--------|
| type      | int    |
| last      | int    |

#### Перевод
Пример:
```php
$coin->send(211984675, $coin->toCoin(1));//Отправка одного коина
$coin->send(211984675, 1, false, true);//отправка 1% баланса магазина
$coin->send(211984675, 1, true);//отправка 1 коина
```

| Параметр     | Тип    | Описание                                             |
|--------------|--------|------------------------------------------------------|
| to           | int    | ID пользователя, которому будет отправлен перевод    |
| amount       | int    | Сумма перевода в тысячных долях (500 = 0,500 коин)   |
| fromFloat    | bool   | amount задан в float (см. функции библиотеки ниже)?  |
| fromPercent  | bool   | amount задан в процентах?                            |

#### Получение баланса
Пример:
```php
$coin->score([211984675]);
$coin->score(); //Для вывода баланса текущего пользователя
```

| Параметр     | Тип    |
|--------------|--------|
| userIds      | array  |

#### Получение ссылки на оплату
Пример:
```php
   $coin->getFunc()->link(); // vk.com/coin#tMERCHANTID - сылка для **обычной** оплаты!
   $coin->getFunc()->link(15000);//sum
   $coin->getFunc()->link(15000, 123456); //sum, payload
   $coin->getFunc()->link(15000, 0, false); //sum, payload, fixed_sum = false
      $coin->getFunc()->link(15000, 0, false, false); //sum, payload, fixed_sum = false, hex = false
```

| Параметр     | Тип     | Описание                                                                       |                                                                                              
|--------------|--------|---------------------------------------------------------------------------------|
| sum          | int    | Сумма перевода                                                                  |
| payload      | int    | Любое число от -2000000000 до 2000000000. Поставь 0, дальше сделаем все сами ;) |
| fixed_sum    | bool   | Фиксация суммы перевода                                                         |
| hex          | bool   | Генерация hex-ссылки                                                            |



#### Псевдонимы (Aliases)

Их вы можете указывать в параметре метода, для упращения работы.

| Имя       | Псевдоним          |  Описание                               |
|-----------|--------------------|-----------------------------------------|
| set       | config           | Параметры магазина                      |
| set       | settings           | Параметры магазина                      |
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

#### Формат ответа

| Имя поля     | Тип    |  Описание                                                                   |
|--------------|--------|-----------------------------------------------------------------------------|
| status       | bool   | `true`, если запрос выполнен без критических ошибок.                        |
| response     | array  | Массив с данными (за место него может быт выдан `error`)                    |
| error        | array  | Для получения этого массива см. `Получение ошибок`

Данному формату не подчиняются методы начинающиеся с ```$coin->getFunc()```.

#### Получение ошибок

По стандарту библиотека сама обрабатывает ошибки и выдает VkCoinException на этот счет.
Для того чтобы самостоятельно обрабатывать ошибки необходимо передать всего один параметр при инициализации:

```php
include "../vendor/autoload.php";

$coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "45vyv45KJMKouj9retghrebtvrhtrehryvt54ONopiino", true);
```
#### Error code 100

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


#### Функции библиотеки

**Получение Key**

```php
$coin->getFunc()->getMerchkey();
```

**Получение MerchantId**

```php
$coin->getFunc()->getMerchantId();
```

**Перевод числа с плавающей точкой в коины**

```php
$coin->getFunc()->toCoin(100.000); //100000
$coin->getFunc()->toCoin(100.435); //100435
``` 

Пример: отправка 1 коина (1.000) пользователю:

```php
$coin->send(211984675, $coin->getFunc()->toCoin(1));//1000
$coin->send(211984675, $coin->getFunc()->toCoin(1.000));//1000
```

**Перевод коинов в число с плавающей точкой**

```php
$coin->getFunc()->toFloat(100000); //100.000
$coin->getFunc()->toFloat(100435); //100.435
```

Пример: запрос баланса мерча, разбор ответа, конвертация в float:

```php
$coin->getFunc()->toFloat($account1); //float(124414.662)
```

**Получение процента (A) от числа (B)**

```php
$coin->getFunc()->toFloat($coin->getFunc()->getPercent(75, $coin->getFunc()->toCoin(1)));//75% от 1 коина (1,000)
``` 

Пример: 75% от 10.000 VKC = 7.500 VKC:

```php
$coin->getFunc()->toFloat($coin->getFunc()->getPersent(75, $coin->getFunc()->toCoin(10)));
```   

**Процент числа A от числа B**

```php
//Сколько процентов занимает 1 коин от 100 коинов
$coin->getFunc()->whatPercent($coin->getFunc()->toFloat(1),$coin->getFunc()->toFloat(100));
```

Пример: на сколько процетов баланс пользователя id539620705 больше баланса пользователя id211984675:

```php
$coin->getFunc()->whatPercent($account2, $account1)
```   
Сколько процентов составляет баланс пользователя id211984675 от баланса пользователя id539620705:
```php
$coin->getFunc()->whatPercent($account1, $account2)
```   

Даные в примерах:
```php
 $balance = $coin->score([539620705, 211984675])['response'];
    $account1 = $balance[211984675];
    $account2 = $balance[539620705];
```
