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
    $coin = new \nazbav\VkCoinAPI\VkCoin(211984675, "rtewrtrwertewerwOadc1hhA_k2D&kZw", false);

    $name = $coin->api('settings', ['name' => 'GopShop']);
    var_dump($name);
    var_dump($coin->api('link', [
        'sum' => $coin->toCoin(10000),
        'payload' => 0,
        'fsum' => false,
        'hex' => false,
    ]));
} catch (VkCoinException $e) {
    echo $e;
}