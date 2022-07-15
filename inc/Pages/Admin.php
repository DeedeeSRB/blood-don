<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;

class Admin
{
	public $settings;

	public $pages = array();

	public $subpages = array();


	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->setPages();
		//$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		//$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
		$this->settings->addPages( $this->pages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Blood Donation Plugin', 
				'menu_title' => 'Blood Donations', 
				'capability' => 'manage_options', 
				'menu_slug' => 'blood_donation_plugin', 
				'callback' => array( 'Inc\Api\AdminCallbacks', 'adminDashboard' ), 
				'icon_url' => 'dashicons-heart', 
				'position' => 110
			)
		);
	}

	// public function setSubpages() 
	// {
	// 	$this->subpages = array(
	// 		array(
	// 			'parent_slug' => 'blood_donation_plugin', 
	// 			'page_title' => 'Custom Post Types', 
	// 			'menu_title' => 'CPT', 
	// 			'capability' => 'manage_options', 
	// 			'menu_slug' => 'blood_donation_cpt', 
	// 			'callback' => array( 'Inc\Api\AdminCallbacks', 'adminCpt' )
	// 		),
	// 		array(
	// 			'parent_slug' => 'blood_donation_plugin', 
	// 			'page_title' => 'Custom Taxonomies', 
	// 			'menu_title' => 'Taxonomies', 
	// 			'capability' => 'manage_options', 
	// 			'menu_slug' => 'blood_donation_taxonomies', 
	// 			'callback' => array( 'Inc\Api\AdminCallbacks', 'adminTaxonomy' )
	// 		),
	// 		array(
	// 			'parent_slug' => 'blood_donation_plugin', 
	// 			'page_title' => 'Custom Widgets', 
	// 			'menu_title' => 'Widgets', 
	// 			'capability' => 'manage_options', 
	// 			'menu_slug' => 'blood_donation_widgets', 
	// 			'callback' => array( 'Inc\Api\AdminCallbacks', 'adminWidget' )
	// 		)
	// 	);
	// }

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'blood_donors_options_group',
				'option_name' => 'first_name',
			),
			array(
				'option_group' => 'blood_donors_options_group',
				'option_name' => 'last_name'
			),
			array(
				'option_group' => 'blood_donors_options_group',
				'option_name' => 'blood_group',
			),
			array(
				'option_group' => 'blood_donors_options_group',
				'option_name' => 'phone_number'
			),
			array(
				'option_group' => 'blood_donors_options_group',
				'option_name' => 'email',
			),
			array(
				'option_group' => 'blood_donors_options_group',
				'option_name' => 'address'
			),
			array(
				'option_group' => 'blood_donations_options_group',
				'option_name' => 'donor_id',
			),
			array(
				'option_group' => 'blood_donations_options_group',
				'option_name' => 'amount_ml'
			),
			array(
				'option_group' => 'blood_donations_options_group',
				'option_name' => 'time',
			),
			array(
				'option_group' => 'blood_donations_options_group',
				'option_name' => 'status'
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'blood_donors_section',
				'page' => 'blood_donation_plugin'
			),
			array(
				'id' => 'blood_donations_section',
				'page' => 'blood_donation_plugin'
			),
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'first_name',
				'title' => 'First Name',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonorFirstName' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_donors_section',
				'args' => array(
					'label_for' => 'first_name',
					'class' => '',
				)
			),
			array(
				'id' => 'last_name',
				'title' => 'Last Name',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonorLastName' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_donors_section',
				'args' => array(
					'label_for' => 'last_name',
					'class' => ''
				)
			),
			array(
				'id' => 'blood_group',
				'title' => 'Blood Group',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonorBloodGroup' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_donors_section',
				'args' => array(
					'label_for' => 'blood_group',
					'class' => '',
				)
			),
			array(
				'id' => 'phone_number',
				'title' => 'Phone Number',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonorPhoneNumber' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_donors_section',
				'args' => array(
					'label_for' => 'phone_number',
					'class' => ''
				)
			),
			array(
				'id' => 'email',
				'title' => 'Email',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonorEmail' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_donors_section',
				'args' => array(
					'label_for' => 'email',
					'class' => '',
				)
			),
			array(
				'id' => 'address',
				'title' => 'Address',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonorAddress' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_donors_section',
				'args' => array(
					'label_for' => 'addresss',
					'class' => ''
				)
			),
			
		);

		$this->settings->setFields( $args );
	}
}