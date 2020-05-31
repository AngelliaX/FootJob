<?php

namespace Tungsten\FootJob;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class FootJob extends PluginBase implements Listener
{

    public static $instance;
    public $task;

    public function onEnable()
    {
        self::$instance = $this;

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $cmds = new Commands($this);
        $this->getServer()->getCommandMap()->register("footjob", $cmds);

        $this->task = new RepeatingTask($this);
        $this->getScheduler()->scheduleRepeatingTask($this->task, 1);

        $config = $this->task->config;
        if ($config->getNested("enableUpdateChecker") == null) {
            $config->setNested("enableUpdateChecker", true);
            $config->save();
        }
        if ($config->getNested("enableUpdateChecker") != false) {
            $this->getServer()->getAsyncPool()->submitTask(new checkUpdate());
        }
    }

    public function onDisable()
    {
        //dont need this anymore cuz i'll save the config everytime a player set something new
        #$this->task->config->save();
    }

}