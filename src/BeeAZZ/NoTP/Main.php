<?php

namespace BeeAZZ\NoTP;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class Main extends PluginBase implements Listener {

    private $enabled = [];

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
    if((strtolower($cmd->getName()) == "notp") && !(isset($args[0])) && ($sender instanceof Player) && ($sender->hasPermission("notp.command"))) {
    if(isset($this->enabled[strtolower($sender->getName())])) {
    unset($this->enabled[strtolower($sender->getName())]);
        } else {
      $this->enabled[strtolower($sender->getName())] = strtolower($sender->getName());
            }
    if(isset($this->enabled[strtolower($sender->getName())])) {
    $sender->sendMessage("Enable NoTP");
        } else {
    $sender->sendMessage("Disable NoTP");
            }
            return true;
        } else {
            return false;
        }
    }

    public function onPlayerCommand(PlayerCommandPreprocessEvent $event) {
        if ($event->isCancelled()) return;
        $message = $event->getMessage();
        if (strtolower(substr($message, 0, 3)) == "/tp" || strtolower(substr($message, 0, 5)) == "/call" || strtolower(substr($message, 0, 7)) == "/tphere" || strtolower(substr($message, 0, 4)) == "/tpa") {
            $args = explode(" ", $message);
        if (!isset($args[1])) {
                return;    
            }
            $sender = $event->getPlayer();

       foreach ($this->enabled as $notpuser) {

       if((strpos(strtolower($notpuser), strtolower($args[1])) !== false) && (strtolower($notpuser) !== strtolower($sender->getName()))) {
       $sender->sendMessage("§c§l☞ This Player Is Not Accepting TP");
       $event->cancel();
                    return;
                }

       if(isset($args[2]) && strpos(strtolower($notpuser), strtolower($args[2])) !== false && (strtolower($notpuser) !== strtolower($sender->getName()))) {
       $sender->sendMessage("§c§l☞ This Player Is Not Accepting TP");
       $event->cancel();
                    return;
                }
            }
        }
    }
}