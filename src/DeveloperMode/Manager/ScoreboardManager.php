<?php

namespace DeveloperMode\Manager;

use DeveloperMode\Data\Data;
use DeveloperMode\Data\Objects\DeveloperObject;

use DeveloperMode\Utils\Settings;
use DeveloperMode\Utils\Message\MessageFormatter as Message;

use pocketmine\item\Item;

use pocketmine\Server;
use pocketmine\Player;

class ScoreboardManager
{

    /** @var Data */
    private $data;

    /** @var Server */
    private $server;

    /** @var Settings */
    private $settings;

    public function __construct(
        Data $data, 
        Settings $settings
    )
    {
        $this->data = $data;
        $this->server = Server::getInstance();
        $this->settings = $settings;
    }

    /**
     * @return array<Player|null>
     */
    public function getAvaliablePlayers(): array
    {
        $playersName = array_keys($this->data->getData());
        $players = [];
        
        foreach ($playersName as $name) 
        {
            if (DeveloperObject::toObject($this->data->getData($name))->getScoreboard()) 
            {
                $players[] = $this->server->getPlayerExact($name);
            }
        }

        return $players;
    }

    /**
     * @param Player $player
     * @return string
     */
    public function getScoreboard(Player $player): string
    {
        $scoreboard = new Message($this->settings->getScoreboad());

        /** @var Item */
        $item = $player->getItemInHand();
        $itemInHandName = $item->getName();
        $itemInHandId = "{$item->getId()}:{$item->getDamage()}";
        $gamemode = '';

        switch ($player->getGamemode()) 
        {
            case Player::SURVIVAL:
                $gamemode = '§aSurvival';
                break;
            case Player::CREATIVE:
                $gamemode = '§bCreative';
                break;
            case Player::ADVENTURE:
                $gamemode = '§eAdventure';
                break;
            case Player::SPECTATOR:
            case Player::VIEW:
                $gamemode = '§dSpectator';
                break;
            default:
                $gamemode = '§cUnknown';
                break;
        }

        $scoreboard->setFormats([
            'player_name' => $player->getName(),
            'gamemode' => $gamemode,
            'item_name' => $itemInHandName,
            'item_id' => $itemInHandId,
            'x' => number_format($player->getX(), 3, '.', ''),
            'y' => number_format($player->getY(), 3, '.', ''),
            'z' => number_format($player->getZ(), 3, '.', ''),
            'level' => $player->getLevel()->getName(),
            'l' => str_repeat(' ', 65)
        ], false);

        return $scoreboard->get(false);        
    }

    /**
     * @return void
     */
    public function show()
    {
        $players = $this->getAvaliablePlayers();

        foreach ($players as $player) 
        {
            if ($player !== null) 
            {
                $player->sendTip($this->getScoreboard($player));
            }
        }
    }
}
