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
    public function messages()
    {
        if (!self::$messages) {
            self::setMessages(include_once '../config/Language.php');
        }
        return self::getMessages();
    }

    /**
     * @param mixed $messages
     */
    private function setMessages($messages)
    {
        self::$messages = $messages;
    }

    /**
     * @return mixed
     */
    private function getMessages()
    {
        return self::$messages;
    }

}