<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Card.php');

/**
 * Class Player - Base for Game Players ( Dealer / HumanPlayer )
 */
abstract class Player {
    /**
     * @var Card[] - Cards in a player's hand
     */
    private array $cards = array ();

    /**
     * Getter
     * @return Card[]
     */
    protected function cards () : array {
        return $this->cards;
    }

    /**
     * Function used to add a card to the deck
     * @param Card $card
     * @return $this
     */
    public function addCard (Card $card) : Player {
        array_push($this->cards, $card);

        return $this;
    }

    /**
     * Function obtains the value of the cards in the hand
     *
     * @return int
     */
    #[Pure] public function handValue () : int {
        $value = 0;
        $aceCount = 0; // number of aces in hand ( to add value if < 11 )

        foreach ($this->cards as $card) {
            $value = $value + CardValue::value($card->getValue()); /// add the card's value
            if ( $card->getValue() === CardValue::ACE ) /// if ace, increment
                $aceCount ++;
        }

        while ($aceCount > 0 && $value + 10 <= 21) { /// if aces are in hand and can turn ace from 1 to 11 as value
            $aceCount --;
            $value += 10;
        }

        return $value;
    }

    /**
     * Function checks if player has busted ( handValue > 21 )
     * @return bool
     */
    #[Pure] public function busted () : bool {
        return $this->handValue() > 21;
    }

    /**
     * Function clears the player's hand
     * @return $this
     */
    public function clear() : Player {
        $this->cards = array();
        return $this;
    }

    /**
     * Function checks whether the player has hit blackjack
     * @return bool
     */
    #[Pure] public function blackjacked() : bool {
        return $this->handValue() == 21;
    }

    /**
     * Function prints the player's cards and hand value
     */
    public function printDeck () : void {
        foreach($this->cards as $card) {
            echo $card->toGameString(), PHP_EOL;
        }

        echo 'Player hand value : ' . $this->handValue(), PHP_EOL;

        echo PHP_EOL;
    }
}