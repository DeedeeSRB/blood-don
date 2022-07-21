<div id="donations-table">
    <ul class="responsive-table">
        <li class="table-header">
            <div class="col col-1">ID</div>
            <div class="col col-1">Donor ID</div>
            <div class="col col-9">Amount (mL)</div>
            <div class="col col-10">Time</div>
            <div class="col col-11">Status</div>
            <div class="col col-8">Delete</div>
        </li>
        <?php 
            global $wpdb;

            $tablename_donors = $wpdb->prefix . 'donations'; 
            $query = "SELECT * FROM $tablename_donors";

            $result = $wpdb->get_results( $query );
            if ( count($result) == 0 ) {
                ?>
                <li class="table-row">
                    <div class="col col-0">There are no donations yet.</div>
                </li>
                <?php
            }
            foreach ( $result as $data ) {
                ?>
                <div id="delete_donation_response_div_<?php echo $data->id ?>" hidden>
                    <li class="table-row">
                        <div class="col col-0"></div>
                    </li>
                </div>
                <li class="table-row" id="delete_donation_<?php echo $data->id ?>">
                    <div class="col col-1" data-label="ID"><?php echo $data->id ?></div>
                    <div class="col col-1" data-label="Donor ID"><?php echo $data->donor_id ?></div>
                    <div class="col col-9" data-label="Amount (mL)"><?php echo $data->amount_ml ?></div>
                    <div class="col col-10" data-label="Time"><?php echo $data->time ?></div>
                    <div class="col col-11" data-label="Status"><?php echo $data->status ?></div>
                    <div class="col col-8" data-label="Delete">
                        <?php 
                            $nonce = wp_create_nonce("delete_donation_nonce");
                            $id = $data->id;
                            echo '<button style="width: 30px; padding: 0px" data-nonce="' . $nonce . '" name="delete_donation" id="delete_donation" value="' . $id . '" onclick="delete_donation(this)">X</button>';
                        ?>
                    </div>
                </li>
                <?php
            }
        ?>
    </ul>
</div>