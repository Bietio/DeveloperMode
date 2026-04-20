<?php

namespace DeveloperMode;

use DeveloperMode\Commands\DeveloperCommand;
use DeveloperMode\Data\Data;
use DeveloperMode\Manager\ScoreboardManager;
use DeveloperMode\Tasks\ScoreboardTask;

use DeveloperMode\Utils\Message\Message;
use DeveloperMode\Utils\Settings;
use DeveloperMode\Utils\ResourceLoader;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use SmartCommand\api\SmartCommandAPI;
use SmartCommand\utils\SingletonTrait;

class Loader extends PluginBase
{

    use SingletonTrait;

    /** @var Settings */
    private $settings;

    /** @var Message */
    private $message;

    /** @var Data */
    private $data;

    public function onLoad()
    {
        self::setInstance($this);
        ResourceLoader::init($this, $this->getFile());
    }

    public function onEnable()
    {
        $this->settings = new Settings(new Config(ResourceLoader::withDataFolder('config.yml')));
        $this->message = new Message(new Config(ResourceLoader::withDataFolder('messages.yml')));
        $this->data = new Data();

        $this->getServer()->getScheduler()->scheduleRepeatingTask(new ScoreboardTask(
            self::getInstance(),
            new ScoreboardManager($this->data, $this->settings)
        ), 20);

        SmartCommandAPI::register('developer', new DeveloperCommand());
    }

    /**
     * @return Settings
     */
    public function getSettings(): Settings
    {
        return $this->settings;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @return Data
     */
    public function getData(): Data
    {
        return $this->data;
    }
}
