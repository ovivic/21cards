<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Player.php');

class HumanPlayer extends Player {
    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function printDeck() : void {
        echo "$this->name's Deck : \n";
        parent::printDeck();
    }
}