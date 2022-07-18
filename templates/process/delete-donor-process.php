<?php 

	$path = preg_replace('/wp-content.*$/','',__DIR__);

	require_once($path."wp-load.php");

	if( isset( $_POST['deleteDonorSubmit'] ) && $_POST['deleteDonorSubmit'] == "1")
	{
        $message = '';
        
        $return = [];
        $return['success'] = 1;
        $return['message'] = 'Donor deleted successfully!';
		$return['color'] = '#53ec86';
        
		/* get the information from the post submit */
		$id_to_delete = sanitize_text_field( $_POST['id_to_delete'] );
		
        if ( $return['success'] == 1) {
            global $wpdb;
            $tablename_donors = $wpdb->prefix . 'donors'; 

            $result = $wpdb->delete( 
                $tablename_donors, 
                array( 
                    'id' => $id_to_delete, 
                ),
            );

            if ( $result == false ) {
                $message = 'An error occured when deleting donor with id ' . $id_to_delete;
                $return['success'] = 2;
                $return['color'] = '#f56565';
            }
            else {
                $message = 'Donor deleted successfully!';
                $return['color'] = '#53ec86';
            }
        }                

        if ( $message != '' ) $return['message'] = $message;
        $return['id'] = $id_to_delete;
		echo json_encode($return);
	}

 ?>