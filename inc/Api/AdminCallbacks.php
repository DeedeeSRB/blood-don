<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Api;

class AdminCallbacks
{
	public static function adminDashboard()
	{
		return require_once BD_PLUGIN_PATH . 'templates/admin.php';
	}

	public static function adminCpt()
	{
        return require_once BD_PLUGIN_PATH . 'templates/cpt.php';
	}

	public static function adminTaxonomy()
	{
		return require_once BD_PLUGIN_PATH . 'templates/taxonomy.php';
	}

	public static function adminWidget()
	{
		return require_once BD_PLUGIN_PATH . 'templates/widget.php';
	}

	public static function bloodDonOptionsGroup( $input )
	{
		return $input;
	}

	public static function bloodDonAdminSection()
	{
		echo 'Check this beautiful section!';
	}

	public static function bloodDonTextExample()
	{
		$value = esc_attr( get_option( 'text_example' ) );
		echo '<input type="text" class="regular-text" name="text_example" value="' . $value . '" placeholder="Write Something Here!">';
	}

	public static function bloodDonFirstName()
	{
		$value = esc_attr( get_option( 'first_name' ) );
		echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="Write your First Name">';
	}
}