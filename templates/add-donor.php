<?php 

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
        Inc\Api\AdminCallbacks::$donors_errors['first_name'][] = "Please enter a first name!";
        $cancel = true;
    }
    if ( strlen( $last_name ) <= 0 ) {
        Inc\Api\AdminCallbacks::$donors_errors['last_name'][] = "Please enter a last name!";
        $cancel = true;
    }
    if ( !in_array( $blood_group, $bld_grps ) ) {
        Inc\Api\AdminCallbacks::$donors_errors['blood_group'][] = 'Please select a blood type!';
        $cancel = true;
    }
    if ( strlen( $phone_number ) <= 0 ) {
        Inc\Api\AdminCallbacks::$donors_errors['phone_number'][] = 'Please enter a phone number!';
        $cancel = true;
    }
    else {
        if( !preg_match('/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/', $phone_number ) ) {
            Inc\Api\AdminCallbacks::$donors_errors['phone_number'][] = 'Please enter a valid phone number!';
            $cancel = true;
        }
    }

    if ( $cancel == false ) {

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
            Inc\Api\AdminCallbacks::$sections_errors['donors'][] = 'An error occured when inserting data to the database!';
        }
    }

    //header("location: " . $_SERVER['REQUEST_URI']);
}

function returnErro( $name ) {
    $count = count(Inc\Api\AdminCallbacks::$donors_errors[$name]);
    if ( $count > 0 ) {
        echo '<div class="error-box">';
        for ($i = 0; $i <= $count; $i++) {
            echo '<div>'. array_pop(Inc\Api\AdminCallbacks::$donors_errors[$name]) .'</div>';
        }
        echo '</div>';
    }
}
?>

<div class="donor-form">
    <form method="post" action="">
        <div class="input-box">
            <label for="first_name">First Name: </label>
            <input type="text" class="input-field"  name="first_name" placeholder="First Name" maxlength="45" required>
            <?php returnErro( 'first_name' ); ?>
        </div>
        <div class="input-box">
            <label for="last_name">Last Name: </label>
            <input type="text" class="input-field"  name="last_name" placeholder="Last Name" maxlength="45" required>
            <?php returnErro( 'last_name' ); ?>
        </div>
        <div class="input-box">
            <label for="blood_group">Blood Group: </label>
            <select id="blood_group" style="width: auto; display: inline;"
                    name="blood_group" class="input-field" required>
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
            <?php returnErro( 'blood_group' ); ?>
        </div>
        <div class="input-box">
            <label for="phone_number">Phone Number: </label>
            <input type="tel" class="input-field"  name="phone_number" placeholder="0XXX-XXX-XXXX" maxlength="45" required>
            <?php returnErro( 'phone_number' ); ?>
        </div>
        <div class="input-box">
            <label for="email">Email: </label>
            <input type="email" class="input-field"  name="email" placeholder="someone@something.com" maxlength="45">
            <?php returnErro( 'email' ); ?>
        </div>
        <div class="input-box">
            <label for="address">Address: </label>
            <textarea class="input-field"  name="address" placeholder="Over there at that street" maxlength="100"></textarea>
            <?php returnErro( 'address' ); ?>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>