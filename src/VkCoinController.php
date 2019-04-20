<?php


namespace nazbav\VkCoinAPI;


/**
 * Class VkCoinController
 * @package nazbav\VkCoinAPI
 */
abstract class VkCoinController
{

    /**
     *
     */
    const COIN_URL = 'vk.com/coin';

    /**
     *
     */
    const HOSTNAME = 'coin-without-bugs.vkforms.ru/merchant';

    /**
     * @var
     */
    protected $directory;

    /**
     * @var
     */
    protected $response;

    /**
     * @var bool
     */
    protected $checkResponse = true;

    /**
     * @var
     */
    protected $messages;

    /**
     * @var
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
     * @return string
     */
    protected function getMerchkey()
    {
        return $this->merchkey;
    }


    /**
     * @param $merchkey
     */
    protected function setMerchkey($merchkey)
    {
        $this->merchkey = $merchkey;
    }

    /**
     * @return int
     */
    protected function getMerchantId()
    {
        return $this->merchantId;
    }


    /**
     * @param $merchantId
     */
    protected function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
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
     * @return mixed
     */
    protected function getMessages()
    {
        return $this->messages;
    }


    /**
     * @param array $Messages
     */
    protected function setMessages(array $Messages)
    {
        $this->messages = $Messages;
    }

    /**
     * @return string
     */
    protected function getCoinUrl()
    {
        return self::COIN_URL;
    }


    /**
     * @return mixed
     */
    protected function getDirectory()
    {
        return $this->directory;
    }


    /**
     * @param $directory
     */
    protected function setDirectory($directory)
    {
        $this->directory = $directory;
    }


    /**
     * @param $dir
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
     * @param $key
     */
    protected function setKey($key)
    {
        $this->merchkey = $key;
    }


    /**
     * @return mixed
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
     * @return bool
     */
    protected function getCheckResponse()
    {
        return $this->checkResponse;
    }


    /**
     * @param $checkResponse
     */
    protected function setCheckResponse($checkResponse)
    {
        $this->checkResponse = $checkResponse;
    }


    /**
     * @return mixed
     */
    protected function getResponse()
    {
        return $this->response;
    }


    /**
     * @param $response
     */
    protected function setResponse($response)
    {
        $this->response = $response;
    }


    /**
     * @return string
     */
    protected function getHost()
    {
        return self::HOSTNAME;
    }
}