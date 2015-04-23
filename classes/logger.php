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

    const OBJECT_TYPE = 'log';

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public static function log($level, $message, array $context = array()) {
        $log_id = nf_insert_object( self::OBJECT_TYPE );
        nf_update_object_meta( $log_id, 'created_at', time() );
        nf_update_object_meta( $log_id, 'level', $level );
        nf_update_object_meta( $log_id, 'message', $message );
        nf_update_object_meta( $log_id, 'context', maybe_serialize( $context ) );
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

class NF_Log {

    public $id;

    private $meta;

    /**
     * Static list of logs
     *
     * @var
     */
    static $logs;


    /**
     * Constructor
     *
     * Create a new NF_Log object
     *
     * @param $id
     */
    public function __construct( $id ) {
        $this->id = $id;
    }

    /**
     * Created At
     *
     * @param string $format optional
     * @return string
     */
    public function created_at( $format = '' ) {

        if ( isset( $format ) ) {
            return (string) date( $format, $this->meta['created_at'] );
        }

        return (string) $this->meta['created_at'];
    }

    /**
     * Level
     *
     * @return string
     */
    public function level() {
        return (string) $this->meta['level'];
    }

    /**
     * Message
     *
     * @return string
     */
    public function message() {
        return (string) $this->meta['message'];
    }

    /**
     * Context
     *
     * @return array
     */
    public function context() {
        return (array) $this->meta['context'];
    }

    public function display() {
        echo "<pre>";
        var_dump( $this );
        echo "</pre>";
    }

    /**
     * Export
     *
     * Returns a serialized object
     *
     * @return string serialized
     */
    public function export() {
        return serialize( $this );
    }


    /**
     * Get Logs
     *
     * Static getter for getting logs in bulk
     *
     * @param array $options
     * @return array
     */
    public static function get_logs( array $options = array() ) {
        global $wpdb;

        $results = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "nf_objects WHERE type = '" . NF_Logger::OBJECT_TYPE . "'", ARRAY_A);

        foreach ( $results as $result ) {
            $log = new NF_Log( $result['id'] );

            $log->meta = nf_get_object_meta( $log->id );

            self::$logs[ $log->id ] = $log;
        }

        return (array) self::$logs;

    }

}
