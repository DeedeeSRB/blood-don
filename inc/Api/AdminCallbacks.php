<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Api;

class AdminCallbacks
{
	public static $sections_errors = array (
		"donors" => array(),
		"donations" => array()
	);

	public static $donors_errors = array (
		"first_name" => array(),
		"last_name" => array(),
		"blood_group" => array(),
		"phone_number" => array(),
		"email" => array(),
		"address" => array(),
	);

	public static function adminDashboard()
	{
		return require_once BD_PLUGIN_PATH . 'templates/admin.php';
	}

	public static function bloodDonorSection() 
	{
		$count = count(AdminCallbacks::$sections_errors['donors']);
		if ( $count > 0 ) {
			echo '<div class="error-box">';
			for ($i = 0; $i <= $count; $i++) {
				echo '<div>'. array_pop(AdminCallbacks::$donors_errors['donors']) .'</div>';
			}
			echo '</div>';
		}
	}

	public static function bloodDonorFirstName()
	{
		echo '<input type="text" class="regular-text" name="first_name" placeholder="First Name" maxlength="45" required>';

		$count = count(AdminCallbacks::$donors_errors['first_name']);
		if ( $count > 0 ) {
			echo '<div class="error-box">';
			for ($i = 0; $i <= $count; $i++) {
				echo '<div>'. array_pop(AdminCallbacks::$donors_errors['first_name']) .'</div>';
			}
			echo '</div>';
		}
	}

	public static function bloodDonorLastName()
	{
		echo '<input type="text" class="regular-text" name="last_name" placeholder="Last Name" maxlength="45" required>';

		$count = count(AdminCallbacks::$donors_errors['last_name']);
		if ( $count > 0 ) {
			echo '<div class="error-box">';
			for ($i = 0; $i <= $count; $i++) {
				echo '<div>'. array_pop(AdminCallbacks::$donors_errors['last_name']) .'</div>';
			}
			echo '</div>';
		}
	}

	public static function bloodDonorBloodGroup( $args )
	{
		?>
		<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="<?php echo esc_attr( $args['label_for'] ); ?>" required>
			<option value="" selected disabled>Select</option>
			<option value="A+">A+</option>
			<option value="A-">A-</option>
			<option value="B+">B+</option>
			<option value="B-">B-</option>
			<option value="AB+">AB+</option>
			<option value="AB-">AB-</option>
			<option value="O+">O+</option>
			<option value="O-">O-</option>
		</select>
		<?php

		$count = count(AdminCallbacks::$donors_errors['blood_group']);
		if ( $count > 0 ) {
			echo '<div class="error-box">';
			for ($i = 0; $i <= $count; $i++) {
				echo '<div>'. array_pop(AdminCallbacks::$donors_errors['blood_group']) .'</div>';
			}
			echo '</div>';
		}
	}

	public static function bloodDonorPhoneNumber()
	{
		echo '<input type="tel" class="regular-text" name="phone_number" placeholder="0XXX-XXX-XXXX" maxlength="45" required>';

		$count = count(AdminCallbacks::$donors_errors['phone_number']);
		if ( $count > 0 ) {
			echo '<div class="error-box">';
			for ($i = 0; $i <= $count; $i++) {
				echo '<div>'. array_pop(AdminCallbacks::$donors_errors['phone_number']) .'</div>';
			}
			echo '</div>';
		}
	}

	public static function bloodDonorEmail()
	{
		echo '<input type="email" class="regular-text" name="email" placeholder="someone@something.com" maxlength="45">';

		$count = count(AdminCallbacks::$donors_errors['email']);
		if ( $count > 0 ) {
			echo '<div class="error-box">';
			for ($i = 0; $i <= $count; $i++) {
				echo '<div>'. array_pop(AdminCallbacks::$donors_errors['email']) .'</div>';
			}
			echo '</div>';
		}
	}

	public static function bloodDonorAddress()
	{
		echo '<textarea class="regular-text" name="address" placeholder="Over there at that street" maxlength="100"></textarea>';

		$count = count(AdminCallbacks::$donors_errors['address']);
		if ( $count > 0 ) {
			echo '<div class="error-box">';
			for ($i = 0; $i <= $count; $i++) {
				echo '<div>'. array_pop(AdminCallbacks::$donors_errors['address']) .'</div>';
			}
			echo '</div>';
		}
	}
	
}