<?
namespace Tungsten\FootJob;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use Tungsten\FootJob\subcommands\addArea;
use Tungsten\FootJob\subcommands\addconsolecmd;
use Tungsten\FootJob\subcommands\addplayercmd;
use Tungsten\FootJob\subcommands\help;
use Tungsten\FootJob\subcommands\listsubcmd;
use Tungsten\FootJob\subcommands\removearena;

class Commands extends Command implements PluginIdentifiableCommand
{
    public $fj;

    public function __construct(FootJob $fj)
    {
        parent::__construct("fj", "FootJobs Commands");
        $this->setPermission("footjob.permission");
        $this->fj = $fj;
    }


    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage("§cYou dont have permission to use");
            return;
        }
        if (!isset($args[0])) {
            $args[0] = "help";
        }
        if (strtolower($args[0]) == "addarea" or strtolower($args[0]) == "aa") {
            if (!isset($args[1])) {
                $sender->sendMessage("§aThe area must have a name,/fj aa <name>");
                return;
            }
            if (!$sender instanceof Player) {
                $sender->sendMessage("§cOnly use in-game");
                return;
            }
            $cmd = new addArea($this, $sender, $args);
            $this->fj->getServer()->getPluginManager()->registerEvents($cmd, $this->fj);
        } else if (strtolower($args[0]) == "list") {
            $cmd = new listsubcmd($this, $sender, $args);
        } else if (strtolower($args[0]) == "addplayercmd" or strtolower($args[0]) == "apc") {
            $cmd = new addplayercmd($this, $sender, $args);
        } else if (strtolower($args[0]) == "addconsolecmd" or strtolower($args[0]) == "acc") {
            $cmd = new addconsolecmd($this, $sender, $args);
        } else if (strtolower($args[0]) == "removearea" or strtolower($args[0]) == "ra") {
            $cmd = new removearena($this, $sender, $args);
        } else {
            $cmd = new help($this, $sender, $args);
        }
    }

    public function getPlugin(): Plugin
    {
        return $this->fj;
    }
}