<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 15.04.2019
 * Time: 20:07
 */

namespace nazbav\VkCoinAPI;


/**
 * Class VkCoinController
 * @package nazbav\VkCoinAPI
 */
abstract class VkCoinController
{
    /**
     * @var array
     */
    protected $checkResponse = true;
    /**
     * @var array
     */
    protected $params;
    /**
     * @var string
     */
    private $host = 'coin-without-bugs.vkforms.ru/merchant';
    /**
     * @var string
     */
    private $coinUrl = 'vk.com/coin';
    /**
     * @var string
     */
    private $key = "";
    /**
     * @var int
     */
    private $merchantId = 0;

    /**
     * VkCoinController constructor.
     * @param $merchantId
     * @param $key
     * @param bool $checkResponse
     * @throws VkCoinException
     */
    public function __construct($merchantId, $key, $checkResponse = true)
    {
        if (!file_exists('../config/Language.php'))
            throw new VkCoinException('Language.php is missing.');
        if (!file_exists('../config/Aliases.php'))
            throw new VkCoinException(VkCoinMessages::msg()['COIN_FATAL_ALIASES']);
        $this->setCheckResponse($checkResponse);
        $this->setMerchantId($merchantId);
        $this->setKey($key);
        $this->params = [
            'merchantId' => $merchantId,
            'key' => $key
        ];
    }

    /**
     * @param bool $checkResponse
     */
    public function setCheckResponse($checkResponse)
    {
        $this->checkResponse = $checkResponse;
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function api($method, $parameters = [])
    {
        $aliases = [];
        if (file_exists('../config/Aliases.php')) $aliases = require '../config/Aliases.php';
        //Алиасы для методов.
        $method = strtr($method, $aliases);
        if ($parameters)
            $response = $this->$method($parameters);
        else
            $response = $this->$method();
        if ($response)
            $this->setResponse($response);
        else {
            $this->setResponse($this->callAPI($method));
            $this->checkResponse();
        }
        return $this->getResponse();
    }

    /**
     * @param $response
     * @return mixed
     */
    abstract protected function setResponse($response);

    /**
     * @param $method
     * @return mixed
     */
    abstract protected function callAPI($method);

    /**
     * @return void
     */
    abstract protected function checkResponse();

    /**
     * @return mixed
     */
    abstract protected function getResponse();

    /**
     * @param $name
     * @param $arguments
     * @throws VkCoinException
     */
    public function __call($name, $arguments)
    {
        throw new VkCoinException(VkCoinMessages::msg()['COIN_METHOD_ERROR']);
    }

    /**
     * @return array
     */
    public function getCheckResponse()
    {
        return $this->checkResponse;
    }

    /**
     * @return string
     */
    protected function getCoinUrl()
    {
        return $this->coinUrl;
    }

    /**
     * @return array
     */
    protected function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    protected function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }

    /**
     * @return string
     */
    protected function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    protected function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return int
     */
    protected function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param int $merchantId
     */
    protected function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return string
     */
    protected function getHost()
    {
        return $this->host;
    }

    /**
     * @param $host
     * @param $parameters
     * @return mixed
     */
    abstract protected function postCurl($host, $parameters);
}