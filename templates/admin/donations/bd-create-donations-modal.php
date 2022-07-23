<div class="modal fade" id="createDonationModal" aria-labelledby="createDonationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createDonationModalLabel">Create Donation</h5>
				<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form name="bd_create_donation_form" id="bd_create_donation_form" onsubmit="return false">
					<div class="my-3">
						<label class="form-label fs-5 w-100" for="bd_create_donation_donor_id">Donor: </label>
						<select id="bd_create_donation_donor_id" name="bd_create_donation_donor_id" class="form-select" style="width: 100%;" required>
							<option value="" selected disabled></option>
							<?php
							$users = get_users( array( 'fields' => array( 'ID' ) ) );
							foreach($users as $user){
								$is_donor = get_user_meta( $user->id, 'is_donor' )[0];
								if ( $is_donor != false ) {
									$first_name = get_user_meta( $user->id, 'first_name' );
									$last_name = get_user_meta( $user->id, 'last_name' );
									?>
										<option value="<?php echo $user->id ?>"><?php echo $first_name[0] ?> <?php echo $last_name[0] ?> (ID:<?php echo $user->id ?>)</option>
									<?php
								}
							}
							?>
						</select>
					</div>
					<div>
						<label class="form-label fs-5" for="bd_create_donation_amount_ml">Amount (mL): </label>
						<input type="text" class="form-control" id="bd_create_donation_amount_ml" name="bd_create_donation_amount_ml" placeholder="200 ml" maxlength="45" required>
					</div>
					<div class="my-3">
						<label class="form-label fs-5" for="bd_create_donation_time">Time: </label>
						<input type="datetime-local" class="form-control" id="bd_create_donation_time" name="bd_create_donation_time" required>
					</div>
					<div>
						<label class="form-label fs-5" for="bd_create_donation_status">Status: </label>
						<select id="bd_create_donation_status" name="bd_create_donation_status" class="form-select" style="width: 100%;" required>
							<option value="" selected disabled>Select</option>
							<option value="Completed">Completed</option>
							<option value="In progress">In progress</option>
							<option value="Planned">Planned</option>
							<option value="To Be Accepted">To Be Accepted</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<?php 
						$nonce = wp_create_nonce("bd_create_donation_nonce");
						echo '<input class="btn btn-success" data-nonce="' . $nonce . '" name="bd_create_donation_submit" 
						id="bd_create_donation_submit" onclick="bd_create_donation_submit_from(this)"
						type="submit" value="Confirm Donation">';
					?>
				</div>
			</form>
		</div>
	</div>
</div>