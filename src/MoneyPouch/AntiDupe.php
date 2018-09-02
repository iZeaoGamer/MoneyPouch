<?php

namespace MoneyPouch;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat;
use MoneyPouch\Main;

class AntiDupe implements Listener{
	
	public $plugin;
	
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	
	#Thanks to JackMD for providing help with this part!
 	public function onInteract(PlayerInteractEvent $event){
		$p = $event->getPlayer();
		$name = $p->getName();
		$inv = $p->getInventory();
		$hand = $inv->getItemInHand();
		$lore = $hand->getLore();
		$cancel = $this->plugin->onInteract($event);
		if (!empty($lore)) {
			if(TextFormat::clean($lore[0]) == 'Right-Click to see how much money you can get!'){
				switch($event->getBlock()->getName()){
					
				case "Item Frame":
				case "Anvil":
				case "Crafting Table":
				case "Furnace":
				case "Chest":
				case "Brewing Stand":
				case "Cake":
				case "Door":
				case "Wooden Door":
				case "Wooden Button":
				case "Stone Button":
				case "Enchanting Table":
				case "Ender Chest":
				case "Fence Gate":
				case "Iron Door":
				case "Stonecutter":
				case "Trapped Chest":
				case "Wooden Trapdoor":
				case "Bed":
					$p->sendMessage(TextFormat::RED.TextFormat::BOLD."Error: ".TextFormat::RESET.TextFormat::GRAY."you are not allowed to place this item in an item frame.");
					$event->setCancelled(true);
					break;
			}
		}
	}
}
}