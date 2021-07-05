<?php

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

require_once (ROOT . '/obj/Menu.php');
require_once (ROOT . '/obj/Settings.php');

/**
 * Class SettingsMenu - Represents the Settings Menu
 */
class SettingsMenu extends Menu {

    /**
     * SettingsMenu constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Getter
     * @return string
     */
    public function getTitle(): string {
        return 'Settings';
    }

    /**
     * Getter
     * @return string
     */
    public function getInfo(): string {
        return 'Change Variables used by the game';
    }

    /**
     * Initialises menu items
     * @return MenuItem[]
     */
    protected function initItems(): array {
        return [
            0 => new MenuItem('Change number of decks used (between 2-6, leave -1 for random) : ', new class implements GameInterface {
                /**
                 * Function checks whether a given number represents a valid deck count for Twenty-One
                 *
                 * @param int $deckCount
                 * @return bool true if valid number, false otherwise
                 */
                function validDeckCount (int $deckCount): bool {
                    return $deckCount >= 2 && $deckCount <= 6 || $deckCount == -1;
                }

                function takeControl(): void {
                    $input = '';

                    /// wait for a valid deck count
                    while (! $this->validDeckCount((int)$input)) {
                        echo 'Input a valid deck number (2-6, or -1 for random) : ';
                        $input = readline();
                    }

                    /// save deck count when valid
                    Settings::getInstance()->setInt(Settings::SETTINGS_DECK_COUNT, (int)$input);
                }

                function isEndSelection(): bool {
                    return false;
                }
            }),

            1 => new MenuItem('Change the number of players (1 minimum)', new class implements GameInterface {
                /**
                 * Function checks if given player count is valid ( >= 1 )
                 *
                 * @param int $count
                 * @return bool
                 */
                function validPlayerCount (int $count) : bool { return $count >= 1; }

                function takeControl(): void {
                    $input = '';

                    /// waits for a valid player count
                    while (! $this->validPlayerCount((int)$input)) {
                        echo 'Input a valid player count (1 min. ) : ';
                        $input = readline();
                    }

                    /// when valid, save
                    Settings::getInstance()->setInt(Settings::SETTINGS_PLAYER_COUNT, (int)$input);
                }

                function isEndSelection(): bool {
                    return false;
                }
            }),

            2 => new MenuItem('Back to Menu', new class implements GameInterface {
                /// no action but go back when selecting Back to Menu

                function takeControl(): void { }
                function isEndSelection(): bool {
                    return true;
                }
            })
        ];
    }

    public function isEndSelection(): bool {
        return false;
    }
}