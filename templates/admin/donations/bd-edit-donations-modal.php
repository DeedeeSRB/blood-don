<div class="modal fade" id="editDonationModal" aria-labelledby="editDonationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editDonationModalLabel">Edit Donation</h5>
				<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form name="bd_edit_donation_form" id="bd_edit_donation_form" onsubmit="return false">
					<div id="bd_edit_donation_id_sec">
						<label class="form-label fs-5 w-100" for="bd_edit_donation_id">Donation</label>
						<select id="bd_edit_donation_id" name="bd_edit_donation_id" class="form-select" style="width: 100%;">
							<option value="" selected disabled></option>
							<?php
							global $wpdb;

							$tablename_donations = $wpdb->prefix . 'donations'; 
							$query = "
							SELECT * 
							FROM $tablename_donations;";
				
							$donations = $wpdb->get_results( $query );
							foreach($donations as $donation){
								?>
									<option value="<?php echo $donation->id ?>">(ID:<?php echo $donation->id ?>)</option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="my-3" id="bd_edit_donation_donor_id_sec">
						<label class="form-label fs-5 w-100" for="bd_edit_donation_donor_id">Donor</label>
						<select id="bd_edit_donation_donor_id" name="bd_edit_donation_donor_id" class="form-select" style="width: 100%;" required>
							<option value="" selected disabled></option>
							<?php
							$users = get_users( array( 'fields' => array( 'ID' ) ) );
							foreach($users as $user){
								$is_donor = get_user_meta( $user->id, 'is_donor', true );
								if ( $is_donor != false ) {
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
					<div>
						<label class="form-label fs-5" for="bd_edit_donation_amount_ml">Amount (mL)</label>
						<input type="number" class="form-control" id="bd_edit_donation_amount_ml" name="bd_edit_donation_amount_ml" placeholder="200 ml" maxlength="45" required>
					</div>
					<div class="my-3">
						<label class="form-label fs-5" for="bd_edit_donation_time">Time</label>
						<input type="datetime-local" class="form-control" id="bd_edit_donation_time" name="bd_edit_donation_time" required>
					</div>
					<div>
						<label class="form-label fs-5" for="bd_edit_donation_status">Status</label>
						<select id="bd_edit_donation_status" name="bd_edit_donation_status" class="form-control" required>
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
						$nonce = wp_create_nonce("bd_edit_donation_nonce");
						echo '<input class="btn btn-success" data-nonce="' . $nonce . '" name="bd_edit_donation_submit" 
						id="bd_edit_donation_submit" onclick="bd_edit_donation_submit_from(this)" data-id=""
						type="submit" value="Confirm Edit">';
					?>
				</div>
			</form>
		</div>
	</div>
</div>