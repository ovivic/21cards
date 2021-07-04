<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/CardSymbol.php');
require_once (ROOT . '/obj/CardValue.php');

class Card {
    private int $symbol = CardSymbol::NONE;
    private int $value = CardValue::NONE;

    public function __construct(int $symbol, int $value) {
        $this->value = $value;
        $this->symbol = $symbol;
    }

    public function getSymbol(): int {
        return $this->symbol;
    }

    public function getValue(): int {
        return $this->value;
    }

    public function setSymbol(int $symbol): void {
        $this->symbol = $symbol;
    }

    public function setValue(int $value): void {
        $this->value = $value;
    }

    #[Pure] public function toString () : string {
        return 'Card ' .
            '{ value = ' . CardValue::toString($this->value) .
            ', symbol = ' . CardSymbol::toString($this->symbol) . ' }';
    }

    #[Pure] public function toGameString () : string {
        return CardValue::toString($this->value) . ' of ' . CardSymbol::toString($this->symbol);
    }
}
