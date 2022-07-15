<?php
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

//use Inc\Base\DatabaseCreator;

class Activate
{
	public static function activate() 
	{
		Activate::createTables();
		//DatabaseCreator::createTables();
		flush_rewrite_rules();
	}

	public static function createTables()
	{
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

		$tablename_donors = $wpdb->prefix . 'donors'; 
		$donors_sql_create = "CREATE TABLE $tablename_donors (
            id int(11) NOT NULL AUTO_INCREMENT,
            first_name varchar(45) NOT NULL,
            last_name varchar(45) NOT NULL,
            blood_group enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
            phone_number varchar(45) NOT NULL,
            email varchar(45) DEFAULT NULL,
            address varchar(100) DEFAULT NULL,
            PRIMARY KEY (id)
            ) $charset_collate";    
		maybe_create_table( $tablename_donors, $donors_sql_create );

		$tablename_donations = $wpdb->prefix . 'donations'; 
		$donations_sql_create = "CREATE TABLE $tablename_donations (
			id int(11) NOT NULL AUTO_INCREMENT,
			donor_id int(11) DEFAULT NULL,
			amount_ml int(11) NOT NULL,
			time datetime NOT NULL,
			status enum('Completed','In progress','Planned') NOT NULL,
			PRIMARY KEY (id),
			CONSTRAINT donation_donor_fk FOREIGN KEY (donor_id) 
			REFERENCES $tablename_donors (id) ON DELETE SET NULL ON UPDATE NO ACTION
		  ) $charset_collate";    
		maybe_create_table( $tablename_donations, $donations_sql_create );
	}

}