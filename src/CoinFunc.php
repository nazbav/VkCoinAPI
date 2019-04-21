<?php


namespace nazbav\VkCoinAPI;


/**
 * Class CoinFunc
 * @package nazbav\VkCoinAPI
 */
class CoinFunc extends CoinFuncModel
{


    /**
     * @param $coin
     * @param $all
     * @return float|int
     */
    public function whatPercent($coin, $all)
    {
        return (float)($coin * 1e2) / $all;
    }


    /**
     * @param $id
     * @param $from_id
     * @param $amount
     * @param $payload
     * @param $key
     * @return bool
     */
    public function validationKey($id, $from_id, $amount, $payload, $key)
    {
        return md5(implode(';', [$id, $from_id, $amount, $payload, $this->getMerchkey()])) === $key;
    }

    /**
     * @param int $sum
     * @param bool $fixed_sum
     * @param bool $hex
     * @param int $payload
     * @return string
     */
    public function link($sum = 0, $payload = 0, $fixed_sum = true, $hex = true)
    {

        $merchant_id = $this->getMerchantId();
        $sum = !empty($sum) ? $sum : 1e3;
        $payload = empty($payload) ? rand(-2000000000, 2000000000) : $payload;


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
                $fixed_sum ? "" : "_1"
            );

        } else {

            $link = sprintf('%s#x%s_%s_%s%s', $this->getCoinUrl(),
                $merchant_id,
                $sum,
                $payload,
                $fixed_sum ? "" : "_1"
            );

        }
        return $link;
    }


    /**
     * @param $float
     * @return int
     */
    public function toCoin($float)
    {
        return (int)($float * 1e3);
    }


    /**
     * @param $coin
     * @return float
     */
    public function toFloat($coin)
    {
        return (float)($coin / 1e3);
    }


    /**
     * @param $per
     * @param $coin
     * @return float|int
     */
    public function getPercent($per, $coin)
    {
        return (float)($per / 1e2) * $coin;
    }
}