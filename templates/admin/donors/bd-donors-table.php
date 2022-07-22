<div id="bd_approved_donors_table">
	<ul class="responsive-table">
		<li class="table-header">
			<div class="col col-1">ID</div>
			<div class="col">First Name</div>
			<div class="col">Last Name</div>
			<div class="col">Email</div>
			<div class="col">Phone Number</div>
			<div class="col">Address</div>
			<div class="col">Blood Group</div>
			<div class="col col-3">Manage</div>
		</li>
        <?php
            $users = get_users( array( 'fields' => array( 'id', 'user_email' ) ) );
            foreach($users as $user){
                $is_donor = get_user_meta( $user->id, 'is_donor' );
                if ( $is_donor != false ) {
                    $first_name = get_user_meta( $user->id, 'first_name' )[0];
                    $last_name = get_user_meta( $user->id, 'last_name' )[0];
                    $phone_number = get_user_meta( $user->id, 'phone_number' )[0];
                    $address = get_user_meta( $user->id, 'address' )[0];
                    $blood_group = get_user_meta( $user->id, 'blood_group' )[0];
                    ?>
                    <div id="bd-delete_donor_response_div_<?php echo $user->id ?>" hidden>
                        <li class="table-row">
                            <div class="col"></div>
                        </li>
                    </div>
                    <li class="table-row" id="delete_donor_<?php echo $user->id ?>">
                        <div class="col col-1" data-label="Id"><?php echo $user->id ?></div>
                        <div class="col" data-label="First Name"><?php echo $first_name ?></div>
                        <div class="col" data-label="Last Name"><?php echo $last_name ?></div>
                        <div class="col" data-label="Email"><?php echo $user->user_email ?></div>
                        <div class="col" data-label="Phone Number"><?php echo $phone_number ?></div>
                        <div class="col" data-label="Address"><?php echo $address ?></div>
                        <div class="col" data-label="Blood Group"><?php echo $blood_group ?></div>
                        <div class="col col-3" data-label="Manage">
                        <?php 
                            $nonce_del_donor = wp_create_nonce("bd_delete_donor_nonce");
                            echo '<button class="btn btn-danger" data-nonce="' . $nonce_del_donor . '" name="bd_delete_donor" id="bd_delete_donor" value="' . $user->id . '" onclick="bd_delete_donor_submit(this)">X</button>';
                        ?>
                        </div>
                    </li>
                    <?php
                }
            }
		?>
	</ul>
    
</div>