<?php

use JetBrains\PhpStorm\NoReturn;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Menu.php');
require_once (ROOT . '/obj/Game.php');
require_once (ROOT . '/obj/SettingsMenu.php');

/**
 * Class MainMenu - Represents the main menu
 */
class MainMenu extends Menu {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Getter
     * @return string
     */
    public function getTitle(): string {
        return 'Twenty-One';
    }

    /**
     * Getter
     * @return string
     */
    public function getInfo(): string {
        return 'Choose one of the following items : ';
    }

    /**
     * Initialises menu items
     * @return MenuItem[]
     */
    protected function initItems(): array {
        return [
            0 => new MenuItem('Start Game', new Game()), /// go to Game() if selected
            1 => new MenuItem('Settings', new SettingsMenu()), /// go to SettingsMenu() if selected
            2 => new MenuItem('Exit', new class implements GameInterface { /// exit if selected
                #[NoReturn] function takeControl(): void {
                    exit(0);
                }

                public function isEndSelection(): bool {
                    return true;
                }
            })
        ];
    }

    function isEndSelection(): bool {
        return false;
    }
}