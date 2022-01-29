<?php

namespace xtakumatutix\grassfood;

use pocketmine\block\BlockFactory;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlace(PlayerInteractEvent $event) {
        $block = $event->getBlock();
        if ($block->getID() == 2) {
            $factory = BlockFactory::getInstance();
            $player = $event->getPlayer();
            $vector = $block->getPosition()->asVector3();
            $world = $player->getPosition()->getWorld();
            $grass = $factory->get(3, 0);
            $world->setBlock($vector, $grass);
            if (rand(1, 500) === 5) {
                $player->sendPopup("§a虫ｳﾒｪwwwwww");
                $player->getHungerManager()->addFood(3);
                $this->sendSound($player);
            } else {
                $player->sendPopup("§a草ｳﾒｪwwwwww");
                $player->getHungerManager()->addFood(1);
                $this->sendSound($player);
            }
        }
    }

    public function sendSound(Player $player) {
        $pk = new PlaySoundPacket();
        $pk->soundName = "random.eat";
        $pk->x = $player->getPosition()->x;
        $pk->y = $player->getPosition()->y;
        $pk->z = $player->getPosition()->z;
        $pk->volume = 1;
        $pk->pitch = 1;
        $player->getNetworkSession()->sendDataPacket($pk);
    }

}
