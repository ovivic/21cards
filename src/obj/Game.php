<?php

use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Deck.php');
require_once (ROOT . '/obj/Player.php');
require_once (ROOT . '/obj/HumanPlayer.php');
require_once (ROOT . '/obj/Dealer.php');
require_once (ROOT . '/obj/GameInterface.php');
require_once (ROOT . '/obj/Settings.php');

/**
 * Class Game - Represents the Game Object
 */
class Game implements GameInterface {

    /**
     * @var Card[] - Cards in the current game
     */
    private array $cards = array();

    /**
     * @var Dealer - Current Dealer of the game
     */
    private Dealer $dealer;

    /**
     * @var HumanPlayer[] - Players in the game
     */
    private array $players = array();

    /**
     * Function used to add a player to the game
     *
     * @param string|Player $player
     * @return $this
     */
    public function addPlayer(string|Player $player): Game {
        if ( is_string($player) )
            $player = new HumanPlayer($player);

        array_push($this->players, $player);
        return $this;
    }

    /**
     * Getter
     * @return Player[]
     */
    public function players (): array {
        return $this->players;
    }

    /**
     * Getter for all players and the dealer in the same array
     * @return Player[]
     */
    public function allPlayers (): array {
        $players = array();
        foreach($this->players as $player) array_push($players, $player);
        array_push($players, $this->dealer);
        return $players;
    }

    /**
     * Getter
     * @return Dealer
     */
    public function dealer () : Dealer {
        return $this->dealer;
    }

    /**
     * Initialises cards from a number of decks
     *
     * @param int $deckCount
     * @return $this
     */
    public function initDecks (int $deckCount = -1) : Game {
        if ( $deckCount == -1 ) $deckCount = rand(2, 6);

        for ( $i = 0; $i < $deckCount; $i++ ) {
            $deck = new Deck();

            foreach($deck->getCards() as $card)
                array_push($this->cards, $card);
        }

        return $this;
    }

    /**
     * Initialises players, requesting a name for each player
     *
     * @param int $playerCount
     * @return $this
     */
    public function initPlayers (int $playerCount = 1) : Game {
        $this->players = array();
        for ($i = 0; $i < $playerCount; $i++)
            array_push($this->players, new HumanPlayer($i + 1));

        return $this;
    }

    /**
     * Game constructor.
     * @param int $deckCount
     */
    public function __construct(int $deckCount = -1) {
        $this->initDecks($deckCount);

        $this->dealer = new Dealer();
    }

    /**
     * Shuffles cards in the current card array
     *
     * @param int $swapCount
     * @return $this
     */
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

    /**
     * Prints status of the current players' decks
     */
    function printStatus (): void {
        foreach ( $this->allPlayers() as $player ) {
            $player->printDeck();
        }
    }

    /**
     * Function defining behaviour upon entering the game
     */
    #[NoReturn] function takeControl(): void {
        $this
            ->initDecks(Settings::getInstance()->getInt(Settings::SETTINGS_DECK_COUNT)) //// grabs cards from configured number of decks
            ->shuffle() /// shuffles cards
            ->initPlayers(Settings::getInstance()->getInt(Settings::SETTINGS_PLAYER_COUNT)) /// creates requested amount of players
            ->dealer()
            ->clear() /// clears the dealer's card
            ->deal($this->cards, $this->players); /// deal 2 cards to each player and to the dealer

        echo PHP_EOL, 'Game Started', PHP_EOL, PHP_EOL;
        echo 'Cards have been dealt', PHP_EOL, PHP_EOL;

        $this->printStatus(); /// prints all the

        foreach ($this->players as $player) {
            /// serve the current player
            $this->dealer->serve($player, $this->cards);
        }

        /// the dealer can play now
        $this->dealer->play($this->cards);

        /// all players have played, state scores now
        $this->stateScores();
    }

    /**
     * Prints the scores and states the highest scoring players
     */
    public function stateScores () : void {
        $highestHand = 0;

        foreach ($this->players() as $player) {
            if ( $player->handValue() > $highestHand && ! $player->busted() )
                $highestHand = $player->handValue();

            if ( $player->busted() )
                echo 'Player ' . $player->getName() . ' busted with ' . $player->handValue();
            else
                echo 'Player ' . $player->getName() . "'s hand : " . $player->handValue();
            echo PHP_EOL;
        }

        if ( $this->dealer->handValue() > $highestHand && ! $this->dealer->busted() )
            $highestHand = $this->dealer->handValue();

        if ( $this->dealer->busted() )
            echo 'Dealer busted with ' . $this->dealer->handValue();
        else
            echo "Dealer's hand : " . $this->dealer->handValue();
        echo PHP_EOL;

        echo PHP_EOL, PHP_EOL, "Highest Hands : ";
        foreach ($this->players() as $player)
            if ( $player->handValue() == $highestHand )
                echo $player->getName() . " ";
        if ( $this->dealer->handValue() == $highestHand )
            echo 'Dealer';
        echo PHP_EOL, PHP_EOL;
    }

    function isEndSelection(): bool {
        return false;
    }
}