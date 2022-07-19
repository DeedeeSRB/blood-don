<?php 

	$path = preg_replace('/wp-content.*$/','',__DIR__);

	require_once($path."wp-load.php");

	if( isset( $_POST['updateDonationForm'] ) && $_POST['updateDonationForm'] == "1")
	{
        $id_to_update = sanitize_text_field( $_POST['id'] );

        $message = '';
        
        $return = [];
        $return['success'] = 1;
        $return['message'] = 'Update donation with id ' . $id_to_update;
		$return['color'] = '#53ec86';
		
        $donor_id = sanitize_text_field($_POST['donor_id']);
		$amount_ml = sanitize_text_field($_POST['amount_ml']);
		$time = $_POST['time'];
        $status = sanitize_text_field($_POST['status']);

        global $wpdb;
        $tablename_donations = $wpdb->prefix . 'donations'; 

        $query = "SELECT * FROM $tablename_donations WHERE id = $id_to_update";

        $result = $wpdb->get_row( $query );

        if ( $result === null ) {
            $return['success'] = 2;
            $return['message'] = 'Couldn\'t find donation with id ' . $id_to_update;
            $return['color'] = '#f56565';
            echo json_encode($return);
            return;
        }

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
        

        if ( $return['success'] == 1 ) {

            $result = $wpdb->update( 
                $tablename_donations, 
                array( 
                    'donor_id' => $donor_id, 
                    'amount_ml' => $amount_ml, 
                    'time' => $time, 
                    'status' => $status, 
                ),
                array( 'id' => $id_to_update ), 
                array( 
                    '%d', 
                    '%d',
                    '%s', 
                    '%s',
                )
            );

            if ( $result === false ) {
                $message = 'Couldn\'t update donation with id ' . $id_to_update;
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