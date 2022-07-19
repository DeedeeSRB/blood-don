<?php 

	$path = preg_replace('/wp-content.*$/','',__DIR__);

	require_once($path."wp-load.php");

	if( isset( $_POST['donationFormSubmit'] ) && $_POST['donationFormSubmit'] == "1" )
	{
        $message = '';
        
        $return = [];
        $return['success'] = 1;
        $return['message'] = 'Donation added successfully!';
		$return['color'] = '#53ec86';

		$donor_id = sanitize_text_field($_POST['donor_id']);
		$amount_ml = sanitize_text_field($_POST['amount_ml']);
		$time = $_POST['time'];
        $status = sanitize_text_field($_POST['status']);

        global $wpdb;
        $tablename_donors = $wpdb->prefix . 'donors'; 

        $query = "SELECT * FROM $tablename_donors WHERE id = $donor_id";

        $result = $wpdb->get_row( $query );

        if ( $result === null ) {
            $return['success'] = 2;
            $return['message'] = 'Couldn\'t find donor with id ' . $donor_id;
            $return['color'] = '#f56565';
            echo json_encode($return);
            return;
        }

        if ( $donor_id == '' || $amount_ml == '' || $time == '' || $status == '') {
            $return['success'] = 2;
            $return['message'] = 'Please fill out all the required fields!';
            $return['color'] = '#f56565';
            echo json_encode($return);
            return;
        }

        if ( !is_numeric( $amount_ml ) ) {
            $message .= 'Please enter a numeric amount!';
            $return['success'] = 2;
            $return['color'] = '#f56565';
        }

        $status_avi = array( 'Completed', 'In progress', 'Planned' );
        if ( !in_array( $status, $status_avi ) ) {
            $message .= 'Please select a valid status!';
            $return['success'] = 2;
            $return['color'] = '#f56565';
        }


        if ( $return['success'] == 1) {

            $tablename_donations = $wpdb->prefix . 'donations'; 

            $result = $wpdb->insert( 
                $tablename_donations, 
                array( 
                    'donor_id' => $donor_id, 
                    'amount_ml' => $amount_ml, 
                    'time' => $time, 
                    'status' => $status, 
                ), 
                array( 
                    '%d', 
                    '%d',
                    '%s', 
                    '%s',
                ) 
            );

            if ( $result == false ) {
                $message = 'An error occured when adding donation!';
                $return['success'] = 2;
                $return['color'] = '#f56565';
            }
            else {
                $message = 'Donation added successfully!';
                $return['color'] = '#53ec86';
            }
        }

        if ( $message != '' ) $return['message'] = $message;
		echo json_encode($return);
	}

 ?>