<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Api;

class SettingsApi
{
	public $admin_pages = array();
    public $admin_subpages = array();

    public $settings = array();
	public $sections = array();
	public $fields = array();

	public function register()
	{
		if ( ! empty($this->admin_pages) ) {
			add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
		}

        if ( !empty($this->settings) ) {
			add_action( 'admin_init', array( $this, 'registerCustomFields' ) );
		}
	}

	public function addPages( array $pages )
	{
		$this->admin_pages = $pages;
		return $this;
	}

    public function withSubPage( string $title = null ) 
	{
		if ( empty($this->admin_pages) ) {
			return $this;
		}

		$admin_page = $this->admin_pages[0];

		$subpage = array(
			array(
				'parent_slug' => $admin_page['menu_slug'], 
				'page_title' => $admin_page['page_title'], 
				'menu_title' => ($title) ? $title : $admin_page['menu_title'], 
				'capability' => $admin_page['capability'], 
				'menu_slug' => $admin_page['menu_slug'], 
				'callback' => $admin_page['callback']
			)
		);

		$this->admin_subpages = $subpage;

		return $this;
	}

	public function addSubPages( array $pages )
    {
		$this->admin_subpages = array_merge( $this->admin_subpages, $pages );

		return $this;
	}

	public function addAdminMenu()
	{
		foreach ( $this->admin_pages as $page ) {
			$hookname = add_menu_page( 
				$page['page_title'], 
				$page['menu_title'], 
				$page['capability'], 
				$page['menu_slug'], 
				$page['callback'], 
				$page['icon_url'], 
				$page['position'] 
			);
			
			// if ($page['page_title'] == 'Blood Donation Plugin'){
			// 	add_action( 'load-' . $hookname, array( $this, 'pageSubmit') );
			// }
		}

        foreach ( $this->admin_subpages as $page ) {
			add_submenu_page( 
				$page['parent_slug'], 
				$page['page_title'], 
				$page['menu_title'], 
				$page['capability'], 
				$page['menu_slug'], 
				$page['callback'] 
			);
		}
	}

    public function setSettings( array $settings )
	{
		$this->settings = $settings;
		return $this;
	}

	public function setSections( array $sections )
	{
		$this->sections = $sections;
		return $this;
	}

	public function setFields( array $fields )
	{
		$this->fields = $fields;
		return $this;
	}

	public function registerCustomFields()
	{
		foreach ( $this->settings as $setting ) {
			register_setting( 
				$setting["option_group"], 
				$setting["option_name"], 
				( isset( $setting["callback"] ) ? $setting["callback"] : '' ) 
			);
		}

		foreach ( $this->sections as $section ) {
			add_settings_section( 
				$section["id"], 
				( isset( $section["title"] ) ? $section["title"] : '' ), 
				( isset( $section["callback"] ) ? $section["callback"] : '' ), 
				$section["page"] 
			);
		}

		foreach ( $this->fields as $field ) {
			add_settings_field( 
				$field["id"], 
				$field["title"], 
				( isset( $field["callback"] ) ? $field["callback"] : '' ), 
				$field["page"], 
				$field["section"], 
				( isset( $field["args"] ) ? $field["args"] : '' ) 
			);
		}
	}

	/*public function pageSubmit( $val ) {
		//var_dump($_POST);
		//var_dump($_SERVER['REQUEST_METHOD']);
		if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
			
			$cancel = false;
			$bld_grps = array( 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-' );

			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$blood_group = array_key_exists( 'blood_group', $_POST ) ? $_POST['blood_group'] : '0';
			$phone_number = $_POST['phone_number'];
			$email = $_POST['email'];
			$address = $_POST['address'];

			if ( strlen( $first_name ) <= 0 ) {
				AdminCallbacks::$donors_errors['first_name'][] = "Please enter a first name!";
				$cancel = true;
			}
			if ( strlen( $last_name ) <= 0 ) {
				AdminCallbacks::$donors_errors['last_name'][] = "Please enter a last name!";
				$cancel = true;
			}
			if ( !in_array( $blood_group, $bld_grps ) ) {
				AdminCallbacks::$donors_errors['blood_group'][] = 'Please select a blood type!';
				$cancel = true;
			}
			if ( strlen( $phone_number ) <= 0 ) {
				AdminCallbacks::$donors_errors['phone_number'][] = 'Please enter a phone number!';
				$cancel = true;
			}
			else {
				if( !preg_match('/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/', $phone_number ) ) {
					AdminCallbacks::$donors_errors['phone_number'][] = 'Please enter a valid phone number!';
					$cancel = true;
				}
			}

			if ( $cancel == true ) {
				return;
			}

			global $wpdb;
			$tablename_donors = $wpdb->prefix . 'donors'; 

			$result = $wpdb->insert( 
				$tablename_donors, 
				array( 
					'first_name' => $first_name, 
					'last_name' => $last_name, 
					'blood_group' => $blood_group, 
					'phone_number' => $phone_number, 
					'email' => $email, 
					'address' => $address, 
				), 
				array( 
					'%s', 
					'%s',
					'%s', 
					'%s',
					'%s', 
					'%s', 
				) 
			);

			if ( $result == false ) {
				AdminCallbacks::$sections_errors['donors'][] = 'An error occured when inserting data to the database!';
			}
		}
		
	}*/
}