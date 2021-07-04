<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Player.php');
require_once (ROOT . '/obj/Game.php');

class Dealer extends Player {
    public function deal (array & $cards, array $players) : Dealer {
        foreach ($players as $player) {
            $player->addCard(array_pop($cards));
            $player->addCard(array_pop($cards));
        }

        $this->addCard(array_pop($cards));
        $this->addCard(array_pop($cards));

        return $this;
    }

    public function printDeck() : void {
        echo "Dealer's Deck : \n";
        parent::printDeck();
    }
}