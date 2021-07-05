<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/MenuItem.php');
require_once (ROOT . '/obj/GameInterface.php');

/**
 * Abstract Class Menu - Generic Part of a Menu
 */
abstract class Menu implements GameInterface {

    /**
     * @var MenuItem[] - array of MenuItems, representing the selectable options
     */
    protected array $items = array();

    /**
     * Getter for menu title
     * @return string
     */
    public abstract function getTitle () : string;

    /**
     * Getter for menu info
     * @return string
     */
    public abstract function getInfo () : string;

    /**
     * Menu constructor.
     *
     * Adds Items to Menu
     */
    protected function __construct() {
        $this->items = $this->initItems();
    }

    /**
     * Getter for items that will be in the menu
     * @return MenuItem[]
     */
    protected abstract function initItems () : array;

    /**
     * Getter
     * @return MenuItem[]
     */
    public function items () : array {
        return $this->items;
    }

    /**
     * Adds an item to the menu
     * @param MenuItem $item
     * @return $this
     */
    public function addItem (MenuItem $item) : Menu {
        array_push($this->items, $item);
        return $this;
    }

    /**
     * Obtains the menu item at given index
     * @param int $index - option number selected
     * @return MenuItem - menu item obtained
     */
    #[Pure] public function choose (int $index) : MenuItem {
        return $this->items()[$index];
    }

    /**
     * Obtains the action requested from menu item
     * @param int $index
     * @return GameInterface
     */
    #[Pure] public function choice (int $index) : GameInterface {
        return $this->choose($index)->interface();
    }

    /**
     * Function checks if choice is valid ( 1 - max item count )
     * @param int $index - choice number
     * @return bool = true if valid, false otherwise
     */
    #[Pure] public function isChoiceIndex (int $index) : bool {
        return $index >= 1 && $index <= count($this->items());
    }

    /**
     * Prints the menu to the screen
     */
    public function print () : void {
        echo $this->getTitle(), PHP_EOL, PHP_EOL;
        echo $this->getInfo(), PHP_EOL, PHP_EOL;

        foreach ($this->items as $index => $value) {
            echo ($index + 1) . '. ' . $value->getText(), PHP_EOL;
        }

        echo PHP_EOL;
    }

    /**
     * Function called when we enter the menu
     */
    public function takeControl(): void {
        while (true) {
            $this->print(); /// print menu

            $input = '';
            while (! $this->isChoiceIndex((int)$input)) { /// while input not valid
                echo "Enter a choice's number : ";
                $input = readline(); /// obtain input again
            }

            $choice = $this->choice((int)$input - 1); /// obtain Action to happen upon selection

            if ( $choice->isEndSelection() ) { $choice->takeControl(); return; }
            $choice->takeControl(); /// give control to the menu's Action
        }
    }
}