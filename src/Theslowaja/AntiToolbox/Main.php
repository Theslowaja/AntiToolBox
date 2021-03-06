<?php

namespace Theslowaja\AntiToolbox;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\permission\DefaultPermissions;

class Main  extends PluginBase implements Listener{
    
    private Config $config;

    public function onEnable(): void{
       $this->saveDefaultConfig();
       $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onLogin(PlayerLoginEvent $event){
        $player = $event->getPlayer();
        $extradata = $player->getPlayerInfo()->getExtraData();
        $os = (int)$extradata["DeviceOS"];
        $model = (string)$extradata["DeviceModel"];
        if($os == 1){
            $devicemodel = explode(" ", $model);
            if(isset($devicemodel[0])){
                $model = strtoupper($devicemodel[0]);
                if($model !== $devicemodel[0]){
                    foreach ($this->getServer()->getOnlinePlayers() as $p) {
                       if($player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                          $p->sendMessage(TextFormat::RED . "STAFF > " . TextFormat::WHITE . $player->getName() . " Detected as Toolbox");
                        }
                        $player->kick($this->config->get("Kick-message"));
                    }
                }

            }
        }
    }
}
