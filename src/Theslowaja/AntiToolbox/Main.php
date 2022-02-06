<?php

namespace Theslowaja\AntiToolbox;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\permission\DefaultPermissions;

class Main implements Listener{
    
    private Config $config;

    public function onEnable() : void{
       $this->saveDefaultConfig();
       $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
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
                    foreach (Server::getInstance()->getOnlinePlayers() as $p) {
                       if($player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                          $p->sendMessage(TextFormat::RED . "STAFF > " . TextFormat::WHITE . $player->getName() . " Detected as Toolbox");
                        }
                        $event->getPlayer()->kick($this->config->get("Kick-message"));
                        $this->getServer()->getLogger()->info(TextFormat::RED . "ATB > " . TextFormat::WHITE . $player->getName() . " Detected as Toolbox");
                    }
                }

            }
        }
    }
}
