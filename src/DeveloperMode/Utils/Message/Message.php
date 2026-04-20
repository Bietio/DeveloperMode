<?php

namespace DeveloperMode\Utils\Message;

use DeveloperMode\DeveloperModeLoader;
use DeveloperMode\Loader;
use pocketmine\Player;
use pocketmine\utils\Config;

class Message
{

    /** @var Config */
    private $config;

    /** @var string */
    private $message;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param string $id
     * @param string $otherwise
     * @return MessageFormatter
     */
    public function message(string $id, string $otherwise = "Not found message")
    {
        $value = $this->config->get($id, $otherwise);

        return new MessageFormatter($value, Loader::getInstance()->getSettings()->getPrefix());
    }
}
