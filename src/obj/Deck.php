<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Card.php');

/**
 * Class Deck - Represents one deck of playing cards ( 52 cards, 4 symbols, 13 values each )
 */
class Deck {
    /**
     * @var Card[] Array of Cards
     */
    private array $cards;

    private const MIN_INDEX = 0;
    private const MAX_INDEX = 51;

    public const COUNT = 52;

    #[Pure] public function __construct() {
        $this->cards = [
            0 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::ACE),
            1 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::TWO),
            2 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::THREE),
            3 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::FOUR),
            4 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::FIVE),
            5 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::SIX),
            6 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::SEVEN),
            7 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::EIGHT),
            8 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::NINE),
            9 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::TEN),
            10 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::JACK),
            11 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::QUEEN),
            12 => new Card(symbol: CardSymbol::HEARTS, value: CardValue::KING),

            13 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::ACE),
            14 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::TWO),
            15 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::THREE),
            16 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::FOUR),
            17 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::FIVE),
            18 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::SIX),
            19 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::SEVEN),
            20 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::EIGHT),
            21 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::NINE),
            22 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::TEN),
            23 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::JACK),
            24 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::QUEEN),
            25 => new Card(symbol: CardSymbol::DIAMONDS, value: CardValue::KING),

            26 => new Card(symbol: CardSymbol::SPADES, value: CardValue::ACE),
            27 => new Card(symbol: CardSymbol::SPADES, value: CardValue::TWO),
            28 => new Card(symbol: CardSymbol::SPADES, value: CardValue::THREE),
            29 => new Card(symbol: CardSymbol::SPADES, value: CardValue::FOUR),
            30 => new Card(symbol: CardSymbol::SPADES, value: CardValue::FIVE),
            31 => new Card(symbol: CardSymbol::SPADES, value: CardValue::SIX),
            32 => new Card(symbol: CardSymbol::SPADES, value: CardValue::SEVEN),
            33 => new Card(symbol: CardSymbol::SPADES, value: CardValue::EIGHT),
            34 => new Card(symbol: CardSymbol::SPADES, value: CardValue::NINE),
            35 => new Card(symbol: CardSymbol::SPADES, value: CardValue::TEN),
            36 => new Card(symbol: CardSymbol::SPADES, value: CardValue::JACK),
            37 => new Card(symbol: CardSymbol::SPADES, value: CardValue::QUEEN),
            38 => new Card(symbol: CardSymbol::SPADES, value: CardValue::KING),

            39 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::ACE),
            40 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::TWO),
            41 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::THREE),
            42 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::FOUR),
            43 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::FIVE),
            44 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::SIX),
            45 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::SEVEN),
            46 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::EIGHT),
            47 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::NINE),
            48 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::TEN),
            49 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::JACK),
            50 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::QUEEN),
            51 => new Card(symbol: CardSymbol::CLUBS, value: CardValue::KING)
        ];
    }

    /**
     * Getter
     * @return Card[]
     */
    public function getCards(): array {
        return $this->cards;
    }

    /**
     * Setter
     * @param array $cards
     */
    public function setCards(array $cards): void {
        $this->cards = $cards;
    }

    /**
     * String representation for debugging reasons
     * @return string
     */
    #[Pure] public function toString () : string {
        $str = "Cards : [\n";
        foreach($this->cards as $card) {
            $str = $str . "\t" . $card->toString() . "\n";
        }
        return $str . "]";
    }

    /**
     * Another string representation for the cards
     * @return string
     */
    #[Pure] public function toGameString () : string {
        $str = "Cards : [\n";
        foreach($this->cards as $card) {
            $str = $str . "\t" . $card->toGameString() . "\n";
        }
        return $str . "]";
    }

    /**
     * Shuffle test function for the Deck
     * @param int $swapCount
     * @return $this
     */
    public function shuffle (int $swapCount = 10000) : Deck {
        for ($i = 0; $i < $swapCount; $i++) {
            $leftCard = rand(self::MIN_INDEX, self::MAX_INDEX);
            $rightCard = rand(self::MIN_INDEX, self::MAX_INDEX);

            while ($leftCard == $rightCard)
                $rightCard = rand(self::MIN_INDEX, self::MAX_INDEX);

            $auxCard = $this->cards[$leftCard];
            $this->cards[$leftCard] = $this->cards[$rightCard];
            $this->cards[$rightCard] = $auxCard;
        }

        return $this;
    }
}