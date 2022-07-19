<?php 

	$path = preg_replace('/wp-content.*$/','',__DIR__);

	require_once($path."wp-load.php");

	if( isset( $_POST['deleteDonationSubmit'] ) && $_POST['deleteDonationSubmit'] == "1")
	{
        $message = '';
        
        $return = [];
        $return['success'] = 1;
        $return['message'] = 'Donation deleted successfully!';
		$return['color'] = '#53ec86';
        
		/* get the information from the post submit */
		$id_to_delete = sanitize_text_field( $_POST['id_to_delete'] );
		
        if ( $return['success'] == 1) {

            global $wpdb;
            $tablename_donations = $wpdb->prefix . 'donations'; 

            $result = $wpdb->delete( 
                $tablename_donations, 
                array( 
                    'id' => $id_to_delete, 
                ),
            );

            if ( $result == false ) {
                $message = 'An error occured when deleting donation with id ' . $id_to_delete;
                $return['success'] = 2;
                $return['color'] = '#f56565';
            }
            else {
                $message = 'Donation deleted successfully!';
                $return['color'] = '#53ec86';
            }
        }                

        if ( $message != '' ) $return['message'] = $message;
        $return['id'] = $id_to_delete;
		echo json_encode($return);
	}

 ?>