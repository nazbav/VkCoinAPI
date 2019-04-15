<?php
/**
 * Created by PhpStorm.
 * User: Назым
 * Date: 15.04.2019
 * Time: 20:44
 */

namespace nazbav\VkCoinAPI;


class VkCoinMessages
{
    /**
     * @var
     */
    private static $messages = null;

    /**
     *
     */
    static function msg()
    {
        if (!self::$messages) {
            self::setMessages(include_once '../config/Language.php');
        }
        return self::getMessages();
    }

    /**
     * @param mixed $messages
     */
    private static function setMessages($messages)
    {
        self::$messages = $messages;
    }

    /**
     * @return mixed
     */
    private static function getMessages()
    {
        return self::$messages;
    }

}