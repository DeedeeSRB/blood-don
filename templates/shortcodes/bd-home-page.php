<?php

$current_user = wp_get_current_user();
if ( !$current_user->exists() ) {
    wp_safe_redirect( 'http://localhost/wordpress/login' );
    exit;
} 

if ( !$current_user->get( 'is_donor' ) ) {
    ?>
    <div class="row">
        <div class="col text-center">
            <div class="fs-4">You are not a donor</div>
            <div class="fs-5">To become a donor please choose your blood group</div>
        </div>
        <div class="col text-center">
            <div name="bd_be_donor_alert_box" id="bd_be_donor_alert_box" class="alert alert-danger alert-dismissible collapse role="alert"></div>
            <form name="bd_be_donor_form" id="bd_be_donor_form" onsubmit="return false">
                <label for="bd_be_donor_bg" class="form-label fs-5">Blood Group </label>
                <select id="bd_be_donor_bg" style="width: auto; display: inline;"
                        name="bd_be_donor_bg" class="form-control fs-5" required>
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
                <?php
                    $nonce = wp_create_nonce( 'bd_be_donor_nonce' );
                    echo '<button class="btn btn-success" type="submit" value="Submit" data-nonce="' . $nonce . '" onclick="submit_bd_be_donor(this)">Become a donor!</button>';
                ?>
            </form>
        </div>
    </div>

    <?php
    
}
else {
?>

<div>
    <div name="bd_home_page_alert_box" id="bd_home_page_alert_box" class="alert alert-danger alert-dismissible collapse"></div>
    <div class="row">
        <div class="col fs-3">To-Be-Accepted Donations</div>
        <button type="button" class="col-auto btn btn-success px-5" data-bs-toggle="modal" data-bs-target="#donateModal">Donate</button>
    </div>

    <div class="modal fade" id="donateModal" tabindex="-1" aria-labelledby="donateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donateModalLabel">Make Your Donation</h5>
                    <button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="bd_tba_donation_form" id="bd_tba_donation_form" onsubmit="return false">
                        <div id="bd_tba_donation_response_div"></div>
                        <div class="">
                            <label class="form-label fs-5" for="bd_tba_donation_amount_ml">Amount (mL): </label>
                            <input type="text" class="form-control" id="bd_tba_donation_amount_ml" name="bd_tba_donation_amount_ml" placeholder="200 ml" maxlength="45" required>
                        </div>
                        <div class="">
                            <label class="form-label fs-5" for="bd_tba_donation_time">Time: </label>
                            <input type="datetime-local" class="form-control" id="bd_tba_donation_time" name="bd_tba_donation_time" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <?php 
                            $nonce = wp_create_nonce("bd_tba_donation_submit_nonce");
                            echo '<input class="btn btn-success" type="submit" name="bd_tba_donation_submit" 
                            id="bd_delete_tba_donation_submit" data-nonce="' . $nonce . '"
                            value="Donate" onclick="submit_bd_tba_donation_submit_form(this)">';
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="my-5" id="bd_tba_donations_table">
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col">Amount (mL)</div>
                <div class="col">Time</div>
                <div class="col">Status</div>
                <div class="col col-8">Delete</div>
            </li>
            <?php 
                global $wpdb;

                $tablename_donations = $wpdb->prefix . 'donations'; 
                $query = "
                SELECT * 
                FROM $tablename_donations
                WHERE donor_id = $current_user->ID
                AND status = 'To Be Accepted';";

                $result = $wpdb->get_results( $query );
                if ( count($result) == 0 ) {
                    ?>
                    <li class="table-row">
                        <div class="col">There are no donations yet.</div>
                    </li>
                    <?php
                }
                foreach ( $result as $data ) {
                    ?>
                    <div name="bd_delete_donation_response_div_<?php echo $data->id ?>" 
                         id="bd_delete_donation_response_div_<?php echo $data->id ?>"
                         class="alert alert-success alert-dismissible collapse"></div>
                    <li class="table-row" id="bd_delete_donation_<?php echo $data->id ?>">
                        <div class="col" data-label="Amount (mL)"><?php echo $data->amount_ml ?></div>
                        <div class="col" data-label="Time"><?php echo $data->time ?></div>
                        <div class="col" data-label="Status"><?php echo $data->status ?></div>
                        <div class="col col-8" data-label="Delete">
                            <?php 
                                $nonce_del = wp_create_nonce("bd_delete_donation_nonce");
                                $id = $data->id;
                                echo '<button class="btn btn-danger" data-nonce="' . $nonce_del . '" name="bd_delete_donation" id="bd_delete_donation" value="' . $id . '" onclick="bd_delete_donation_submit(this)">X</button>';
                            ?>
                        </div>
                    </li>
                    <?php
                }
            ?>
        </ul>
    </div>
    <div class="fs-3">Your Donations</div>
    <div class="my-5">
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col">Amount (mL)</div>
                <div class="col">Time</div>
                <div class="col">Status</div>
            </li>
            <?php 
                global $wpdb;

                $tablename_donors = $wpdb->prefix . 'donations'; 
                $query = "
                SELECT * 
                FROM $tablename_donations
                WHERE donor_id = $current_user->ID
                AND status <> 'To Be Accepted';";

                $result = $wpdb->get_results( $query );
                if ( count($result) == 0 ) {
                    ?>
                    <li class="table-row">
                        <div class="col">There are no accepted donations yet.</div>
                    </li>
                    <?php
                }
                foreach ( $result as $data ) {
                    ?>
                    <li class="table-row">
                        <div class="col" data-label="Amount (mL)"><?php echo $data->amount_ml ?></div>
                        <div class="col" data-label="Time"><?php echo $data->time ?></div>
                        <div class="col" data-label="Status"><?php echo $data->status ?></div>
                    </li>
                    <?php
                }
            ?>
        </ul>
    </div>
    <div name="bd_cancel_donor_alert_box" id="bd_cancel_donor_alert_box" class="alert alert-danger alert-dismissible collapse role="alert"></div>
    <?php 
        $nonce = wp_create_nonce("bd_cancel_donor_nonce");
        $id = $current_user->ID;
        echo '<a class="fs-6" data-nonce="' . $nonce . '" value="' . $id . '" href="#" onclick="bd_cancel_donor(this)">Stop being a donor?</a>';
    ?>
</div>

<?php 
}