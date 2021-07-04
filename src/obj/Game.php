<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Deck.php');
require_once (ROOT . '/obj/Player.php');
require_once (ROOT . '/obj/HumanPlayer.php');
require_once (ROOT . '/obj/Dealer.php');

class Game {
    private array $cards = array();

    private Dealer $dealer;
    private array $players = array();

    public function getDealer(): Dealer {
        return $this->dealer;
    }

    public function addPlayer(string|Player $player): Game {
        if ( is_string($player) )
            $player = new HumanPlayer($player);

        array_push($this->players, $player);
        return $this;
    }

    public function players (): array {
        return $this->players;
    }

    public function allPlayers (): array {
        $players = array();
        foreach($this->players as $player) array_push($players, $player);
        array_push($players, $this->dealer);
        return $players;
    }

    public function dealer () : Dealer {
        return $this->dealer;
    }

    public function start () : Game {
        $this->dealer->deal($this->cards, $this->players);
        return $this;
    }

    public function __construct(int $deckCount = 1) {
        for ( $i = 0; $i < $deckCount; $i++ ) {
            $deck = new Deck();

            foreach($deck->getCards() as $card)
                array_push($this->cards, $card);
        }

        $this->dealer = new Dealer();
    }

    public static function singleDeckGame () : Game {
        return new Game();
    }

    public static function regularGame () : Game {
        return new Game(rand(2, 6));
    }

    #[Pure] public function toString () : string {
        $str = "Cards : [\n";
        foreach($this->cards as $card) {
            $str = $str . "\t" . $card->toString() . "\n";
        }
        return $str . "]";
    }

    #[Pure] public function toGameString () : string {
        $str = "Cards : [\n";
        foreach($this->cards as $card) {
            $str = $str . "\t" . $card->toGameString() . "\n";
        }
        return $str . "]";
    }

    public function shuffle (int $swapCount = 10000) : Game {
        for ($i = 0; $i < $swapCount; $i++) {
            $leftCard = rand(0, count($this->cards) - 1);
            $rightCard = rand(0, count($this->cards) - 1);

            while ($leftCard == $rightCard)
                $rightCard = rand(0, count($this->cards) - 1);

            $auxCard = $this->cards[$leftCard];
            $this->cards[$leftCard] = $this->cards[$rightCard];
            $this->cards[$rightCard] = $auxCard;
        }

        return $this;
    }
}