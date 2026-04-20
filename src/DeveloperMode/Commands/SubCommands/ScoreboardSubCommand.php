<?php

namespace DeveloperMode\Commands\SubCommands;

use DeveloperMode\Data\Objects\DeveloperObject;
use DeveloperMode\Loader;
use DeveloperMode\Utils\Message\Message;
use pocketmine\command\CommandSender;
use SmartCommand\command\argument\BoolArgument;
use SmartCommand\command\CommandArguments;
use SmartCommand\command\rule\defaults\CooldownRule;
use SmartCommand\command\subcommand\BaseSubCommand;

class ScoreboardSubCommand extends BaseSubCommand
{

    protected static function getRuntimePermission(): string
    {
        return 'developer.command';
    }

    protected function prepare()
    {
        $this->registerRule(new CooldownRule(CooldownRule::secondsToMs(5)));
        $this->registerArgument(0, new BoolArgument('active', true, 'true', 'false', true));
    }

    protected function onRun(CommandSender $sender, string $commandLabel, string $subcommandLabel, CommandArguments $args)
    {
        $data = Loader::getInstance()->getData();
        $activate = $args->getBool('active');
        $coloredBool = $activate ? '§atrue' : '§cfalse';

        $message  = Loader::getInstance()->getMessage();

        if (!$data->hasData($sender->getName())) 
        {
            $data->setData($sender->getName(), new DeveloperObject(false));
        }

        $user = $data->getData($sender->getName());
        $userObject  = DeveloperObject::toObject($user);
        
        if ($userObject->getScoreboard() === $activate) 
        {
            $msg = $message->message('scoreboard-already-bool');

            $msg->setFormat('type_bool', $coloredBool);
            $msg->send($sender);

            return;
        }

        $userObject->setScoreboard($activate);
        $data->setData($sender->getName(), $userObject);

        $msg = $message->message('scoreboard-activate-changed');

        $msg->setFormat('type_bool', $coloredBool);
        $msg->send($sender);
    }
}
