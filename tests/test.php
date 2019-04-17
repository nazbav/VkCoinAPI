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
    $coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "gsddfgddfdffddfdfdfdfdfdfsddfhgsdfgdsw",false);

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


    var_dump($coin->api('sendTransfer',['to' => 211984675,'amount'=>$coin->floatCoin(1)]));
    var_dump($coin->api('balance'));

} catch (VkCoinException $e) {
    echo $e;
}