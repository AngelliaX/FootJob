<?php

namespace Tungsten\FootJob\subcommands;


use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use Tungsten\FootJob\Commands;

class addArea implements Listener
{
    public $cmds;
    private $playerName;
    private $check = [];
    private $isStop = false;
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
        if ($this->isStop) return;
        $player = $ev->getPlayer();
        if ($player->getName() != $this->playerName) return;
        $ev->setCancelled();
        $block = $ev->getBlock();
        $this->check[count($this->check)] = [$block->x, $block->y, $block->z];
        if (count($this->check) >= 2) {
            $this->isStop = true;
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

        $config->setNested("$areaName.x", [($x1 <= $x2) ? [$x1, $x2] : [$x2, $x1]]);
        $config->setNested("$areaName.y", [($y1 <= $y2) ? [$y1, $y2] : [$y2, $y1]]);
        $config->setNested("$areaName.z", [($z1 <= $z2) ? [$z1, $z2] : [$z2, $z1]]);
        $config->setNested("$areaName.level",$player->getLevel()->getName());
        $config->save();
    }

    public function onQuit(PlayerQuitEvent $ev)
    {
        if ($this->isStop) return;
        if ($ev->getPlayer()->getName() == $this->playerName) {
            $this->isStop = true;
        }
    }
}