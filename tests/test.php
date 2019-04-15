<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 15.04.2019
 * Time: 18:08
 */


use nazbav\VkCoinAPI\VkCoinException;

include "../vendor/autoload.php";

try {
    $coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "",false);

    var_dump($coin->api('getTransactions'));
    var_dump($coin->api('transactions', ['type' => 1]));
    var_dump($coin->api('tx', ['type' => 2, 'last' => -1]));

    var_dump($coin->api('getPayLink'));
    var_dump($coin->api('getLink', ['sum' => 15000]));
    var_dump($coin->api('link', ['sum' => 15000, 'payload' => 123456]));
    var_dump($coin->api('link', [
        'sum' => 15000,
        'payload' => 0,
        'fsum' => false
    ]));
//228173736
    var_dump($coin->api('sendTransfer',['to' => 228173736,'amount'=>1]));
    var_dump($coin->api('balance',['userIds' => [211984675]]));

} catch (VkCoinException $e) {
    echo $e;
}