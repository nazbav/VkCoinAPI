<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 15.04.2019
 * Time: 20:05
 */

namespace nazbav\VkCoinAPI;


/**
 * Class VkConModel
 * @package nazbav\VkCoinAPI
 */
class VkConModel extends VkCoinController
{

    /**
     * @var
     */
    private $response;

    /**
     * @param $method
     * @return array|false|mixed|string
     */
    protected function callAPI($method)
    {
        $host = sprintf('https://%s/%s/', $this->getHost(), $method);
        $response = $this->postCurl($host, $this->getParams());
        $response = json_decode($response, true);

        if ($response) {
            $return = ['status' => true];
            if (isset($response['error'])) {
                $return['status'] = false;
                $return['error'] = $response['error'];
            } else {
                $return['response'] = $response['response'];
                //Ловим ошибки и получаем ответ
            }
            return $return;
        }
        return [];
    }

    /**
     * @param $host
     * @param $parameters
     * @return false|mixed|string
     */
    protected function postCurl($host, $parameters)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $host,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => json_encode($parameters, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        $return = curl_exec($ch);
        if (curl_error($ch))
            return json_encode(['status' => false, 'response' => ['code' => 100, 'message' => curl_error($ch)]]);
        curl_close($ch);
        return $return;

    }

    /**
     * @return void
     * @throws VkCoinException
     */
    protected function checkResponse()
    {
        if ($this->getCheckResponse()) {
            $response = $this->getResponse();
            if (is_array($response)) {
                if ($response['status'] == false && isset($response['error']))
                    switch ($response['error']['code']) {
                        case 422:
                            $error = VkCoinMessages::msg()['COIN_FERROR_METHOD_PARAMETERS'];
                            switch ($response['error']['message']) {
                                case 'BAD_ARGS':
                                    $error = VkCoinMessages::msg()['COIN_FERROR_METHOD_BAD_ARGS'];
                                    break;
                                case 'merchantId or key is not valid':
                                    $error = VkCoinMessages::msg()['COIN_FERROR_INVALID_IDRKEY'];
                                    break;
                                case 'tx is empty':
                                    $error = VkCoinMessages::msg()['COIN_FERROR_METHOD_INVALID_TX'];
                                    break;

                            }
                            throw new VkCoinException($error);
                            break;
                        case 100:
                            throw new VkCoinException($response['error']['message']);
                            break;
                        default:
                            throw new VkCoinException(VkCoinMessages::msg()['COIN_FERROR_METHOD_PARAMETERS']);
                            break;
                    }
                elseif ($response['status'] == true && isset($response['response'])) {
                    if (isset($response['response'][0]['from_id']) && $response['response'][0]['from_id'] == 'hs')
                        throw new VkCoinException(VkCoinMessages::msg()['COIN_TRANSFER_PARAM_ERROR']);;
                } elseif (isset($response['response']) && empty($response['response'])) {
                    throw new VkCoinException(VkCoinMessages::msg()['COIN_FERROR_METHOD_PARAMETERS']);
                }
            } else  throw new VkCoinException(VkCoinMessages::msg()['COIN_FATAL']);
        }
    }

    /**
     * @return mixed
     */
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    protected function setResponse($response)
    {
        $this->response = $response;
    }
}