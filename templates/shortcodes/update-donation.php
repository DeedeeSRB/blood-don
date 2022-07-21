<div class="donor-form">
    <form name="update_donation_form" id="update_donation_form" onsubmit="return false">
        <div id="update_donation_response_div"></div>
        <div class="input-box">
            <label for="donation_id">ID: </label>
            <select id="donation_id" name="donation_id" class="input-field" required>
                <option value="" selected disabled></option>
                <?php 
                    global $wpdb;
                    $tablename_donations = $wpdb->prefix . 'donations'; 
                    $query = "SELECT * FROM $tablename_donations";

                    $result = $wpdb->get_results( $query );
                    
                    foreach ( $result as $data ) {
                        ?>
                            <option value="<?php echo $data->id ?>"><?php echo $data->id . ' ' . $data->time ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div class="input-box">
            <label for="ud_donor_id">Donor ID: </label>
            <input type="text" class="input-field" id="ud_donor_id" name="ud_donor_id" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="ud_amount_ml">Amount (mL): </label>
            <input type="text" class="input-field" id="ud_amount_ml" name="ud_amount_ml" placeholder="200 ml" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="ud_time">Time: </label>
            <input type="datetime-local" class="input-field" id="ud_time" name="ud_time" required>
        </div>
        <div class="input-box">
            <label for="ud_status">Blood Group: </label>
            <select id="ud_status" style="width: auto; display: inline;"
                    name="ud_status" class="input-field" required>
                <option value="" selected disabled>Select</option>
                <option value="Completed">Completed</option>
                <option value="In progress">In progress</option>
                <option value="Planned">Planned</option>
            </select>
        </div>
        <?php 
            $nonce = wp_create_nonce("update_donation_nonce");
            echo '<input type="submit" name="update_donation_submit" id="update_donation_submit" data-nonce="' . $nonce . '" value="Update" onclick="submit_update_donation_form(this)">';
        ?>
    </form>
</div>