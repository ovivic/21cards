<?php

use JetBrains\PhpStorm\Pure;

if (!defined('ROOT'))
    define ('ROOT', dirname(__FILE__) . '/..');

/**
 * Class Settings - Global Instance - exists at all times
 */
class Settings {
    public const SETTINGS_DECK_COUNT = "deckCount";
    public const SETTINGS_PLAYER_COUNT = "playerCount";

    public const DEFAULT_DECK_COUNT = -1;
    public const DEFAULT_PLAYER_COUNT = 1;

    /**
     * @var Settings|null Global Instance of Settings - (static = global)
     */
    private static ?Settings $instance = null;

    /**
     * @var array - Settings container
     */
    private array $settings;

    /**
     * Function acquires settings instance
     * @return Settings
     */
    public static function getInstance() : Settings {
        if ( self::$instance === null ) self::$instance = new Settings();
        return self::$instance;
    }

    /**
     * Settings Initialisation
     */
    private function __construct() {
        $this
            ->setInt(self::SETTINGS_DECK_COUNT, self::DEFAULT_DECK_COUNT)
            ->setInt(self::SETTINGS_PLAYER_COUNT, self::DEFAULT_PLAYER_COUNT);
    }

    /**
     * Function saves a String value to settings
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setString (string $key, string $value) : Settings {
        return $this->set($key, $value);
    }

    /**
     * Function saves an int value to settings
     *
     * @param string $key
     * @param int $value
     * @return $this
     */
    public function setInt (string $key, int $value) : Settings {
        return $this->set($key, $value);
    }

    /**
     * Function saves a value to settings
     *
     * @param string $key
     * @param string|int $value
     * @return $this
     */
    public function set (string $key, string|int $value) : Settings {
        $this->settings[$key] = $value;
        return $this;
    }

    /**
     * Function obtains a value from settings
     *
     * @param string $key
     * @return string|int|null
     */
    #[Pure] public function get (string $key): null|string|int {
        return $this->exists($key) ? $this->settings[$key] : null;
    }

    /**
     * Function checks if a value exists
     *
     * @param string $key
     * @return bool
     */
    public function exists (string $key) : bool {
        return array_key_exists($key, $this->settings);
    }

    /**
     * Function checks if saved value is int
     *
     * @param string $key
     * @return bool
     */
    #[Pure] public function isInt (string $key) : bool {
        return $this->exists($key) && is_int( $this->settings[$key] );
    }

    /**
     * Function checks if saved value is string
     *
     * @param string $key
     * @return bool
     */
    #[Pure] public function isString (string $key) : bool {
        return $this->exists($key) && is_string( $this->settings[$key] );
    }

    /**
     * Function obtains an int value
     *
     * @param string $key
     * @return int|null
     */
    #[Pure] public function getInt (string $key) : ?int {
        return $this->isInt($key) ? $this->settings[$key] : null;
    }

    /**
     * Function obtains a string value
     *
     * @param string $key
     * @return string|null
     */
    #[Pure] public function getString (string $key) : ?string {
        return $this->isString($key) ? $this->settings[$key] : null;
    }
}
