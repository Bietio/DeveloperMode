<?php

namespace DeveloperMode\Commands;

use DeveloperMode\Commands\SubCommands\ScoreboardSubCommand;
use pocketmine\command\CommandSender;
use SmartCommand\command\CommandArguments;
use SmartCommand\command\rule\defaults\OnlyInGameCommandRule;
use SmartCommand\command\SmartCommand;
use SmartCommand\message\CommandMessages;

class DeveloperCommand extends SmartCommand
{

    public function __construct()
    {
        parent::__construct(
            'developer',
            'Main command of DeveloperMode',
            SmartCommand::DEFAULT_USAGE_PREFIX,
            ['dev']
        );
    }

    protected static function getRuntimePermission(): string
    {
        return 'developer.command';
    }

    protected function prepare()
    {
        $this->registerRule(new OnlyInGameCommandRule);
        $this->registerSubCommands([
            new ScoreboardSubCommand($this, 'scoreboard', 'Show an scoreboard with some infos', ['score', 'task'])
        ]);
    }

    protected function onRun(CommandSender $sender, string $label, CommandArguments $args)
    {
        
    }
}
