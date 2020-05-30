<?php

namespace Tungsten\FootJob\subcommands;


use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use Tungsten\FootJob\Commands;

class help implements Listener
{
    public function __construct(Commands $cmds, CommandSender $sender, array $args)
    {
        $sender->sendMessage(
            "§a==FootJobHelp==:§r\n/fj list\n/fj aa = /fj addarea\n/fj apc = /fj addplayercommand\n/fj acc = /fj acc\n/fj ra = /fj removearea\nSee full helps on poggit!"
        );
    }
}