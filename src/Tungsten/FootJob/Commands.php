<?php
namespace Tungsten\FootJob;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use Tungsten\FootJob\subcommands\addArea;
use Tungsten\FootJob\subcommands\addconsolecmd;
use Tungsten\FootJob\subcommands\addplayercmd;
use Tungsten\FootJob\subcommands\help;
use Tungsten\FootJob\subcommands\listsubcmd;
use Tungsten\FootJob\subcommands\removearena;

class Commands extends Command implements PluginOwned
{
    public $fj;

    public function __construct(FootJob $fj)
    {
        $this->fj = $fj;
        parent::__construct("fj", "FootJobs Commands");
        $this->setPermission("footjob.permission");
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->fj;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage("§cYou dont have permission to use");
            return;
        }
        if (!isset($args[0])) {
            $sender->sendMessage("§cMissing some arguments!,try /fj help");
            return;
        }
        if (strtolower($args[0]) == "addarea" or strtolower($args[0]) == "aa") {
            if (!isset($args[1])) {
                $sender->sendMessage("§cThe area must have a name,/fj aa <name>");
                return;
            }
            if (!$sender instanceof Player) {
                $sender->sendMessage("§cOnly use in-game");
                return;
            }
            $cmd = new addArea($this, $sender, $args);
            $this->fj->getServer()->getPluginManager()->registerEvents($cmd, $this->fj);
        } else if (strtolower($args[0]) == "list") {
            $cmd = new listsubcmd($this, $sender);
        } else if (strtolower($args[0]) == "addplayercmd" or strtolower($args[0]) == "apc") {
            $cmd = new addplayercmd($this, $sender, $args);
        } else if (strtolower($args[0]) == "addconsolecmd" or strtolower($args[0]) == "acc") {
            $cmd = new addconsolecmd($this, $sender, $args);
        } else if (strtolower($args[0]) == "removearea" or strtolower($args[0]) == "ra") {
            $cmd = new removearena($this, $sender, $args);
        } else if(strtolower($args[0]) == "help"){
        	$cmd = new help($sender);
        }else {
            $sender->sendMessage("§cNo command was found!,try /fj help");
        }
    }

    public function getPlugin(): Plugin
    {
        return $this->fj;
    }
}
