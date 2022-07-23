<?php
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;
use PasswordHash;

class AjaxManager
{
	public static function register() 
	{
        add_action("wp_ajax_bd_register", array( 'Inc\Base\AjaxManager' , 'bd_register' ) );
        add_action("wp_ajax_nopriv_bd_register", array( 'Inc\Base\AjaxManager' , 'bd_register' ) );
        
        add_action("wp_ajax_bd_login", array( 'Inc\Base\AjaxManager' , 'bd_login' ) );
        add_action("wp_ajax_nopriv_bd_login", array( 'Inc\Base\AjaxManager' , 'bd_login' ) );

        add_action("wp_ajax_bd_be_donor", array( 'Inc\Base\AjaxManager' , 'bd_be_donor' ) );
        add_action("wp_ajax_bd_cancel_donor", array( 'Inc\Base\AjaxManager' , 'bd_cancel_donor' ) );
        
        add_action("wp_ajax_bd_add_tba_donation", array( 'Inc\Base\AjaxManager' , 'bd_add_tba_donation' ) );
        add_action("wp_ajax_bd_delete_donation", array( 'Inc\Base\AjaxManager' , 'bd_delete_donation' ) );
        add_action("wp_ajax_bd_approve_tba_donation", array( 'Inc\Base\AjaxManager' , 'bd_approve_tba_donation' ) );
        

        add_action("wp_ajax_bd_edit_donation", array( 'Inc\Base\AjaxManager' , 'bd_edit_donation' ) );
        add_action("wp_ajax_bd_create_donation", array( 'Inc\Base\AjaxManager' , 'bd_create_donation' ) );

        $please_login = array( 'Inc\Base\AjaxManager' , 'please_login' );

        add_action("wp_ajax_nopriv_bd_be_donor", $please_login );
        add_action("wp_ajax_nopriv_bd_cancel_donor", $please_login );
        add_action("wp_ajax_nopriv_bd_add_tba_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_delete_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_approve_tba_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_edit_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_create_donation", $please_login );   
	}

    public static function bd_register() {
        
        // wp_delete_user( 2 );
        // $return['success'] = 2;
        // $return['message'] = 'Deleted successfuly!';
        // exit( json_encode( $return ) );

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_register_form_nonce")) {
            $return = [];
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        }  

        $username = sanitize_text_field($_POST['username']);
        $first_name = sanitize_text_field($_POST['first_name']);
		$last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
		$phone_number = sanitize_text_field($_POST['phone_number']);
		$address = sanitize_textarea_field($_POST['address']);
		$password = sanitize_text_field($_POST['password']);

        if ( $first_name == '' || $last_name == '' || $username == '' || $email == '' || $password == '' ) {
            $return['success'] = 2;
            $return['message'] = 'Please fill out all the required fields!';
            exit( json_encode( $return ) );
        }

        $user = get_user_by( 'login', $username );

        if ( $user !== false ) {
            $return['success'] = 2;
            $return['message'] = 'The username ' . $user->user_login . ' with ID ' . $user->ID . ' already exists!';
            exit( json_encode( $return ) );
        }

        $userdata = array(
            'user_pass'             => $password,   
            'user_login'            => $username,   
            'user_email'            => $email,   
            'first_name'            => $first_name,   
            'last_name'             => $last_name,   
            'meta_input'            => array(
                'is_donor'          => 0, 
                'phone_number'      => $phone_number, 
                'address'           => $address,
                'blood_group'           => '',
            ),
        );

        $user_id = wp_insert_user( $userdata ) ;
 
        
        if ( is_wp_error( $user_id ) ) {
            $return['success'] = 2;
            $return['message'] = 'An error occured when registering!';
            exit( json_encode( $return ) );
        }

        wp_clear_auth_cookie();
        wp_set_current_user( $user_id );
        wp_set_auth_cookie( $user_id );

        $return['success'] = 1;
        $return['message'] = 'Registered successfuly!';
        exit( json_encode( $return ) );
    }

    public static function bd_login() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_login_form_nonce")) {
            $return = [];
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        }  

        $username = sanitize_text_field($_POST['username']);
		$password = sanitize_text_field($_POST['password']);

        if ( $username == '' || $password == '' ) {
            $return['success'] = 2;
            $return['message'] = 'Please fill out all the required fields!';
            exit( json_encode( $return ) );
        }

        $user = get_user_by( 'login', $username );

        if ( $user === false ) {
            $return['success'] = 2;
            $return['message'] = 'The username or password is wrong!';
            exit( json_encode( $return ) );
        }

        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash( 8, true );

        if( !$wp_hasher->CheckPassword( $password, $user->get( 'user_pass' ) ) ) {
            $return['success'] = 2;
            $return['message'] = 'The username or password is wrong!';
            exit( json_encode( $return ) );
        } 

        wp_clear_auth_cookie();
        wp_set_current_user( $user->get( 'id' ) );
        wp_set_auth_cookie( $user->get( 'id' ) );

        $return['success'] = 1;
        $return['message'] = 'Logged in successfuly';
        exit( json_encode( $return ) );

    }

    public static function bd_be_donor() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_be_donor_nonce")) {
            $return = [];
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        }  

        $blood_group = sanitize_text_field($_POST['blood_group']);
        $bld_grps = array( 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-' );
        if ( !in_array( $blood_group, $bld_grps ) ) {
            $return['success'] = 2;
            $return['message'] = 'Please select a valid blood type!';
            exit( json_encode( $return ) );
        }
        
        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 
        
        $is_donor_result = update_user_meta( $current_user->id, 'is_donor', true );
        $blood_group_result = update_user_meta( $current_user->id, 'blood_group', $blood_group );

        if ( $is_donor_result === false || $blood_group_result === false ) {
            $return['success'] = 2;
            $return['message'] = 'Nothing changed';
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'You became a donor!';
        exit( json_encode( $return ) );
    }

    public static function bd_cancel_donor() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_cancel_donor_nonce")) {
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        }  
        
        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 

        $donor_to_cancel = sanitize_text_field($_POST['donor_to_cancel']);
        
        $is_donor_result = update_user_meta( $donor_to_cancel, 'is_donor', false );
        $blood_group_result = update_user_meta( $donor_to_cancel, 'blood_group', '' );

        if ( $is_donor_result === false || $blood_group_result === false ) {
            $return['success'] = 2;
            $return['message'] = 'Nothing changed';
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'You are no longer a donor!';
        exit( json_encode( $return ) );
    }

    public static function bd_add_tba_donation() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_tba_donation_submit_nonce")) {
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        }
        
        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 

        $donor_id = $current_user->ID;
		$amount_ml = sanitize_text_field($_POST['amount_ml']);
		$time = $_POST['time'];

        if ( !is_numeric( $amount_ml ) ) {
            $return['success'] = 2;
            $return['message'] = 'Please enter a numeric amount!';
            exit( json_encode( $return ) );
        }

        global $wpdb;
        $tablename_donations = $wpdb->prefix . 'donations'; 

        $result = $wpdb->insert( 
            $tablename_donations, 
            array( 
                'donor_id' => $donor_id, 
                'amount_ml' => $amount_ml, 
                'time' => $time, 
                'status' => 'To Be Accepted', 
            ), 
            array( 
                '%d', 
                '%d',
                '%s', 
                '%s',
            ) 
        );

        if ( $result == false ) {
            $return['success'] = 2;
            $return['message'] = 'An error occured when adding donation!';
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'Donation added successfully!';
        exit( json_encode( $return ) );
    }

    public static function bd_delete_donation() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_delete_donation_nonce")) {
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        } 

        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 
        
		$id_to_delete = sanitize_text_field( $_POST['id_to_delete'] );
		
        
        global $wpdb;
        $tablename_donations = $wpdb->prefix . 'donations'; 

        $result = $wpdb->delete( 
            $tablename_donations, 
            array( 
                'id' => $id_to_delete, 
            ),
        );

        if ( $result == false ) {
            $return['success'] = 2;
            $return['success'] = 'An error occured when deleting donation with id ' . $id_to_delete;
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'Donation deleted successfully!';          
        $return['id'] = $id_to_delete;
		exit( json_encode( $return ) );
    }

    public static function bd_approve_tba_donation() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_approve_tba_donation_nonce")) {
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        } 

        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 
        
		$id_to_approve = sanitize_text_field( $_POST['id_to_approve'] );
		
        global $wpdb;
        $tablename_donations = $wpdb->prefix . 'donations'; 

        $result = $wpdb->update( 
            $tablename_donations, 
            array( 'status' => 'Planned' ), 
            array( 'ID' => $id_to_approve ), 
            array( '%s' )
        );

        if ( $result == false ) {
            $return['success'] = 2;
            $return['success'] = 'An error occured when deleting donation with id ' . $id_to_approve;
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'Donation approved successfully!';          
        $return['id'] = $id_to_approve;
		exit( json_encode( $return ) );
    }

    public static function bd_edit_donation() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_edit_donation_nonce")) {
            $return = [];
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        }  

        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 

        $id_to_update = sanitize_text_field( $_POST['id'] );
		
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
            exit( json_encode($return) );
        }

        if ( $donor_id != -1 ) {
            $result = get_userdata( $donor_id );
    
            if ( $result === null ) {
                $return['success'] = 2;
                $return['message'] = 'Couldn\'t find donor with id ' . $donor_id;
                exit( json_encode($return) );
            }

            $is_donor = $result->get('is_donor');
            if ( $is_donor == false ) {
                $return['success'] = 2;
                $return['message'] = 'User with id ' . $donor_id . ' is not a donor!';
                exit( json_encode($return) );
            }
        }

        if ( !is_numeric( $amount_ml ) ) {
            $return['success'] = 2;
            $return['message'] = 'Please enter a numeric amount!';
            exit( json_encode($return) );
        }

        $status_avi = array( 'Completed', 'In progress', 'Planned', 'To Be Accepted' );
        if ( !in_array( $status, $status_avi ) ) {
            $return['success'] = 2;
            $return['message'] = 'Please select a valid status!';
            exit( json_encode($return) );
        }
        
        if ( $donor_id != -1 ) {
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
        }
        else {
            $result = $wpdb->update( 
                $tablename_donations, 
                array( 
                    'amount_ml' => $amount_ml, 
                    'time' => $time, 
                    'status' => $status, 
                ),
                array( 'id' => $id_to_update ), 
                array( 
                    '%d',
                    '%s', 
                    '%s',
                )
            );
        }

        if ( $result === false ) {
            $return['success'] = 2;
            $return['message'] = 'Couldn\'t update donation with id ' . $id_to_update;
            exit( json_encode($return) );
        }

        $return['success'] = 1;
        $return['message'] = 'Updated donor with id ' . $id_to_update . ' successfuly';
        exit( json_encode($return) );
    }

    public static function bd_create_donation() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_create_donation_nonce" ) ) {
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            exit( json_encode( $return ) );
        }  

        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 

		$donor_id = sanitize_text_field($_POST['donor_id']);
		$amount_ml = sanitize_text_field($_POST['amount_ml']);
		$time = $_POST['time'];
        $status = sanitize_text_field($_POST['status']);

        
        $result = get_userdata( $donor_id );

        if ( $result === null ) {
            $return['success'] = 2;
            $return['message'] = 'Couldn\'t find donor with id ' . $donor_id;
            exit( json_encode($return) );
        }

        $is_donor = $result->get('is_donor');
        if ( $is_donor == false ) {
            $return['success'] = 2;
            $return['message'] = 'User with id ' . $donor_id . ' is not a donor!';
            exit( json_encode($return) );
        }
        

        if ( $donor_id == '' || $amount_ml == '' || $time == '' || $status == '') {
            $return['success'] = 2;
            $return['message'] = 'Please fill out all the required fields!';
            exit( json_encode($return) );
        }

        if ( !is_numeric( $amount_ml ) ) {
            $return['success'] = 2;
            $return['message'] = 'Please enter a numeric amount!';
            exit( json_encode($return) );
        }

        $status_avi = array( 'Completed', 'In progress', 'Planned', 'To Be Accepted' );
        if ( !in_array( $status, $status_avi ) ) {
            $return['success'] = 2;
            $return['message'] = 'Please select a valid status!';
            exit( json_encode($return) );
        }
        
        global $wpdb;
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
            $return['success'] = 2;
            $return['message'] = 'An error occured when adding donation!';
            exit( json_encode($return) );
        }
        
        $return['success'] = 1;
        $return['message'] = 'Donation added successfully!';
        exit( json_encode($return) );
        
    }

    public static function please_login() {
        $return = [];
        $return['success'] = 3;
        $return['message'] = 'Redirect';
        $return['color'] = '#f56565';
        exit( json_encode( $return ) );
    }

}