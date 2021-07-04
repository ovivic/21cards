<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__));

require_once (ROOT . '/obj/Deck.php');
require_once (ROOT . '/obj/Game.php');

//echo $deck->shuffle()->toGameString(), PHP_EOL;
$game = new Game();
$game->shuffle();
$game->addPlayer("John");
$game->addPlayer("Doe");
$game->start();
foreach($game->allPlayers() as $player) {
    $player->printDeck();
}