<?php

namespace Tungsten\FootJob;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class checkUpdate extends AsyncTask
{

    /**
     *
     */
    public function onRun(): void
    {
        $link = 'https://raw.githubusercontent.com/TungstenVn/TungstenVn_poggit_news/master/update.yml';
        $file = @fopen($link, "rb");
        if ($file == false) {
            #print("Fail to get new info");
            return;
        }

        $content = "";
        while (!feof($file)) {
            $line_of_text = fgets($file);
            $content = $content . " " . $line_of_text;
        }
        fclose($file);

        $content = yaml_parse($content);
        $this->setResult($content);
    }

    /**
     * @param Server $server
     */
    public function onCompletion(): void
    {
        if (is_null($fj = FootJob::$instance)) {
            return;
        }

        $content = $this->getResult();
        if (!isset($content)) {
            $fj->getServer()->getLogger()->info("§6[Footjob] Cant get update information");
            return;
        }

        if(!isset($content["footjob_version"])) return;
        $version = $content["footjob_version"];
        if (version_compare($fj->getDescription()->getVersion(), $version) < 0) {
            $fj->getServer()->getLogger()->info("§b[Footjob] New version $version has been released, download at: https://poggit.pmmp.io/p/FootJob/");
        }
    }
}
