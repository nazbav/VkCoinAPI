<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 20.04.2019
 * Time: 00:14
 */

namespace nazbav\VkCoinAPI;


/**
 * Class CoinFuncModel
 * @package nazbav\VkCoinAPI
 */
class CoinFuncModel extends VkCoinController
{
    /**
     * CoinFuncModel constructor.
     * @param $merchantId
     */
    public function __construct($merchantId)
    {
        $this->setMerchantId($merchantId);
    }

    /**
     * @return string
     */
    public function getMerchkey()
    {
        return $this->merchkey;
    }

    /**
     * @return int
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }
}