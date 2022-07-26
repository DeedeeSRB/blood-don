<?php
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Manage;

class DatabaseManager
{
	public $option_version;
	public $database_version;

	public function register() {
		$this->database_version = 2;
		
		$this->checkVersion();
	}

	public function checkVersion() {
		$this->option_version = get_option( 'donations_db_version' );
		error_log("option version: $this->option_version /// db version: $this->database_version");
		if ( $this->option_version < $this->database_version ){
			if ( $this->option_version == 1 ) {
				global $wpdb;
				$tablename_donations = $wpdb->prefix . 'donations'; 
				$query = "ALTER TABLE $tablename_donations ADD location VARCHAR (255) NOT NULL DEFAULT 'Undefined';";
				$result = $wpdb->query( $query );

				error_log ( $result ) ;
				update_option( 'donations_db_version', 2 );
				
				error_log("checked for version $this->option_version");
				$this->checkVersion();
			}
		}
		else if ( $this->option_version == $this->database_version ) {
			error_log('updated');
			$this->createTables();
		}
	}

	public function createTables()
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
			location VARCHAR (255) NOT NULL DEFAULT 'Undefined',
			PRIMARY KEY (id),
			CONSTRAINT donation_donor_fk FOREIGN KEY (donor_id) 
			REFERENCES $tablename_donors (id) ON DELETE SET NULL ON UPDATE NO ACTION
		  ) $charset_collate";    
		maybe_create_table( $tablename_donations, $donations_sql_create );
	}
}