<?php
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Manage;
use PasswordHash;

class AjaxManager
{
	public function register() 
	{
        add_action("wp_ajax_bd_register", array( $this , 'bd_register' ) );
        add_action("wp_ajax_nopriv_bd_register", array( $this , 'bd_register' ) );
        
        add_action("wp_ajax_bd_login", array( $this , 'bd_login' ) );
        add_action("wp_ajax_nopriv_bd_login", array( $this , 'bd_login' ) );

        add_action("wp_ajax_bd_be_donor", array( $this , 'bd_be_donor' ) );
        add_action("wp_ajax_bd_cancel_donor", array( $this , 'bd_cancel_donor' ) );

        add_action("wp_ajax_bd_edit_donor", array( $this , 'bd_edit_donor' ) );
        add_action("wp_ajax_bd_get_donor", array( $this , 'bd_get_donor' ) );
        
        add_action("wp_ajax_bd_add_tba_donation", array( $this , 'bd_add_tba_donation' ) );
        add_action("wp_ajax_bd_delete_donation", array( $this , 'bd_delete_donation' ) );
        add_action("wp_ajax_bd_approve_tba_donation", array( $this , 'bd_approve_tba_donation' ) );
        
        add_action("wp_ajax_bd_create_donation", array( $this , 'bd_create_donation' ) );
        add_action("wp_ajax_bd_edit_donation", array( $this , 'bd_edit_donation' ) );
        add_action("wp_ajax_bd_get_donation", array( $this , 'bd_get_donation' ) );

        $please_login = array( $this , 'please_login' );
        add_action("wp_ajax_nopriv_bd_be_donor", $please_login );
        add_action("wp_ajax_nopriv_bd_cancel_donor", $please_login );
        add_action("wp_ajax_nopriv_bd_edit_donor", $please_login );
        add_action("wp_ajax_nopriv_bd_get_donor", $please_login );
        add_action("wp_ajax_nopriv_bd_add_tba_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_delete_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_approve_tba_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_edit_donation", $please_login );
        add_action("wp_ajax_nopriv_bd_create_donation", $please_login );   
        add_action("wp_ajax_nopriv_bd_get_donation", $please_login );
	}

    public function bd_register() {
        
        // wp_delete_user( 2 );
        // $return['success'] = 2;
        // $return['message'] = 'Deleted successfuly!';
        // exit( json_encode( $return ) );

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_register_form_nonce") ) {
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
                'blood_group'       => '',
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

    public function bd_login() {

        if ( !wp_verify_nonce( $_POST['nonce'], "bd_login_form_nonce") ) {
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

    public function bd_be_donor() {

        if ( AjaxManager::security_check( "bd_be_donor_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_be_donor_nonce") ) );

        $id = sanitize_text_field($_POST['id']);

        if ( $id == -1) $id = wp_get_current_user()->id;
        
        $blood_group = sanitize_text_field($_POST['blood_group']);
        $bld_grps = array( 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-' );
        if ( !in_array( $blood_group, $bld_grps ) ) {
            $return['success'] = 2;
            $return['message'] = 'Please select a valid blood type!';
            exit( json_encode( $return ) );
        }
        
        $is_donor_result = update_user_meta( $id, 'is_donor', true );
        $blood_group_result = update_user_meta( $id, 'blood_group', $blood_group );

        if ( $is_donor_result === false || $blood_group_result === false ) {
            $return['success'] = 2;
            $return['message'] = 'Nothing changed';
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'User became a donor!';
        exit( json_encode( $return ) );
    }

    public function bd_cancel_donor() {

        if ( AjaxManager::security_check( "bd_cancel_donor_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_cancel_donor_nonce") ) );

        $donor_to_cancel = sanitize_text_field($_POST['donor_to_cancel']);
        
        $is_donor_result = update_user_meta( $donor_to_cancel, 'is_donor', false );
        $blood_group_result = update_user_meta( $donor_to_cancel, 'blood_group', '' );

        if ( $is_donor_result === false || $blood_group_result === false ) {
            $return['success'] = 2;
            $return['message'] = "Nothing changed $is_donor_result $blood_group_result $donor_to_cancel";
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'Removed donor successfuly!';
        $return['id'] = $donor_to_cancel;
        exit( json_encode( $return ) );
    }

    public function bd_edit_donor() {
        if ( AjaxManager::security_check( "bd_edit_donor_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_edit_donor_nonce") ) );

        $id_to_edit = sanitize_text_field($_POST['id']);
        $first_name = sanitize_text_field($_POST['first_name']);
		$last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
		$phone_number = sanitize_text_field($_POST['phone_number']);
        $blood_group = sanitize_text_field($_POST['blood_group']);
		$address = sanitize_textarea_field($_POST['address']);
		
        $user = get_userdata( $id_to_edit );
        if ( $user === false ) {
            $return['success'] = 2;
            $return['message'] = "Couldn't find donor with id $id_to_edit!";
            exit( json_encode( $return ) );
        } 

        $is_donor = get_user_meta( $id_to_edit, 'is_donor', true );
        if ( $is_donor === false ) {
            $return['success'] = 2;
            $return['message'] = "This user is not a donor!";
            exit( json_encode( $return ) );
        } 

        $userdata = array(   
            'ID'                    => $id_to_edit,
            'user_email'            => $email,   
            'first_name'            => $first_name,   
            'last_name'             => $last_name,   
            'meta_input'            => array(
                'phone_number'      => $phone_number, 
                'address'           => $address,
                'blood_group'       => $blood_group,
            ),
        );

        $user_id = wp_update_user( $userdata ) ;
 
        if ( is_wp_error( $user_id ) ) {
            $return['success'] = 2;
            $return['message'] = "An error occured when updating donor with ID $id_to_edit
            $first_name $last_name $email 
            $phone_number $blood_group $address!";
            exit( json_encode( $return ) );
        }

        $return['success'] = 1;
        $return['message'] = 'Donor update successfuly!';
        exit( json_encode( $return ) );
    }

    public function bd_get_donor() {

        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 

		$donor_id = sanitize_text_field($_POST['id']);
        
        $user = get_userdata( $donor_id );

        if ( $user === false ) {
            $return['success'] = 2;
            $return['message'] = 'An error occured when getting donor!';
            exit( json_encode($return) );
        }

        if ( !$user->get( 'is_donor' ) ) {
            $return['success'] = 2;
            $return['message'] = 'The user is not a donor!';
            exit( json_encode($return) );
        }

        $return['success'] = 1;
        $return['message'] = 'Got donor!';

        $return['first_name'] = $user->get( 'first_name' );
        $return['last_name'] = $user->get( 'last_name' );
        $return['email'] = $user->get( 'user_email' );
        $return['phone_number'] = $user->get( 'phone_number' );
        $return['blood_group'] = $user->get( 'blood_group' );
        $return['address'] = $user->get( 'address' );

        exit( json_encode($return) );
    }

    public function bd_add_tba_donation() {

        if ( AjaxManager::security_check( "bd_tba_donation_submit_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_tba_donation_submit_nonce") ) );

        $current_user = wp_get_current_user();
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
        $return = [];
        $return['success'] = 1;
        $return['message'] = 'Donation added successfully!';
        exit( json_encode( $return ) );
    }

    public function bd_delete_donation() {

        if ( AjaxManager::security_check( "bd_delete_donation_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_delete_donation_nonce") ) );
     
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

    public function bd_approve_tba_donation() {

        if ( AjaxManager::security_check( "bd_approve_tba_donation_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_approve_tba_donation_nonce") ) );
        
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

    public function bd_edit_donation() {
        
        if ( AjaxManager::security_check( "bd_edit_donation_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_edit_donation_nonce") ) );

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

    public function bd_create_donation() {

        if ( AjaxManager::security_check( "bd_create_donation_nonce")['success']  != 1 ) exit( json_encode( AjaxManager::security_check( "bd_create_donation_nonce") ) );

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

    public function bd_get_donation() {

        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            exit( json_encode( $return ) );
        } 

		$donation_id = sanitize_text_field($_POST['id']);
        
        global $wpdb;
        $tablename_donations = $wpdb->prefix . 'donations'; 

        $query = "SELECT * FROM $tablename_donations WHERE id = $donation_id;";
        $result = $wpdb->get_row( $query );

        if ( $result === null ) {
            $return['success'] = 2;
            $return['message'] = 'An error occured when getting donation!';
            exit( json_encode($return) );
        }

        $return['success'] = 1;
        $return['message'] = 'Got donation!';

        $return['donor_id'] = $result->donor_id;
        $return['amount_ml'] = $result->amount_ml;
        $return['time'] = $result->time;
        $return['status'] = $result->status;

        exit( json_encode($return) );
    }

    public function please_login() {
        $return = [];
        $return['success'] = 3;
        $return['message'] = 'Redirect';
        $return['color'] = '#f56565';
        exit( json_encode( $return ) );
    }

    public function security_check( $nonce ) {

        $return['success'] = 1;

        if ( !wp_verify_nonce( $_POST['nonce'], $nonce ) ) {
            $return['success'] = 2;
            $return['message'] = 'Nonce Error';
            return $return;
        }  

        $current_user = wp_get_current_user();
        if ( !$current_user->exists() ) {
            $return['success'] = 3;
            $return['message'] = 'Redirect login';
            return $return;
        } 

        return $return;
    }

}