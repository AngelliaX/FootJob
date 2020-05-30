<?php

namespace Tungsten\FootJob;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;

class RepeatingTask extends Task implements Listener
{
    public $config;
    private $fj;

    public function __construct(FootJob $fj)
    {
        $this->fj = $fj;
        $config = new Config($fj->getDataFolder() . "config.yml");
        $this->config = $config;
    }


    public function onRun($tick)
    {
        $internalConfig = $this->config->getAll();
        if (!is_array($internalConfig) or count($internalConfig) <= 0) return;
        foreach ($internalConfig as $value) {
            $players = $this->fj->getServer()->getLevelByName($value["level"])->getPlayers();
            if ($players == []) continue;
            $x1 = $value["x"][0][0];
            $x2 = $value["x"][0][1];
            $y1 = $value["y"][0][0];
            $y2 = $value["y"][0][1];
            $z1 = $value["z"][0][0];
            $z2 = $value["z"][0][1];
            foreach ($players as $player) {
                if ($this->isInside($x1-0.9, $x2 + 0.9, $y1-0.9, $y2 + 0.9, $z1-0.9, $z2+0.9, $player)) {
                    if (isset($value["consolecmds"])) {
                        $this->consoleCommand($value["consolecmds"], $player);
                    }
                    if (isset($value["playercmds"])) {
                        $this->playerCommand($value["playercmds"], $player);
                    }
                }
            }
        }
    }

    private function isInside(float $minX, float $maxX, float $minY, float $maxY, float $minZ, float $maxZ, Vector3 $vector)
    {
        if ($vector->x < $minX or $vector->x > $maxX) {
            return false;
        }
        if ($vector->y < $minY or $vector->y > $maxY) {
            return false;
        }

        return $vector->z > $minZ and $vector->z < $maxZ;
    }

    private function consoleCommand(?array $cmds, Player $player)
    {
        $name = $player->getName();
        foreach ($cmds as $cmd) {
            $cmd = str_replace("{name}", $name, $cmd);
            $this->fj->getServer()->dispatchCommand(new ConsoleCommandSender(), $cmd);
        }
    }

    private function playerCommand(?array $cmds, Player $player)
    {
        $name = $player->getName();
        foreach ($cmds as $cmd) {
            $this->fj->getServer()->dispatchCommand($player, $cmd);
        }
    }
}