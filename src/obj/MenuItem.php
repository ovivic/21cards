<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/GameInterface.php');

/**
 * Class MenuItem - links a menu selection to another menu ( GameInterface )
 */
class MenuItem {

    /**
     * @var string Option's Text
     */
    private string $text;

    /**
     * @var GameInterface - interface to go to if item is selected
     */
    private GameInterface $linkedInterface;

    /**
     * MenuItem constructor.
     * @param string $text - text of the item
     * @param GameInterface $linkedInterface - action to occur upon selection
     */
    public function __construct ( string $text, GameInterface $linkedInterface ) {
        $this->text = $text;
        $this->linkedInterface = $linkedInterface;
    }

    /**
     * Getter for the action
     * @return GameInterface
     */
    function interface () : GameInterface {
        return $this->linkedInterface;
    }

    /**
     * Getter
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * Setter
     * @param string $text
     */
    public function setText(string $text): void {
        $this->text = $text;
    }

    /**
     * Setter
     * @param GameInterface $linkedInterface
     */
    public function setLinkedInterface(GameInterface $linkedInterface): void {
        $this->linkedInterface = $linkedInterface;
    }
}