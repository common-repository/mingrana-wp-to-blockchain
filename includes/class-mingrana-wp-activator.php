<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.mingrana.com/
 * @since      1.0.0
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/includes
 * @author     Mingrana SL <info@mingrana.com>
 */
class Mingrana_Wp_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $table_prefix, $wpdb;

    	$tblname = 'mingrana';
    	$mingrana_wp_table = $table_prefix . "$tblname ";

    	#Check to see if the table exists already, if not, then create it



    if($wpdb->get_var( "show tables like '$mingrana_wp_table'" ) != $mingrana_wp_table) 
    {


	        $sql = "CREATE TABLE IF NOT EXISTS $mingrana_wp_table (
						`id` INT(11) NOT NULL AUTO_INCREMENT,
						`post_id` INT(11) NOT NULL DEFAULT '0',
						`pdf` TEXT NULL,
						`hash_256` VARCHAR(64) NOT NULL DEFAULT '',
						`block` VARCHAR(128) NOT NULL DEFAULT '',
						`transaction` VARCHAR(128) NULL DEFAULT '',
						`register_at` DATETIME DEFAULT NULL,
						`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						`status` INT(11) NULL DEFAULT '0',
						PRIMARY KEY (`id`)
				)
				ENGINE=InnoDB
				;";
			
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

	        dbDelta($sql);
	    }

	 
	}




	}

