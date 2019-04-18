<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 18.04.2019
 * Time: 23:40
 */

use nazbav\VkCoinAPI\VkCoin;
use nazbav\VkCoinAPI\VkCoinException;

include "../vendor/autoload.php";

try {
    $request = json_decode(file_get_contents('php://input'), true);

    $coin = new VkCoin(211984675, "rwtwertewrtewrtewrrwrwtrewtertewrtewrtewrtewrD&kZw", false);
    /**
     * @param $request
     * @param $merchkey
     * @return bool
     */
    function check_request($request, $merchkey)
    {
        $key = md5($request['id'] . $request['id'] . $request['id'] . $request['id'] . $merchkey);
        if ($key === $request['key'])
            return true;
        return false;
    }

    if (isset($request) && !empty($request)) {
        $merchkey = $coin->getKey();
        if (check_request($request, $merchkey)) {

            // Ваш код...

        }
    }

} catch (VkCoinException $e) {
    echo 'ok';
}


echo 'ok';