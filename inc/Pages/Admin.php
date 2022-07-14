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
		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
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

	public function setSubpages() 
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'blood_donation_plugin', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'blood_donation_cpt', 
				'callback' => array( 'Inc\Api\AdminCallbacks', 'adminCpt' )
			),
			array(
				'parent_slug' => 'blood_donation_plugin', 
				'page_title' => 'Custom Taxonomies', 
				'menu_title' => 'Taxonomies', 
				'capability' => 'manage_options', 
				'menu_slug' => 'blood_donation_taxonomies', 
				'callback' => array( 'Inc\Api\AdminCallbacks', 'adminTaxonomy' )
			),
			array(
				'parent_slug' => 'blood_donation_plugin', 
				'page_title' => 'Custom Widgets', 
				'menu_title' => 'Widgets', 
				'capability' => 'manage_options', 
				'menu_slug' => 'blood_donation_widgets', 
				'callback' => array( 'Inc\Api\AdminCallbacks', 'adminWidget' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'blood_don_options_group',
				'option_name' => 'text_example',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonOptionsGroup' )
			),
			array(
				'option_group' => 'blood_don_options_group',
				'option_name' => 'first_name'
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'blood_don_admin_index',
				'title' => 'Settings',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonAdminSection' ),
				'page' => 'blood_donation_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'text_example',
				'title' => 'Text Example',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonTextExample' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_don_admin_index',
				'args' => array(
					'label_for' => 'text_example',
					'class' => 'example-class'
				)
			),
			array(
				'id' => 'first_name',
				'title' => 'First Name',
				'callback' => array( 'Inc\Api\AdminCallbacks', 'bloodDonFirstName' ),
				'page' => 'blood_donation_plugin',
				'section' => 'blood_don_admin_index',
				'args' => array(
					'label_for' => 'first_name',
					'class' => 'example-class'
				)
			)
		);

		$this->settings->setFields( $args );
	}
}