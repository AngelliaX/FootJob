<?php

namespace Tungsten\FootJob;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class FootJob extends PluginBase implements Listener
{

    public $task;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $cmds = new Commands($this);
        $this->getServer()->getCommandMap()->register("footjob", $cmds);
        $this->task = new RepeatingTask($this);
        $this->getScheduler()->scheduleRepeatingTask($this->task, 1);
    }

    public function onDisable()
    {
        //dont need this anymore cuz i'll save the config everytime a player set something new
        #$this->task->config->save();
    }

}