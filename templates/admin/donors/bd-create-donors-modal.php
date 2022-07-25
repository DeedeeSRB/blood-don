<div class="modal fade" id="addDonorModal" aria-labelledby="addDonorModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addDonorModalLabel">Create donor</h5>
				<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form name="bd_create_donor_form" id="bd_create_donor_form" onsubmit="return false">
                    <div class="row">
                        <div class="col">
                            <label class="form-label fs-5 w-100" for="bd_create_donor_user_id">Donor</label>
                            <select id="bd_create_donor_user_id" name="bd_create_donor_user_id" class="form-select" style="width: 100%;" required>
                                <option value="" selected disabled></option>
                                <?php
                                $users = get_users( array( 'fields' => array( 'ID' ) ) );
                                foreach($users as $user){
                                    $is_donor = get_user_meta( $user->id, 'is_donor', true );
                                    if ( $is_donor == false ) {
                                        $first_name = get_user_meta( $user->id, 'first_name', true );
                                        $last_name = get_user_meta( $user->id, 'last_name', true );
                                        ?>
                                            <option value="<?php echo $user->id ?>"><?php echo $first_name ?> <?php echo $last_name ?> (ID:<?php echo $user->id ?>)</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label fs-5" for="bd_be_donor_bg">Blood Group</label>
                            <select id="bd_be_donor_bg" style="width: 100%; display: inline;"
                                    name="bd_be_donor_bg" class="form-control" required>
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
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<?php 
						$nonce = wp_create_nonce("bd_be_donor_nonce");
						echo '<input class="btn btn-success" data-nonce="' . $nonce . '" name="bd_create_donor_submit" 
						id="bd_create_donor_submit" onclick="submit_bd_be_donor(this)"
						type="submit" value="Confirm donor">';
					?>
				</div>
			</form>
		</div>
	</div>
</div>