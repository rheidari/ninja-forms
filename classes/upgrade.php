<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Upgrade
 */
class NF_Upgrade {

    protected $id;

    public $meta;

    public function __construct( $id ) {
        $this->id;

        $this->meta = $this->get_meta( TRUE );
    }

    public function get_meta( $refresh = FALSE ) {

        if ( $this->meta AND $refresh )
            return $this->meta;

        global $wpdb;

        return $this->meta = $wpdb->get_results( "SELECT * FROM " . NF_OBJECT_META_TABLE_NAME . " WHERE object_id = '" . $this->id . "'", ARRAY_A );
    }

    /**
     * Upgrades
     *
     * Return an array of NF_Upgrade objects
     *
     * @return array
     */
    public static function upgrades() {
        global $wpdb;

        $results = $wpdb->get_results( "SELECT * FROM " . NF_OBJECTS_TABLE_NAME . " WHERE type = '" . NF_Upgrade_Handler::OBJECT_TYPE . "'", ARRAY_A );

        $upgrades = array();

        foreach ( $results as $result ) {
            $upgrades[] = new NF_Upgrade( $result['id'] );
        }

        return $upgrades;
    }

}