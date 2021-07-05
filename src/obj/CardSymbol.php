<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

/**
 * Class CardSymbol - Constants for a card's symbol
 */
class CardSymbol {
    public const NONE = 0;
    public const HEARTS = 1;
    public const DIAMONDS = 2;
    public const SPADES = 3;
    public const CLUBS = 4;

    /**
     * Obtains a symbol's name as string
     * @param int $symbol
     * @return string
     */
    public static function toString(int $symbol) : string {
        return match ($symbol) {
            self::NONE => 'NoSymbol',
            self::HEARTS => 'Hearts',
            self::DIAMONDS => 'Diamonds',
            self::SPADES => 'Spades',
            self::CLUBS => 'Clubs',
            default => 'SymbolError',
        };
    }
}