<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__));

require_once (ROOT . '/obj/MainMenu.php');

/// starts the main menu
$mainMenu = new MainMenu();
/// give control to the menu
$mainMenu->takeControl();
