<?php

namespace DeveloperMode\Utils;

use DeveloperMode\DeveloperModeLoader;
use DeveloperMode\Loader;
use pocketmine\utils\Config;

class Settings
{

    const PREFIX = 'prefix';

    const SCOREBOARD = 'scoreboard';

    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param string $key
     * @param string|bool|int $otherwise
     * @param bool $isNested
     * @param bool $consoleWarn
     * @return string|bool|int
     */
    public function getValue(string $key, $otherwise = null, bool $isNested = false, bool $consoleWarn = true)
    {
        $value = ($isNested ? $this->config->getNested($key, null) : $this->config->get($key, null));

        if (is_null($value)) 
        {
            if ($consoleWarn) 
            {
                Loader::getInstance()->getLogger()->warning("Not found key \"{$key}\"");
            }

            return $otherwise;
        }

        return $value;
    }

    public function getInteger(string $key, int $otherwise, bool $isNested = false): int
    {
        return (int) $this->getValue($key, $otherwise, $isNested);
    }
    public function getBoolean(string $key, bool $otherwise, bool $isNested = false): bool
    {
        return (bool) $this->getValue($key, $otherwise, $isNested);
    }
    public function getString(string $key, string $otherwise, bool $isNested = false): string
    {
        return (string) $this->getValue($key, $otherwise, $isNested);
    }

    public function getPrefix(): string
    {
        return $this->getString(self::PREFIX, '');
    }

    public function getScoreboad(): string
    {
        return $this->getString(self::SCOREBOARD, '');
    }
}
