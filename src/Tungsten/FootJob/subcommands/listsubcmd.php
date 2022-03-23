<?php

namespace Tungsten\FootJob\subcommands;


use pocketmine\command\CommandSender;
use Tungsten\FootJob\Commands;

class listsubcmd
{
    public function __construct(Commands $cmds, CommandSender $sender)
    {
        $config = $cmds->fj->task->config;
        $config = $config->getAll();
        $text = "";
        if (!is_array($config) or count($config) <= 0) {
            $sender->sendMessage("§aNo area found");
            return;
        }
        foreach ($config as $name => $results) {
            if(!is_array($results)) continue;
            $X = $results["x"][0];
            $Y = $results["y"][0];
            $Z = $results["z"][0];
            $text = $text . "§a$name:\n ->X:$X[0]/$X[1],Y:$Y[0]/$Y[1],Z:$Z[0]/$Z[1]\n";
        }
        $sender->sendMessage($text);
    }
}
