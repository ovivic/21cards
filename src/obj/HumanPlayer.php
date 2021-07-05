<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Player.php');
require_once (ROOT . '/obj/PlayerState.php');

/**
 * Class HumanPlayer - represents a player that requires human input
 */
class HumanPlayer extends Player {
    /**
     * @var string Given name of the player
     */
    private string $name;

    /**
     * Request the player to input his name
     *
     * @param int $playerIndex
     * @return string
     */
    public function requestName (int $playerIndex) : string {
        $str = false;
        while ($str === false || strlen($str) == 0) {
            echo "Enter player $playerIndex's name : ";
            $str = readline();
        }

        return $str;
    }

    /**
     * HumanPlayer constructor.
     * @param int|string $name
     */
    public function __construct(int|string $name) {
        if (is_int($name)) $this->name = $this->requestName($name);
        else $this->name = $name;
    }

    /**
     * Getter
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Setter
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * Prints the player's deck
     */
    public function printDeck() : void {
        echo "$this->name's Deck : \n";
        parent::printDeck();
    }

    /**
     * Checks if a given game input is valid ( hit / stand )
     *
     * @param int $input
     * @return bool
     */
    private function isValidInput (int $input) : bool {
        return $input == PlayerState::HIT   ||
            $input == PlayerState::STAND;
    }

    /**
     * Function waits for a player's input
     *
     * @return int
     */
    public function input() : int {
        $input = false;

        while ($input === false || strlen($input) == 0 || ! $this->isValidInput((int)$input)) {
            echo 'Enter an action (1 = Hit, 2 = Stand, 3 = View Hand) : ';
            $input = readline();

            if((int)$input === PlayerState::VIEW_HAND)
                $this->printDeck();
        }

        return (int)$input;
    }
}