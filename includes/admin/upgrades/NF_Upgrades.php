<?php

/**
 * Class NF_Upgrades
 */
class NF_Upgrades {

    /**
     *
     */
    const WP_OPTION = "nf_upgrades";

    /**
     * @var array
     */
    public $upgrades = array();

    /**
     * Upgrades
     *
     * Get the upgrades from wp_options
     *
     * @param bool $fresh
     * @return array
     */
    public function upgrades( $fresh = false ) {

        if ( $this->upgrades AND ( ! $fresh ) )
            return $this->upgrades;

        $upgrades = get_option( NF_Upgrade::WP_OPTION, false );

        $this->set_upgrades( $upgrades );

        return $this->upgrades;
    }

    /**
     * Set Upgrades
     *
     * @param $upgrades
     */
    function set_upgrades( $upgrades ) {

        foreach ( $upgrades as $upgrade => $properties ) {
            $this->upgrades[] = new NF_Upgrade( $properties );
        }

        usort( $this->upgrades, 'NF_Upgrade::compare' );
    }

    /**
     * Process
     *
     * Process the upgrades
     */
    public function process() {

        foreach ( $this->upgrades as $upgrade ) {

            if ( ! $upgrade->timestamp )
                $upgrade->run();
        }
    }

} // End NF_Upgrades


/**
 * Class NF_Upgrade
 */
class NF_Upgrade {

    /**
     * @var $name
     *
     * A name by which to reference the upgrade (ie convert-forms).
     */
    public $name;

    /**
     * @var $priority
     *
     * The order in which upgrades run.
     * It is suggested to use the corresponding version/release number.
     */
    public $priority;

    /**
     * @var $description
     */
    public $description;

    /**
     * @var $function
     *
     * The function to call for the upgrade process.
     */
    public $function;

    /**
     * @var $timestamp
     *
     * The time and date of when the upgrade last ran.
     */
    public $timestamp;



    /**
     * @param array $properties
     */
    public function __construct( array $properties = array() ) {

        foreach ( $properties as $property => $value ) {

            if ( property_exists( 'NF_Upgrade', $property ) ) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Compare
     *
     * Compare the priority of two upgrades
     *
     * @param $a
     * @param $b
     * @return int
     */
    public static function compare($a, $b) {

        if ($a->priority == $b->priority) {
            return 0;
        }
        return ($a->priority < $b->priority) ? -1 : 1;
    }

    /**
     * Run
     *
     * Calls the function attached to the upgrade
     */
    public function run() {

        //if ( ! function_exists( $this->function ) )
            //TODO Throw Error, NF_Logger

        $completed = call_user_func( $this->function );

        if ( $completed ) $this->timestamp = time();
    }

    /**
     * Reset
     *
     * Clear the timestamp flag so that the upgrade will run again
     */
    public function reset() {

        $this->timestamp = null;
    }

} // END NF_Upgrade
