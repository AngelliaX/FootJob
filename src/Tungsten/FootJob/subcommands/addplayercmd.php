<?php

namespace Tungsten\FootJob\subcommands;


use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use Tungsten\FootJob\Commands;

class addplayercmd implements Listener
{
    public function __construct(Commands $cmds, CommandSender $sender, array $args)
    {
        if (!isset($args[1])) {
            $sender->sendMessage("§cUse /fj apc <name> <any text as long as you want>");
            return;
        }
        $config = $cmds->fj->task->config;
        if (is_null($config->getNested($args[1]))) {
            $sender->sendMessage("§cCant find arena named §6$args[1]");
            return;
        }
        $cmd = "";
        for ($i = 2; $i < count($args); $i++) {
            $cmd = $cmd . "$args[$i] ";
        }
        if ($cmd == "") {
            $sender->sendMessage("§cCant add an empty command");
            return;
        }
        $name = $args[1];
        $count = $config->getNested("$name.playercmds");
        if ($count == null) {
            $config->setNested("$name.playercmds.0", $cmd);
            $sender->sendMessage("§aSucced add a player command: $cmd");
        } else {
            $count = count($count);
            $config->setNested("$name.playercmds.$count", $cmd);
            $sender->sendMessage("§aSucced add a player command: $cmd");
        }
        $config->save();
    }
}