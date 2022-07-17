<ul class="responsive-table" id="donors-table">
    <li class="table-header">
        <div class="col col-1">Id</div>
        <div class="col col-2">First Name</div>
        <div class="col col-3">Last Name</div>
        <div class="col col-4">Blood Group</div>
        <div class="col col-5">Phone Number</div>
        <div class="col col-6">Email</div>
        <div class="col col-7">Address</div>
    </li>
    <?php 
        global $wpdb;

        $tablename_donors = $wpdb->prefix . 'donors'; 
        $query = "SELECT * FROM $tablename_donors";

        $result = $wpdb->get_results( $query );
        if ( count($result) == 0 ) {
            ?>
            <li class="table-row">
                <div class="col col-0">There are no donors yet.</div>
            </li>
            <?php
        }
        foreach ( $result as $data ) {
            ?>
            <li class="table-row">
                <div class="col col-1" data-label="Id"><?php echo $data->id ?></div>
                <div class="col col-2" data-label="First Name"><?php echo $data->first_name ?></div>
                <div class="col col-3" data-label="Last Name"><?php echo $data->last_name ?></div>
                <div class="col col-4" data-label="Blood Group"><?php echo $data->blood_group ?></div>
                <div class="col col-5" data-label="Phone Number"><?php echo $data->phone_number ?></div>
                <div class="col col-6" data-label="Email"><?php echo $data->email ?></div>
                <div class="col col-7" data-label="Address"><?php echo $data->address ?></div>
            </li>
            <?php
        }
    ?>
</ul>