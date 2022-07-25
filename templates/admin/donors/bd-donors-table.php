<div id="bd_donors_table">
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
                $is_donor = get_user_meta( $user->id, 'is_donor', true );
                if ( $is_donor != false ) {
                    $first_name = get_user_meta( $user->id, 'first_name', true );
                    $last_name = get_user_meta( $user->id, 'last_name', true );
                    $phone_number = get_user_meta( $user->id, 'phone_number', true );
                    $address = get_user_meta( $user->id, 'address', true );
                    $blood_group = get_user_meta( $user->id, 'blood_group', true );
                    ?>
                    <div name="bd_delete_donor_response_div_<?= $user->id ?>" 
					id="bd_delete_donor_response_div_<?= $user->id ?>"
					class="alert alert-success alert-dismissible collapse"></div>
                    <li class="table-row" id="delete_donor_<?= $user->id ?>">
                        <div class="col col-1" data-label="Id"><?= $user->id ?></div>
                        <div class="col" data-label="First Name"><?= $first_name ?></div>
                        <div class="col" data-label="Last Name"><?= $last_name ?></div>
                        <div class="col" data-label="Email"><?= $user->user_email ?></div>
                        <div class="col" data-label="Phone Number"><?= $phone_number ?></div>
                        <div class="col" data-label="Address"><?= $address ?></div>
                        <div class="col" data-label="Blood Group"><?= $blood_group ?></div>
                        <div class="col col-3" data-label="Manage">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-fn="<?= $first_name ?>" data-ln="<?= $last_name ?>"
                                    data-email="<?= $user->user_email ?>" data-pn="<?= $phone_number ?>" data-id="<?= $user->id ?>"
                                    data-address="<?= $address ?>" data-bg="<?= $blood_group ?>" data-preset="true"
                                    data-bs-target="#editDonorModal" onclick="bd_set_edit_donor_form(this)">
                                    <i class="fas fa-pen text-light"></i></button>
                                </div>
                                <div class="col-auto">
                                    <?php 
                                        $nonce = wp_create_nonce( 'bd_cancel_donor_nonce' );
                                        echo '<button class="btn btn-danger" data-nonce="' . $nonce . '" name="bd_delete_donor" id="bd_delete_donor" value="' . $user->id . '" onclick="bd_cancel_donor(this)">X</button>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            }
		?>
	</ul>
    
</div>