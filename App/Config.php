<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'db';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'videgrenierenligne';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '653rag9T';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Get database host from environment or use default
     * @return string
     */
    public static function getDbHost()
    {
        return $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: self::DB_HOST;
    }

    /**
     * Get database name from environment or use default
     * @return string
     */
    public static function getDbName()
    {
        return $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: self::DB_NAME;
    }

    /**
     * Get database user from environment or use default
     * @return string
     */
    public static function getDbUser()
    {
        return $_ENV['DB_USER'] ?? getenv('DB_USER') ?: self::DB_USER;
    }

    /**
     * Get database password from environment or use default
     * @return string
     */
    public static function getDbPassword()
    {
        return $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: self::DB_PASSWORD;
    }

    /**
     * Get show errors setting from environment or use default
     * @return bool
     */
    public static function getShowErrors()
    {
        $envValue = $_ENV['SHOW_ERRORS'] ?? getenv('SHOW_ERRORS');
        if ($envValue !== false) {
            return filter_var($envValue, FILTER_VALIDATE_BOOLEAN);
        }
        return self::SHOW_ERRORS;
    }
}
