<?php

namespace Tungsten\FootJob\subcommands;


use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use Tungsten\FootJob\Commands;

class addconsolecmd implements Listener
{
    public function __construct(Commands $cmds, CommandSender $sender, array $args)
    {
        if (!isset($args[1])) {
            $sender->sendMessage("§cUse /fj acc <name> <any text as long as you want>");
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
        $count = $config->getNested("$name.consolecmds");
        if ($count == null) {
            $config->setNested("$name.consolecmds.0", $cmd);
            $sender->sendMessage("§aSucced add a console command: $cmd");
        } else {
            $count = count($count);
            $config->setNested("$name.consolecmds.$count", $cmd);
            $sender->sendMessage("§aSucced add a console command: $cmd");
        }
        $config->save();
    }
}