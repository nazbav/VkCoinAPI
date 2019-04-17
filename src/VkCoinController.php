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
     * @var string
     */
    const HOSTNAME = 'coin-without-bugs.vkforms.ru/merchant';
    /**
     * @var string
     */
    const COIN_URL = 'vk.com/coin';

    /**
     * @var
     */
    protected $directory;
    /**
     * @var array | string
     */
    protected $response;
    /**
     * @var bool
     */
    protected $checkResponse = true;
    /**
     * @var array
     */
    protected $messages;
    /**
     * @var array
     */
    protected $params;
    /**
     * @var string
     */
    protected $merchkey = "";
    /**
     * @var int
     */
    protected $merchantId = 0;

    /**
     * VkCoinController constructor.
     * @param $merchantId
     * @param $key
     * @param bool $checkResponse
     * @throws VkCoinException
     */
    public function __construct($merchantId, $key, $checkResponse = true)
    {
        $this->setDir(dirname(dirname(__FILE__)));
        if (!file_exists($this->getDir() . '/config/Language.php'))
            throw new VkCoinException('Language.php is missing.');
        else
            $this->setMessages((new VkCoinMessages())->messages());
        if (!file_exists($this->getDir() . '/config/Aliases.php'))
            throw new VkCoinException($this->getMessages()['COIN_FATAL_ALIASES']);
        $this->setCheckResponse($checkResponse);
        $this->setMerchantId($merchantId);
        $this->setKey($key);
        $this->params = [
            'merchantId' => $merchantId,
            'key' => $key
        ];
    }

    /**
     * @param mixed $dir
     */
    protected function setDir($dir)
    {
        $this->directory = $dir;
    }

    /**
     * @return mixed
     */
    protected function getDir()
    {
        return $this->directory;
    }

    /**
     * @param $Messages
     */
    private function setMessages(array $Messages)
    {
        $this->messages = $Messages;
    }

    /**
     * @return array
     */
    protected function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param string $key
     */
    protected function setKey($key)
    {
        $this->merchkey = $key;
    }

    /**
     * @return mixed
     */

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function api($method, $parameters = [])
    {
        $aliases = [];
        if (file_exists($this->getDir() . '/config/Aliases.php')) $aliases = require $this->getDir() . '/config/Aliases.php';
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
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array|string $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param $name
     * @param $arguments
     * @throws VkCoinException
     */
    public function __call($name, $arguments)
    {
        throw new VkCoinException($this->getMessages()['COIN_METHOD_ERROR']);
    }

    /**
     * @return string
     */
    public function getKey()
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

    /**
     * @param int $merchantId
     */
    protected function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return bool
     */
    protected function getCheckResponse()
    {
        return $this->checkResponse;
    }

    /**
     * @param bool $checkResponse
     */
    protected function setCheckResponse($checkResponse)
    {
        $this->checkResponse = $checkResponse;
    }

    /**
     * @return string
     */
    protected function getCoinUrl()
    {
        return self::COIN_URL;
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
    protected function setParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
    }

    /**
     * @return string
     */
    protected function getHost()
    {
        return self::HOSTNAME;
    }

    /**
     * @param $host
     * @param $parameters
     * @return mixed
     */
    abstract protected function postCurl($host, $parameters);
}