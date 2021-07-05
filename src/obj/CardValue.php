<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

/**
 * Class CardValue - Constants for card's values
 */
class CardValue {
    public const NONE = 0;

    public const ACE = 1;
    public const TWO = 2;
    public const THREE = 3;
    public const FOUR = 4;
    public const FIVE = 5;
    public const SIX = 6;
    public const SEVEN = 7;
    public const EIGHT = 8;
    public const NINE = 9;
    public const TEN = 10;
    public const JACK = 11;
    public const QUEEN = 12;
    public const KING = 13;

    /**
     * Obtains a card's value in a Blackjack Game
     * @param int $cardValue
     * @return int
     */
    public static function value (int $cardValue) : int {
        return match ($cardValue) {
            self::ACE => 1,
            self::TWO => 2,
            self::THREE => 3,
            self::FOUR => 4,
            self::FIVE => 5,
            self::SIX => 6,
            self::SEVEN => 7,
            self::EIGHT => 8,
            self::NINE => 9,
            self::TEN, self::JACK, self::QUEEN, self::KING => 10,
            default => -1,
        };
    }

    /**
     * Returns the String representation of a card's value
     * @param int $value
     * @return string
     */
    public static function toString (int $value) : string {
        return match ($value) {
            self::ACE => 'Ace',
            self::TWO => 'Two',
            self::THREE => 'Three',
            self::FOUR => 'Four',
            self::FIVE => 'Five',
            self::SIX => 'Six',
            self::SEVEN => 'Seven',
            self::EIGHT => 'Eight',
            self::NINE => 'Nine',
            self::TEN => 'Ten',
            self::JACK => 'Jack',
            self::QUEEN => 'Queen',
            self::KING => 'King',
            self::NONE => 'NoValue',
            default => 'ValueError',
        };
    }
}