<?php

namespace Tungsten\FootJob;

use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
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


    public function onRun(): void
    {
        $internalConfig = $this->config->getAll();
        if (!is_array($internalConfig) or count($internalConfig) <= 0) return;
        foreach ($internalConfig as $value) {
            if(!is_array($value)) continue;
            $players = $this->fj->getServer()->getWorldManager()->getWorldByName($value["level"])->getPlayers();
            if ($players == []) continue;
            $x1 = $value["x"][0][0];
            $x2 = $value["x"][0][1];
            $y1 = $value["y"][0][0];
            $y2 = $value["y"][0][1];
            $z1 = $value["z"][0][0];
            $z2 = $value["z"][0][1];
            foreach ($players as $player) {
                if ($this->isInside($x1, $x2, $y1, $y2, $z1, $z2, $player->getPosition()->asVector3())) {
                    if (isset($value["consolecmds"])) {
                        $this->consoleCommand($value["consolecmds"], $player);
                    }
                    if (isset($value["playercmds"])) {
                        $this->playerCommand($value["playercmds"], $player);
                    }
                    $this->sound($player);
                }
            }
        }
    }
    private function sound(Player $player){
        $pos = $player->getPosition();
        $sound = new PlaySoundPacket();
        $sound->x = $pos->getX();
        $sound->y = $pos->getY();
        $sound->z = $pos->getZ();
        $sound->volume = 1;
        $sound->pitch = 1;
        $sound->soundName = "mob.endermen.portal";
        $player->getNetworkSession()->sendDataPacket($sound);
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
            $this->fj->getServer()->dispatchCommand(new ConsoleCommandSender($this->fj->getServer(), $this->fj->getServer()->getLanguage()), $cmd);
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
