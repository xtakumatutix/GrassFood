<?php

namespace xtakumatutix\grassfood;

use pocketmine\plugin\PluginBase;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\math\Vector3;

use pocketmine\player\Player;
use pocketmine\entity\HungerManager;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;

Class Main extends PluginBase implements Listener
{
    public function onEnable() :void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlace(PlayerInteractEvent $event)
    {
        $block = $event->getBlock();
        if ($block->getID() == 2){
            $factory = BlockFactory::getInstance();

            $player = $event->getPlayer();

            $vector = $block->getPosition()->asVector3();
            $world = $player->getPosition()->getWorld();
            $grass = $factory->get(3,0);

            $world->setBlock($vector, $grass);
            $player->sendPopup("§a草ｳﾒｪwwwwww");
            $player->getHungerManager()->addFood(1);
            $this->sendSound($player);
        }
    }

    public function sendSound (Player $player)
    {
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