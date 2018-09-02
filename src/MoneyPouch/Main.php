<?php

namespace MoneyPouch;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat as TF;

use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {

public $plugin;
	
	public function onEnable() {
		
		$this->getServer()->getLogger()->notice("MoneyPouch has been enabled!");
		$this->getServer()->getPluginManager()->registerEvents(new AntiDupe($this), $this);
		
	}
	
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
		
		if(strtolower($command->getName()) === "moneypouch") {
			
			if(count($args) < 2) {
			
				$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::GOLD . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "§5Please use: §d/moneypouch (player) (tier)");
				return true;
			 
			}
			if($sender->hasPermission("moneypouch.command.give") || $sender->isOp()){
				
				if(isset($args[0])) {
				
					$player = $sender->getServer()->getPlayer($args[0]);
					
					if(isset($args[1])) {
						
						switch($args[1]) {
							
							case 1:
							
							$tier1 = Item::get(Item::ENDER_CHEST, 101, 1);
							$tier1->setLore(["Right-Click to see how much money you can get!"]);
							$tier1->setCustomName(TF::RESET . TF::BOLD . TF::LIGHT_PURPLE . "Money Pouch" . TF::RESET . TF::GRAY . " (Tap anywhere)" . PHP_EOL . PHP_EOL . 
							TF::DARK_GRAY . " *" . TF::AQUA . " §aTier Level: " . TF::GRAY . "§21" . PHP_EOL .
							TF::DARK_GRAY . " *" . TF::AQUA . " §bAmount to win: " . TF::GRAY . "§3$10,000 - $25,000");
							
							$player->getInventory()->addItem($tier1);
							
							break;
							
							case 2:
							
							$tier2 = Item::get(Item::ENDER_CHEST, 102, 1);
							$tier2->setLore("Right-Click to see how much money you can get!");
							$tier2->setCustomName(TF::RESET . TF::BOLD . TF::LIGHT_PURPLE . "Money Pouch" . TF::RESET . TF::GRAY . " (Tap anywhere)" . PHP_EOL . PHP_EOL . 
							TF::DARK_GRAY . " *" . TF::AQUA . " Tier Level: " . TF::GRAY . "2" . PHP_EOL .
							TF::DARK_GRAY . " *" . TF::AQUA . " Amount to win: " . TF::GRAY . "$25,000 - $50,000");
							
							$player->getInventory()->addItem($tier2);
							
							break;
							
							case 3:
							
							$tier3 = Item::get(Item::ENDER_CHEST, 103, 1);
							$tier3->setLore("Right-Click to see how much money you can get!");
							$tier3->setCustomName(TF::RESET . TF::BOLD . TF::LIGHT_PURPLE . "Money Pouch" . TF::RESET . TF::GRAY . " (Tap anywhere)" . PHP_EOL . PHP_EOL . 
							TF::DARK_GRAY . " *" . TF::AQUA . " Tier Level: " . TF::GRAY . "3" . PHP_EOL .
							TF::DARK_GRAY . " *" . TF::AQUA . " Amount to win: " . TF::GRAY . "$50,000 - $100,000");
							
							$player->getInventory()->addItem($tier3);
							
							break;
							
							case 4:
							
							$tier4 = Item::get(Item::ENDER_CHEST, 104, 1);
							$tier4->setLore("Right-Click to see how much money you can get!");
							$tier4->setCustomName(TF::RESET . TF::BOLD . TF::LIGHT_PURPLE . "Money Pouch" . TF::RESET . TF::GRAY . " (Tap anywhere)" . PHP_EOL . PHP_EOL . 
							TF::DARK_GRAY . " *" . TF::AQUA . " Tier Level: " . TF::GRAY . "4" . PHP_EOL .
							TF::DARK_GRAY . " *" . TF::AQUA . " Amount to win: " . TF::GRAY . "$100,000 - $500,000");
							
							$player->getInventory()->addItem($tier4);
							
							break;
							
							case 5:
							
							$tier5 = Item::get(Item::ENDER_CHEST, 105, 1);
							$tier5->setLore("Right-Click to see how much money you can get!");
							$tier5->setCustomName(TF::BOLD . TF::LIGHT_PURPLE . "Money Pouch" . TF::RESET . TF::GRAY . " (Tap anywhere)" . PHP_EOL . PHP_EOL . 
							TF::DARK_GRAY . " *" . TF::AQUA . " Tier Level: " . TF::GRAY . "5" . PHP_EOL .
							TF::DARK_GRAY . " *" . TF::AQUA . " Amount to win: " . TF::GRAY . "$500,000 - $1,000,000");
							
							$player->getInventory()->addItem($tier5);
							
							break;
							
						}
					}
				}
			}
			
			if(!$sender->hasPermission("moneypouch.command.give")) {
				
				$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You don't have permission to use this command.");
				
			}
			
			else {
				
				$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::GOLD . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "§aYou have recieved your Money Pouch.");
				
			}
		}
		
		return true;
		
	}
	
	public function onInteract(PlayerInteractEvent $event) {
		
		$player = $event->getPlayer();
		
		if($event->getItem()->getId() === 130) {
		
			$damage = $event->getItem()->getDamage();
			
			switch($damage) {
				
				case 101:
				
				$tier1 = Item::get(Item::ENDER_CHEST, 101, 1);
				$tier1win = rand(10000, 25000);
				
				EconomyAPI::getInstance()->addMoney($player, $tier1win);
				
				$player->addTitle(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You have won:", TF::BOLD . TF::LIGHT_PURPLE . "$" . $tier1win);
				$player->getInventory()->removeItem($tier1);
				$player = $player->getName();
				$this->getServer()->broadcastMessage(TF::BOLD . "§a$player" . "§bhas opened a Money Pouch with Level 1 and has won:" . "§5$$tier1win" . "§cMoney in game!");
				
				break;
				
				case 102:
				
				$tier2 = Item::get(Item::ENDER_CHEST, 102, 1);
				$tier2win = rand(25000, 50000);
				
				EconomyAPI::getInstance()->addMoney($player, $tier2win);
				
				$player->addTitle(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You have won:", TF::BOLD . TF::LIGHT_PURPLE . "$" . $tier2win);
				$player->getInventory()->removeItem($tier2);
				$player = $player->getName();
				$this->getServer()->broadcastMessage(TF::BOLD . "§a$player" . "§bhas opened a Money Pouch with Level 2 and has won:" . "§5$$tier2win" . "§cMoney in game!");
				
				break;
				
				case 103:
				
				$tier3 = Item::get(Item::ENDER_CHEST, 103, 1);
				$tier3win = rand(50000, 100000);
				
				EconomyAPI::getInstance()->addMoney($player, $tier3win);
				
				$player->addTitle(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You have won:", TF::BOLD . TF::LIGHT_PURPLE . "$" . $tier3win);
				$player->getInventory()->removeItem($tier3);
				$player = $player->getName();
				$this->getServer()->broadcastMessage(TF::BOLD . "§a$player" . "§bhas opened a Money Pouch with Level 3 and has won:" . "§5$$tier3win" . "§cMoney in game!");
				
				break;
				
				case 104:
				
				$tier4 = Item::get(Item::ENDER_CHEST, 104, 1);
				$tier4win = rand(100000, 500000);
				
				EconomyAPI::getInstance()->addMoney($player, $tier4win);
				
				$player->addTitle(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You have won:", TF::BOLD . TF::LIGHT_PURPLE . "$" . $tier4win);
				$player->getInventory()->removeItem($tier4);
				$player = $player->getName();
				$this->getServer()->broadcastMessage(TF::BOLD . "§a$player" . "§bhas opened a Money Pouch with Level 1 and has won:" . "§5$$tier4win" . "§cMoney in game!");
				
				break;
				
				case 105:
				
				$tier5 = Item::get(Item::ENDER_CHEST, 105, 1);
				$tier5win = rand(500000, 1000000);
				
				EconomyAPI::getInstance()->addMoney($player, $tier5win);
				
				$player->addTitle(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You have won:", TF::BOLD . TF::LIGHT_PURPLE . "$" . $tier5win);
				$player->getInventory()->removeItem($tier5);
				$player = $player->getName();
				$this->getServer()->broadcastMessage(TF::BOLD . "§a$player" . "§bhas opened a Money Pouch with Level 5 and has won:" . "§5$$tier5win" . "§cMoney in game!");
				
				break;
				
			}
		}
	}
	public function onPlace(BlockPlaceEvent $event) {
		
		if($event->getItem()->getId() == 130) {
			
			$damage = $event->getItem()->getDamage();
			
			if($damage === 101 || $damage === 102 || $damage === 103 || $damage === 104 || $damage === 105) {
				
				$event->setCancelled();
				
			}
		}
	}
}
