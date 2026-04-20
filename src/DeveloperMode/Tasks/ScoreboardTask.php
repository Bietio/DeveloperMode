<?php

namespace DeveloperMode\Tasks;

use DeveloperMode\Manager\ScoreboardManager;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\PluginTask;

class ScoreboardTask extends PluginTask
{

    /** @var ScoreboardManager */
    private $scoreboard;

    public function __construct(Plugin $owner, ScoreboardManager $scoreboard)
    {
        $this->scoreboard = $scoreboard;
        
        parent::__construct($owner);
    }

    public function onRun($currentTick)
    {
        $this->scoreboard->show();
    }
}
