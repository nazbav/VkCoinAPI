<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 18.04.2019
 * Time: 23:40
 */

use nazbav\VkCoinAPI\VkCoin;
use nazbav\VkCoinAPI\VkCoinException;

include "../vendor/autoload.php";//WARNING: or "vendor/autoload.php";

try {
    $request = json_decode(file_get_contents('php://input'), true);

    $coin = new VkCoin(211984675, "wertewrtergewgerfgdsgdsfg54refgdegewadc1hhA_k2D&kZw", false);

    if (!empty($request) &&
        isset($request['id']) &&
        isset($request['from_id']) &&
        isset($request['amount']) &&
        isset($request['payload']) &&
        isset($request['key'])
    ) {

        file_put_contents('trans.txt', json_encode($request));//запись последней транзакции

        $merchkey = $coin->getFunc()->getMerchkey();
        if ($coin->getFunc()->validationKey($request['id'], $request['from_id'], $request['amount'], $request['payload'], $request['key'])) {
            // Ваш код...
            $to = $request['from_id'];
            $amount = $request['amount'];
            $coin->send($to, $amount);//Возвращаем бабосики)))
            file_put_contents('trans_ok.txt', json_encode($request));//запись последней удачной транзакции
            //Конец
        }
    }
} catch (VkCoinException $e) {
    file_put_contents('trans_error.txt', $e);//запись последней удачной транзакции
    echo 'ok';
}

echo 'ok';
