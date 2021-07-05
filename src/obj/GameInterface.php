<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

/**
 * Interface GameInterface - represents an interactable element
 *
 *  Can be a menu, can be the game, can be an exit action, ...
 */
interface GameInterface {
    /**
     * Behaviour when entering the interface ( Menu / Game )
     */
    function takeControl () : void;

    /**
     * Function checking whether we should return with this action
     * @return bool = true if action marks a return, false otherwise
     */
    function isEndSelection () : bool;
}