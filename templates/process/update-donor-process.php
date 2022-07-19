<?php 

	$path = preg_replace('/wp-content.*$/','',__DIR__);

	require_once($path."wp-load.php");

	if( isset( $_POST['updateDonorForm'] ) && $_POST['updateDonorForm'] == "1")
	{
        $id_to_update = sanitize_text_field( $_POST['id'] );

        $message = '';
        
        $return = [];
        $return['success'] = 1;
        $return['message'] = 'Update donor with id ' . $id_to_update;
		$return['color'] = '#53ec86';
		
        $first_name = sanitize_text_field($_POST['first_name']);
		$last_name = sanitize_text_field($_POST['last_name']);
		$blood_group = sanitize_text_field($_POST['blood_group']);
        $email = sanitize_email($_POST['email']);
		$phone_number = sanitize_text_field($_POST['phone_number']);
		$address = sanitize_textarea_field($_POST['address']);

        if ( $first_name == '' || $last_name == '' || $blood_group == '' || $phone_number == '') {
            $return['success'] = 2;
            $return['message'] = 'Please fill out all the required fields!';
            $return['color'] = '#f56565';
            echo json_encode($return);
            return;
        }
       
        $bld_grps = array( 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-' );
        if ( !in_array( $blood_group, $bld_grps ) ) {
            $message .= 'Please select a valid blood type!';
            $return['success'] = 2;
            $return['color'] = '#f56565';
        }
        
        if ( strlen($phone_number) != 0 ) {
            $message .= strlen($phone_number);
            if( !preg_match('/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/', $phone_number ) ) {
                $message .= 'Please enter a valid phone number!';
                $return['success'] = 2;
                $return['color'] = '#f56565';
            }
        }

        if ( $return['success'] == 1 ) {

            global $wpdb;
            $tablename_donors = $wpdb->prefix . 'donors'; 

            $result = $wpdb->update( 
                $tablename_donors, 
                array( 
                    'first_name' => $first_name, 
                    'last_name' => $last_name, 
                    'blood_group' => $blood_group, 
                    'phone_number' => $phone_number, 
                    'email' => $email, 
                    'address' => $address, 
                ), 
                array( 'id' => $id_to_update ), 
                array( 
                    '%s', 
                    '%s',
                    '%s', 
                    '%s',
                    '%s', 
                    '%s', 
                )
            );

            if ( $result === false ) {
                $message = 'Couldn\'t update donor with id ' . $id_to_update;
                $return['success'] = 2;
                $return['color'] = '#f56565';
            }
            else {
                $message = 'Updated donor with id ' . $id_to_update . ' successfuly';
                $return['success'] = 1;
                $return['color'] = '#53ec86';
            }
        }
                       
        if ( $message != '' ) $return['message'] = $message;
		echo json_encode($return);
	}

 ?>