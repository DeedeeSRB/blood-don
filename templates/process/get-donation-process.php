<?php 

	$path = preg_replace('/wp-content.*$/','',__DIR__);

	require_once($path."wp-load.php");

	if( isset( $_POST['getDonationForm'] ) && $_POST['getDonationForm'] == "1")
	{
        $id_to_find = sanitize_text_field( $_POST['id'] );

        $message = '';
        
        $return = [];
        $return['success'] = 2;
        $return['message'] = 'Couldn\'t find donation with id ' . $id_to_find;
		$return['color'] = '#f56565';
		
        global $wpdb;
        $tablename_donations = $wpdb->prefix . 'donations'; 

        $query = "SELECT * FROM $tablename_donations WHERE id = $id_to_find";

        $result = $wpdb->get_row( $query );

        if ( $result !== null ) {
            $return['success'] = 1;
            $return['color'] = '#53ec86';

            $return['donor_id'] = $result->donor_id;
            $return['amount_ml'] = $result->amount_ml;
            $return['status'] = $result->status;
            $return['time'] = $result->time;
        }
                       
        if ( $message != '' ) $return['message'] = $message;
        $return['id'] = $id_to_find;
		echo json_encode($return);
	}

 ?>