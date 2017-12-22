<?php

namespace AVENDA;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;

class Positon extends PluginBase implements Listener {
	public $config, $cDB;
	public function onEnable() {
		$this->config = new Config ( $this->getDataFolder () . "config.yml", Config::YAML );
		$this->cDB = $this->config->getAll ();
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
	}
	public function Quit(PlayerQuitEvnet $event) {
		$player = $event->getPlayer ();
		$name = strtolower ( $player->getName () );
		$x = $player->x;
		$y = $player->y;
		$z = $player->z;
		$this->cDB [$name] ["position"] = $x . ":" . $y . ":" . $z;
		$this->ConfigSave ();
	}
	public function Join(PlayerJoinEvent $event) {
		$player = $event->getPlayer ();
		$name = $player->getName ();
		unset ( $this->cDB [$name] ["position"] );
		$this->ConfigSave ();
	}
	public function ConfigSave() {
		$this->config->setAll ( $this->cDB );
		$this->config->save ();
	}
}