<?php

namespace DeveloperMode\Services;

use pocketmine\Player;
use pocketmine\utils\TextFormat;

class PlayerService
{

    const SOUTH = 0;

    const WEST  = 1;

    const NORTH = 2;

    const EAST  = 3;

    const UNKNOWN = TextFormat::RED . 'Unknown';

    /**
     * @param int $index
     * @return string
     */
    public static function getDirectionName(int $index): string
    {
        
        switch ($index):
            case self::SOUTH: 
                return TextFormat::WHITE . 'South';

            case self::NORTH: 
                return TextFormat::RED . 'North';

            case self::EAST:  
                return TextFormat::YELLOW . 'East';

            case self::WEST:  
                return TextFormat::GOLD . 'West';

            default:
                return self::UNKNOWN;

        endswitch;
    }

    /**
     * @param string $index
     * @return string
     */
    public static function getGamemodeName(string $index): string
    {
        switch ($index): 
            case Player::SURVIVAL:
                return TextFormat::GREEN . 'Survival';

            case Player::CREATIVE:
                return TextFormat::AQUA . 'Creative';

            case Player::ADVENTURE:
                return TextFormat::YELLOW . 'Adventure';

            case Player::SPECTATOR:
                return TextFormat::LIGHT_PURPLE . 'Spectator';

            default:
                return self::UNKNOWN;

        endswitch;
    }
}
