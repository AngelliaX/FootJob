<?php

namespace Tungsten\FootJob\subcommands;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\HandlerList;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use Tungsten\FootJob\Commands;

class addArea implements Listener
{
    public $cmds;
    private $playerName;
    private $check = [];
    private $args;

    public function __construct(Commands $cmds, Player $sender, array $args)
    {
        $this->cmds = $cmds;
        $sender->sendMessage("§aTap 2 block to set the coordinates");
        $this->args = $args;
        $this->playerName = $sender->getName();
    }

    public function breakBlock(BlockBreakEvent $ev)
    {
        $player = $ev->getPlayer();
        if ($player->getName() != $this->playerName) return;
        $ev->cancel();
        $block = $ev->getBlock();
        $this->check[count($this->check)] = [$block->getPosition()->x, $block->getPosition()->y, $block->getPosition()->z];
        if (count($this->check) >= 2) {
            $name = $this->args[1];
            $player->sendMessage("§aFinishing adding area §6$name §a,/fj list");
            $this->finish($player);
            return;
        }
        $player->sendMessage("§aFirst coordinates setted");
    }

    private function finish(Player $player)
    {
        $config = $this->cmds->fj->task->config;
        $areaName = $this->args[1];
        $x1 = $this->check[0][0];
        $x2 = $this->check[1][0];
        $y1 = $this->check[0][1];
        $y2 = $this->check[1][1];
        $z1 = $this->check[0][2];
        $z2 = $this->check[1][2];

        /*
        ->when you use $block->getPosition(),the returned value will be the lower number.
        Example:
        ->a X coord of a block is 160,it's will be 160 and 161 in two side,at middle point)
        ->a X coord is -160,it's -160,-159
        */
        $config->setNested("$areaName.x", [($x1 <= $x2) ? [$x1, $x2+1] : [$x2, $x1+1]]);
        $config->setNested("$areaName.y", [($y1 <= $y2) ? [$y1, $y2+1] : [$y2, $y1+1]]);
        $config->setNested("$areaName.z", [($z1 <= $z2) ? [$z1, $z2+1] : [$z2, $z1+1]]);
        $config->setNested("$areaName.level", $player->getWorld()->getFolderName());
        $config->save();

        HandlerList::getInstance()->unregister($this);
    }

    public function onQuit(PlayerQuitEvent $ev)
    {
        if ($ev->getPlayer()->getName() == $this->playerName) {
            HandlerList::getInstance()->unregister($this);
        }
    }
}
