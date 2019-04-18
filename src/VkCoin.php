<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 15.04.2019
 * Time: 20:04
 */

namespace nazbav\VkCoinAPI;


/**
 * Class VkCoin
 * @package nazbav\VkCoinAPI
 */
class VkCoin extends VkConModel
{
    /**
     * @param $arguments
     */
    protected function tx(array $arguments = [
        'type' => 1,
        'last' => -1,
    ])
    {
        $type = isset($arguments['type']) ? $arguments['type'] : 1;
        $last = isset($arguments['last']) ? $arguments['last'] : -1;
        $params = ['tx' => [$type]];
        if ($last != -1) {
            $params['lastTx'] = $last;
        }
        $this->setParams($params);
    }

    /**
     * Если запустить без запроса параметров, то получится донат автору))
     *
     * @param $arguments
     */
    protected function send(array $arguments = [
        'to' => 211984675,
        'amount' => 10000,
    ])
    {
        $params = [];
        $to = isset($arguments['to']) ? $arguments['to'] : 211984675;
        $amount = isset($arguments['amount']) ? $arguments['amount'] : 1e3;
        $params['toId'] = $to;
        $params['amount'] = $amount;
        $this->setParams($params);
    }
    /**
     * Если запустить без запроса параметров, то получится донат автору))
     *
     * @param $arguments
     */
    protected function score(array $arguments = [
        'userIds' => [211984675],
    ])
    {
        $params = [];
        $userIds = $arguments['userIds'] ?: [$this->getMerchantId()];
        $params['userIds'] = $userIds;
        $this->setParams($params);
    }

    /**
     * @param $arguments
     * @return string
     */
    protected function link(array $arguments = [
        'sum' => 0,
        'fsum' => true,//fixed sum
        'hex' => true,
        'payload' => 0
    ])
    {

        $merchant_id = $this->getMerchantId();
        $sum = isset($arguments['sum']) ? $arguments['sum'] : 1e3;
        $fsum = isset($arguments['fsum']) ? $arguments['fsum'] : true;
        $hex = isset($arguments['hex']) ? $arguments['hex'] : true;

        $payload = $arguments['payload'] == 0 ?
            rand(-2000000000, 2000000000) :
            $arguments['payload'];


        if (!$sum) {
            $link = sprintf('%s#t%s', $this->getCoinUrl(), $merchant_id);
            return $link;
        } else if ($hex) {
            $merchant_id = dechex($this->getMerchantId());
            $sum = dechex($sum);
            $payload = dechex($payload);

            $link = sprintf('%s#m%s_%s_%s%s',
                $this->getCoinUrl(),
                $merchant_id,
                $sum,
                $payload,
                $fsum ? "" : "_1"
            );

        } else {

            $link = sprintf('%s#m%s_%s_%s%s', $this->getCoinUrl(),
                $merchant_id,
                $sum,
                $payload,
                $fsum ? "" : "_1"
            );

        }
        return $link;
    }

    /**
     * @param $arguments
     * @return array|mixed
     */
    protected function alias(array $arguments = [])
    {
        $aliases = require '../config/Aliases.php';
        return $aliases;
    }

}