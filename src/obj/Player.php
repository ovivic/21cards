<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Card.php');

abstract class Player {
    private array $cards = array ();

    public function addCard (Card $card) : Player {
        array_push($this->cards, $card);

        return $this;
    }

    public function handValue () : int {
        $value = 0;
        $aceCount = 0;

        foreach ($this->cards as $card) {
            $value = $value + CardValue::value($card->getValue());
            if ( $card->getValue() === CardValue::ACE )
                $aceCount ++;
        }

        while ($aceCount > 0 && $value + 10 <= 21) {
            $aceCount --;
            $value += 10;
        }

        return $value;
    }

    public function busted () : bool {
        return $this->handValue() > 21;
    }

    public function printDeck () : void {
        foreach($this->cards as $card) {
            echo $card->toGameString(), PHP_EOL;
        }

        echo 'Player hand value : ' . $this->handValue(), PHP_EOL;

        echo PHP_EOL;
    }
}