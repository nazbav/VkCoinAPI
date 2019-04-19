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
    $coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "wrfdfsadfsadc1dafsakZw", false);
   var_dump($coin->logs());
    //var_dump($coin->tx());
   // var_dump($coin->send(211984675, 1, false, true));//отправка 1% баланса магазина

} catch (VkCoinException $e) {
    echo $e;
}