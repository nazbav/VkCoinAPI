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

    if (!empty($request)) {

        file_put_contents('trans.txt', json_encode($request));//запись последней транзакции

        $merchkey = $coin->getFunc()->getMerchkey();

        if (check_request($request, $merchkey)) {
            // Ваш код...
            $to = $request['from_id'];
            $amount = $request['amount'];
            $coin->send($to, $amount);//Возвращаем бабосики)))
            file_put_contents('trans_ok.txt', json_encode($request));//запись последней удачной транзакции
            //Конец
        }
    }
    /**
     * @param $request
     * @param $merchkey
     * @return bool
     */
    function check_request($request, $merchkey)
    {
        $key = md5($request['id'] . $request['from_id'] . $request['amount'] . $request['payload'] . $merchkey);
        if ($key === $request['key'])
            return true;
        return false;
    }
} catch (VkCoinException $e) {
    file_put_contents('trans_error.txt', $e);//запись последней удачной транзакции
    echo 'ok';
}

echo 'ok';
