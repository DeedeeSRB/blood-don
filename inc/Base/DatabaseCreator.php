<?php
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

class DatabaseCreator
{
	public static function register() {
		DatabaseCreator::createTables();
	}

	public static function createTables()
	{
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

		$tablename_donors = $wpdb->prefix . 'users'; 
		$tablename_donations = $wpdb->prefix . 'donations'; 
		$donations_sql_create = "CREATE TABLE $tablename_donations (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			donor_id BIGINT(20) UNSIGNED DEFAULT NULL,
			amount_ml int(11) NOT NULL,
			time datetime NOT NULL,
			status enum('Completed','In progress','Planned','To Be Accepted') NOT NULL,
			PRIMARY KEY (id),
			CONSTRAINT donation_donor_fk FOREIGN KEY (donor_id) 
			REFERENCES $tablename_donors (id) ON DELETE SET NULL ON UPDATE NO ACTION
		  ) $charset_collate";    
		maybe_create_table( $tablename_donations, $donations_sql_create );
	}
}