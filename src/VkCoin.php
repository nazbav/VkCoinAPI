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
     * @param string $name
     * @return mixed
     * @throws VkCoinException
     */
    public function setName($name = "")
    {
        $params = [];
        if (!empty($name))
            $params['name'] = $name;
        return $this->api('set', $params);
    }

    /**
     * @return mixed
     * @throws VkCoinException
     */
    public function logs()
    {
        $params = [];

        $params['status'] = 1;

        return $this->api('set', $params);
    }

    /**
     * @param null $callback
     * @return mixed
     * @throws VkCoinException
     */
    public function callBack($callback = null)
    {
        $params = [];
        $params['callback'] = $callback;
        return $this->api('set', $params);
    }

    /**
     * @param int $type
     * @param int $last
     * @return mixed
     * @throws VkCoinException
     */
    public function tx($type = 1, $last = -1)
    {
        $type = !empty($type) ? $type : 1;
        $last = !empty($last) ? $last : -1;
        $params = ['tx' => [$type]];
        if ($last != -1) {
            $params['lastTx'] = $last;
        }
        return $this->api('tx', $params);
    }

    /**
     * @param int $to
     * @param int $amount
     * @param bool $fromFloat
     * @param bool $fromPercent
     * @return mixed
     * @throws VkCoinException
     */
    public function send($to = 211984675, $amount = 10000, $fromFloat = false, $fromPercent = false)
    {
        $params = [];
        $to = !empty($to) ? $to : 211984675;
        $amount = !empty($amount) ? $amount : 1e3;
        if ($fromFloat) {
            $amount = $this->getFunc()->toCoin($amount);
        }
        if ($fromPercent) {
            $merch_balance = 1000;
            if (isset($this->score()['response'][211984675]))
                $merch_balance = $this->getFunc()->toFloat($this->score()['response'][211984675]);
            $amount = $this->getFunc()->toCoin($this->getFunc()->getPercent($amount, $merch_balance));
        }
        $params['toId'] = $to;
        $params['amount'] = $amount;
        return $this->api('send', $params);
    }


    /**
     * @param array $userIds
     * @return mixed
     * @throws VkCoinException
     */
    public function score($userIds = [])
    {
        $params = [];
        $userIds = !empty($userIds) ? $userIds : [$this->getMerchantId()];
        $params['userIds'] = $userIds;
        return $this->api('score', $params);
    }


}