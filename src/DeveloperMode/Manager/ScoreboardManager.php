<?php

namespace DeveloperMode\Manager;

use DeveloperMode\Data\Data;
use DeveloperMode\Data\Objects\DeveloperObject;
use DeveloperMode\Services\PlayerService;
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

        $gamemode = PlayerService::getGamemodeName($player->getGamemode());
        $direction = PlayerService::getDirectionName($player->getDirection());

        $scoreboard->setFormats([
            'player_name' => $player->getName(),
            'gamemode' => $gamemode,
            'direction' => $direction,
            'item_name' => $itemInHandName,
            'item_id' => $itemInHandId,
            'yaw' => number_format($player->getYaw(), 3, '.', ''),
            'pitch' => number_format($player->getPitch(), 3, '.', ''),
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
