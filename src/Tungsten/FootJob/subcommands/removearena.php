<?php

namespace Tungsten\FootJob\subcommands;


use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use Tungsten\FootJob\Commands;

class removearena implements Listener
{
    public function __construct(Commands $cmds, CommandSender $sender, array $args)
    {
        if (!isset($args[1])) {
            $sender->sendMessage("§cUse /fj ra <name> to delete an area");
            return;
        }
        $config = $cmds->fj->task->config;
        if ($config->getNested($args[1]) == null) {
            $sender->sendMessage("§cCant find area named $args[1]");
            return;
        }
        $config->removeNested($args[1]);
        $sender->sendMessage("§aSuccedd remove area named $args[1]");
        $config->save();
    }
}