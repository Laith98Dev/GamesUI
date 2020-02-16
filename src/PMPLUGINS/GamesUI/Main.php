<?php 

declare(strict_types=1);

namespace PMPLUGINS\GamesUI;

use pocketmine\plugin\PluginBase as P;
use pocketmine\event\Listener as L;
use pocketmine\utils\TextFormat as TF; 

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent as CL;
use pocketmine\event\player\PlayerRespawnEvent as RS;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;

use pocketmine\item\Item;
use pocketmine\inventory\Inventory;

class Main extends P implements L {
		
	public $cfg;
	
	public function onEnable(){
		
		@mkdir($this->getDataFolder());
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->saveResource("config.yml");
		
		$cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		//$this->config->set("joinCompass", "false");
		$cfg->save();
		
		
	}
	
	public function onDisable() {
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
		switch($cmd->getName()){
			case "games":
				if($sender instanceof Player){
					$this->OpenUI($sender);
				}
			break;
			case "ginfo":
			if($sender instanceof Player){
				$sender->sendMessage(TF::AQUA . "Plugin GamesUI By PM PLUGIN TEAM DEVS: " ."\n" ." Laith Youtuber ". "\n" ." MR QUEEROSE " ."\n" ." Dlyar GamerYT");
			}
			break;
		}
		return true;
	}
	
	public function onJoin(PlayerJoinEvent $EV){
		$cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$cfg->getAll();
        $p = $EV->getPlayer();
        $pi = $p->getInventory();
        $pn = $p->getName();
        $name = $pn;
        $level = $p->getLevel();
		 
		if ($cfg->get("joinCompass") == "true"){
			
		$compass = Item::get(Item::COMPASS);
        $compass->setCustomName("§eGamesUI");
        $pi->setItem(4, $compass);
		}
	}
	
	// on respawn get iteam compass 
	public function onRespawn(RS $ev){
		$cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$cfg->getAll();
		$player = $ev->getPlayer();
		$pi = $player->getInventory();
		$level = $player->getLevel();
		
		// config set compass true or flase
		if ($cfg->get("joinCompass") == "true"){	
		$compass = Item::get(Item::COMPASS);
        $compass->setCustomName("§eGamesUI");
        $pi->setItem(4, $compass);

	}
}
	
	
	 public function setCompass(CL $ev){
		$player = $ev->getPlayer();
		$item = $player->getInventory()->getItemInHand();
		if ($item->getCustomName() == "§eGamesUI"){
			$this->OpenUI($player);
		}
	 }
	 
	public function OpenUI($player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null){
		$result = $data;
		$cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);
		if($result === null){
			return true;
			}
			 switch($result){
				case 0:
					$this->getServer()->dispatchCommand($player, $cfg->get("skywars"));
				break;
					
				case 1:
					$this->getServer()->dispatchCommand($player, $cfg->get("bedwars"));
				break;
				
				case 2:
					$this->getServer()->dispatchCommand($player, $cfg->get("skymlg"));
				break;
				
				case 3:
					$this->getServer()->dispatchCommand($player, $cfg->get("eggwars"));
				break;
				
				case 4:
					$this->getServer()->dispatchCommand($player, $cfg->get("ffa"));
				break;
				
				case 5:
					$this->getServer()->dispatchCommand($player, $cfg->get("mlgblock"));
				break;
				
				case 6:
					$this->getServer()->dispatchCommand($player, $cfg->get("sumo"));
				break;
				
				case 7:
					$this->getServer()->dispatchCommand($player, $cfg->get("survivalgames"));
				break;
				
				case 8:
					$this->getServer()->dispatchCommand($player, $cfg->get("duel"));
				break;
				
				case 9:
					$this->getServer()->dispatchCommand($player, $cfg->get("turfwars"));
				break;
				
				case 10:
				
				break;
				}
		});
		$form->setTitle("§l§bGamesUI");
		$form->setContent("Please Select Game");
		$form->addButton("§l§bSky§l§fWars");
		$form->addButton("§l§bBed§l§fWars");
		$form->addButton("§l§bSky§l§fMLG");
		$form->addButton("§l§bEgg§l§fWars");
		$form->addButton("§l§bFF§l§cA");
		$form->addButton("§l§bMLG§l§fBlock");
		$form->addButton("§l§bSu§l§cmo");
		$form->addButton("§l§bSurvival§l§fGames");
		$form->addButton("§l§bDu§l§cel");
		$form->addButton("§l§bTurf§l§fWars");
		$form->addButton("§l§bEX§l§fIT");

		$form->sendToPlayer($player);
		return $form;
	 }
}
