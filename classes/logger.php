<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Handles custom logging for Ninja Forms and Ninja Forms Extensions.
 *
 * PSR-3 and WordPress Compliant where applicable.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Errors
 * @copyright   Copyright (c) 2015, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.9.8
 */

class NF_Logger {

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function log($level, $message, array $context = array()) {
        // This line currently empty
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function emergency($message, array $context = array()) {
        self::log( 'emergency', $message, $context );
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function alert($message, array $context = array()) {
        self::log( 'alert', $message, $context );
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function critical($message, array $context = array()) {
        self::log( 'error', $message, $context );
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function error($message, array $context = array()) {
        self::log( 'error', $message, $context );
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function warning($message, array $context = array()) {
        self::log( 'warning', $message, $context );
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function notice($message, array $context = array()) {
        self::log( 'notice', $message, $context );
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function info($message, array $context = array()) {
        self::log( 'info', $message, $context );
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function debug($message, array $context = array()) {
        self::log( 'debug', $message, $context );
    }

}