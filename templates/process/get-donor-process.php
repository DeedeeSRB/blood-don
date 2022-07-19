<?php 

	$path = preg_replace('/wp-content.*$/','',__DIR__);

	require_once($path."wp-load.php");

	if( isset( $_POST['getDonorForm'] ) && $_POST['getDonorForm'] == "1")
	{
        $id_to_find = sanitize_text_field( $_POST['id'] );

        $message = '';
        
        $return = [];
        $return['success'] = 2;
        $return['message'] = 'Couldn\'t find donor with id ' . $id_to_find;
		$return['color'] = '#f56565';
		
        global $wpdb;
        $tablename_donors = $wpdb->prefix . 'donors'; 

        $query = "SELECT * FROM $tablename_donors WHERE id = $id_to_find";

        $result = $wpdb->get_row( $query );

        if ( $result !== null ) {
            $return['success'] = 1;
            $return['color'] = '#53ec86';

            $return['first_name'] = $result->first_name;
            $return['last_name'] = $result->last_name;
            $return['blood_group'] = $result->blood_group;
            $return['phone_number'] = $result->phone_number;
            $return['email'] = $result->email;
            $return['address'] = $result->address;
        }
                       
        if ( $message != '' ) $return['message'] = $message;
		echo json_encode($return);
	}

 ?>