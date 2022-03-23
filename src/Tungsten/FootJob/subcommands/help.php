<?php

namespace Tungsten\FootJob\subcommands;


use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use Tungsten\FootJob\Commands;

class help implements Listener
{
    public function __construct(CommandSender $sender)
    {
        $sender->sendMessage(
            "§6==FootJobHelp==:§r\n/fj list\n/fj aa = /fj addarea\n/fj apc = /fj addplayercommand\n/fj acc = /fj acc\n/fj ra = /fj removearea\nSee full helps on poggit!\n§6================"
        );
    }
}
