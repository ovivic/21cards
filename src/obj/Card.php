<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/CardSymbol.php');
require_once (ROOT . '/obj/CardValue.php');

/**
 * Class Card - Represents a playing card
 */
class Card {
    /**
     * @var int card's symbol
     */
    private int $symbol = CardSymbol::NONE;

    /**
     * @var int card's value
     */
    private int $value = CardValue::NONE;

    /**
     * Card constructor.
     * @param int $symbol
     * @param int $value
     */
    public function __construct(int $symbol, int $value) {
        $this->value = $value;
        $this->symbol = $symbol;
    }

    /**
     * Getter
     * @return int
     */
    public function getSymbol(): int {
        return $this->symbol;
    }

    /**
     * Getter
     * @return int
     */
    public function getValue(): int {
        return $this->value;
    }

    /**
     * Setter
     * @param int $symbol
     */
    public function setSymbol(int $symbol): void {
        $this->symbol = $symbol;
    }

    /**
     * Setter
     * @param int $value
     */
    public function setValue(int $value): void {
        $this->value = $value;
    }

    /**
     * Returns a string representation of the object
     * @return string
     */
    #[Pure] public function toString () : string {
        return 'Card ' .
            '{ value = ' . CardValue::toString($this->value) .
            ', symbol = ' . CardSymbol::toString($this->symbol) . ' }';
    }

    /**
     * Returns a string representing the card in game
     * @return string
     */
    #[Pure] public function toGameString () : string {
        return CardValue::toString($this->value) . ' of ' . CardSymbol::toString($this->symbol);
    }
}
