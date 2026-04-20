<?php

/*
 * ██████╗ ██╗███████╗████████╗██╗ ██████╗ 
 * ██╔══██╗██║██╔════╝╚══██╔══╝██║██╔═══██╗
 * ██████╔╝██║█████╗     ██║   ██║██║   ██║
 * ██╔══██╗██║██╔══╝     ██║   ██║██║   ██║
 * ██████╔╝██║███████╗   ██║   ██║╚██████╔╝
 * ╚═════╝ ╚═╝╚══════╝   ╚═╝   ╚═╝ ╚═════╝ 
 * ------------------------------------------
 * @author  Emerson L. (Bietio)
 * @link https://github.com/Bietio/ResourceLoader
 */

declare(strict_types=1);

namespace DeveloperMode\Utils;

use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

use Exception;

final class ResourceLoader
{

    const DIRECTORY = "directory";

    const FILE = "file";

    /** @var PluginBase */
    private static $plugin = null;

    /**
     * @param Plugin $plugin
     * @param string $file
     * @throws Exception
     * @return void
     */
    public static function init(Plugin $plugin, string $file)
    {
        self::$plugin = $plugin;

        if(strpos($file, ".phar") === true) 
        {
            $file = "phar://" . $file;
        }

        $pluginFile = new Config($file . 'plugin.yml', Config::YAML);

        /** @var string[] */
        $resources = (array) $pluginFile->get("resources");

        if ($resources === false) 
        {
            throw new Exception("The key \"resources\" not is setted");
        }

        foreach ($resources as $resource) 
        {
            $path = self::withDataFolder($resource);

            $directory = (string) pathinfo($path, PATHINFO_DIRNAME);
            $basename = (string) pathinfo($path, PATHINFO_BASENAME);

            if (!self::isLoaded($directory, self::DIRECTORY)) 
            {
                mkdir($directory, 0777, true);
            } 

            if (!self::isLoaded($path, self::FILE) && $basename !== ".") 
            {
                if ($plugin->saveResource($resource) === false) 
                    throw new Exception("File \"{$resource}\" not found in the resources folder");
            }
        }
    }

    /**
     * @param string $file
     * @throws Exception
     * @return string
     */
    public static function withDataFolder(string $file): string
    {
        if (is_null(self::$plugin)) 
        {
            throw new Exception("Need init the ResourceLoader");
        }

        return (string) self::$plugin->getDataFolder() . $file;
    }

    public static function isLoaded(string $resource, string $type = self::DIRECTORY): bool
    {
        if (is_dir($resource) && $type === self::DIRECTORY) 
        {
            return true;
        }

        if (is_file($resource) && $type === self::FILE) 
        {
            return true;
        }

        return false;
    }
}
