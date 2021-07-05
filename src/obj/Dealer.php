<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/HumanPlayer.php');
require_once (ROOT . '/obj/Game.php');
require_once (ROOT . '/obj/PlayerState.php');

/**
 * Class Dealer - Represents the dealer in a game
 */
class Dealer extends Player {
    /**
     * @var bool - represents whether the dealer has finished serving so he can turn the second card
     */
    private bool $doneServing = false;

    /**
     * Deals the first set of two cards to each player and to himself from a given array of cards
     *
     * @param array $cards
     * @param array $players
     * @return $this
     */
    public function deal (array & $cards, array $players) : Dealer {
        foreach ($players as $player) {
            $player->addCard(array_pop($cards));
            $player->addCard(array_pop($cards));
        }

        $this->addCard(array_pop($cards));
        $this->addCard(array_pop($cards));

        return $this;
    }

    /**
     * Clear's the dealer's deck and state
     * @return $this
     */
    public function clear () : Dealer {
        parent::clear();
        $this->doneServing = false;
        return $this;
    }

    /**
     * Prints the dealer's deck
     */
    public function printDeck() : void {
        echo "Dealer's Deck : \n";

        if (! $this->doneServing) { /// print one card
            echo $this->cards()[0]->toGameString(), PHP_EOL;
            echo 'Unknown Card', PHP_EOL;
        } else {
            parent::printDeck(); /// print deck as usual
        }

        echo PHP_EOL;
    }

    /**
     * @param HumanPlayer $player
     * @param Card[] $cards
     * @return Dealer
     */
    public function serve(HumanPlayer $player, array & $cards) : Dealer {
        echo "Waiting on " . $player->getName() . "'s turn : ", PHP_EOL;
        while (
                ! $player->blackjacked() &&
                ! $player->busted() &&
                $player->input() != PlayerState::STAND
        ) {
            echo 'Player ' . $player->getName() . ' hit. Received card : ';
            $cardToAdd = array_pop($cards);
            echo $cardToAdd->toGameString(), PHP_EOL;

            $player->addCard($cardToAdd);
            $player->printDeck();
        }

        if ( $player->busted() )
            echo 'Player ' . $player->getName() . ' busted with ' . $player->handValue();
        else if ( ! $player->blackjacked() )
            echo 'Player ' . $player->getName() . ' stood with ' . $player->handValue();
        else
            echo 'Player ' . $player->getName() . ' hit blackjack (21)';
        echo PHP_EOL, PHP_EOL;

        return $this;
    }

    /**
     * @param Card[] $cards
     */
    public function play (array & $cards) : Dealer {
        $this->doneServing = true;

        $this->printDeck();
        while ($this->handValue() < 17) {
            sleep(2);
            echo 'Dealer hits. Received card : ';
            $cardToAdd = array_pop($cards);
            echo $cardToAdd->toGameString(), PHP_EOL;

            $this->addCard($cardToAdd);
            $this->printDeck();
        }

        if ( $this->busted() )
            echo 'Dealer busted with ' . $this->handValue();
        else if ( ! $this->blackjacked() )
            echo 'Dealer stood with ' . $this->handValue();
        else
            echo 'Dealer hit blackjack (21)';
        echo PHP_EOL;

        return $this;
    }
}