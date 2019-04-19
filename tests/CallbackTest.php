<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 18.04.2019
 * Time: 23:40
 */

use nazbav\VkCoinAPI\VkCoin;
use nazbav\VkCoinAPI\VkCoinException;

include "vendor/autoload.php";

try {
    $request = json_decode(file_get_contents('php://input'), true);
    file_put_contents('trasn.txt', json_encode($request));
    
    $coin = new VkCoin(211984675, "wertewrtergewgerfgdsgdsfg54refgdegewadc1hhA_k2D&kZw", false);

    if (!empty($request)) {
        $merchkey = $coin->getKey();
        if (check_request($request, $merchkey)) {
            // Ваш код...
            usleep(2000);
            $coin->api('sendTransfer',['to' => $request['from_id'],'amount'=>$request['amount']]);

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
    echo 'ok';
}


echo 'ok';
