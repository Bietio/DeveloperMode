<?php

namespace DeveloperMode\Utils\Message;

use DeveloperMode\DeveloperModeLoader;
use DeveloperMode\Utils\Message\Exception\AlreadyExistsKeyException;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class MessageFormatter
{

    /** @var string */
    private $message;

    /** @var string */
    private $prefix;

    /** @var string[] */
    private $formats;

    public function __construct(string $message, string $prefix = '')
    {
        $this->message = $message;
        $this->prefix  = $prefix;
    }

    /**
     * @param string $key
     * @param string $value
     * @param bool $replace
     * @throws AlreadyExistsKeyException
     * @return void
     */
    public function setFormat(string $key, string $value, bool $replace = true)
    {
        if (isset($this->formats['{'.$key.'}']) && !$replace) 
        {
            throw new AlreadyExistsKeyException("The key \"{$key}\" already exists in formats");
        }

        $this->formats['{'.$key.'}'] = $value;
    }

    /**
     * @param string[] $formats
     * @return void
     */
    public function setFormats(array $formats, bool $replace = true)
    {
        foreach ($formats as $key => $value) 
        {
            $this->setFormat($key, $value, $replace);
        }
    }

    /**
     * @return string
     */
    public function get(bool $withPrefix = true): string
    {
        $message = '';

        $message .= ($withPrefix ? $this->prefix : '');
        $message .= str_replace(
            array_keys($this->formats),
            array_values($this->formats),
            $this->message
        );

        return $message;
    }

    /**
     * @param Player|CommandSender $sender
     * @return void
     */
    public function send($sender, bool $withPrefix = true)
    {
        $sender->sendMessage($this->get($withPrefix));
    }
}
