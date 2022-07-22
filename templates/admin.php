<div class="wrap">
	<h1>Sadik's Plugin</h1>
	<?php settings_errors(); ?>

    <ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Donors Database</a></li>
		<li><a href="#tab-2">Donations Database</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<h3>Donors Database</h3>
			<?php echo do_shortcode( '[donors-table]' ); ?>
			<div style="display: inline-flex;">
				<div>
					<h2>Add donation</h2>
					<form method="post" action="<?php menu_page_url( 'blood_donation_plugin' ) ?>">
						<?php 
							settings_fields( 'blood_don_options_group' );
							do_settings_sections( 'blood_donation_plugin' );
							submit_button( 'Add Donor' );
						?>
					</form>
				</div>
				<div style="margin-left: 100px;">
					<h2>Update donor</h2>
					<?php echo do_shortcode( '[update-donor]' ); ?>
				</div>
			</div>
		</div>
		<div id="tab-2" class="tab-pane">
			<?php $nonce_del = wp_create_nonce("bd_delete_donation_nonce"); ?>
			<div name="bd_admin_donation_response_div" id="bd_admin_donation_response_div" class="alert alert-danger alert-dismissible collapse"></div>
			<h3>To Be Accepted Donations</h3>
			<div id="bd_to_be_accepted_donations_table">
				<ul class="responsive-table">
					<li class="table-header">
						<div class="col col-1">ID</div>
						<div class="col">Donor</div>
						<div class="col">Amount (mL)</div>
						<div class="col">Time</div>
						<div class="col">Status</div>
						<div class="col col-3">Manage</div>
					</li>
					<?php 
						global $wpdb;

						$tablename_donations = $wpdb->prefix . 'donations'; 
						$query = "
						SELECT * 
						FROM $tablename_donations
						WHERE status = 'To Be Accepted';";

						$result = $wpdb->get_results( $query );
						if ( count($result) == 0 ) {
							?>
							<li class="table-row">
								<div class="col">There are no donations yet.</div>
							</li>
							<?php
						}
						foreach ( $result as $data ) {
							$user = get_user_by( 'id', $data->donor_id );
							?>
							<div name="bd_delete_donation_response_div_<?php echo $data->id ?>" 
								id="bd_delete_donation_response_div_<?php echo $data->id ?>"
								class="alert alert-success alert-dismissible collapse"></div>
							<li class="table-row" id="bd_delete_donation_<?php echo $data->id ?>">
								<div class="col col-1" data-label="ID"><?php echo $data->id ?></div>
								<div class="col" data-label="Donor">
									<?php echo $user->first_name ?> <?php echo $user->last_name ?> (ID:<?php echo $data->donor_id ?>)
								</div>
								<div class="col" data-label="Amount (mL)"><?php echo $data->amount_ml ?></div>
								<div class="col" data-label="Time"><?php echo $data->time ?></div>
								<div class="col" data-label="Status"><?php echo $data->status ?></div>
								<div class="col col-3" data-label="Manage">
									<div class="row justify-content-center">
										<div class="col-auto">
											<?php 
												$nonce = wp_create_nonce("bd_approve_tba_donation_nonce");
												$id = $data->id;
												echo '<button class="btn btn-success" data-nonce="' . $nonce . '" name="bd_approve_tba_donation" id="bd_approve_tba_donation" value="' . $id . '" onclick="bd_approve_tba_donation_submit(this)">✓</button>';
											?>
										</div>
										<div class="col-auto">
											<?php 
												$id = $data->id;
												echo '<button class="btn btn-danger" data-nonce="' . $nonce_del . '" name="bd_delete_donation" id="bd_delete_donation" value="' . $id . '" onclick="bd_delete_donation_submit(this)">X</button>';
											?>
										</div>
										
									</div>
								</div>
							</li>
							<?php
						}
					?>
				</ul>
			</div>
			<h3>Accepted Donations</h3>
			<div id="bd_approved_donations_table">
				<ul class="responsive-table">
					<li class="table-header">
						<div class="col col-1">ID</div>
						<div class="col">Donor</div>
						<div class="col">Amount (mL)</div>
						<div class="col">Time</div>
						<div class="col">Status</div>
						<div class="col col-3">Manage</div>
					</li>
					<?php 
						global $wpdb;

						$tablename_donations = $wpdb->prefix . 'donations'; 
						$query = "
						SELECT * 
						FROM $tablename_donations
						WHERE status <> 'To Be Accepted';";

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
								<div class="col col-1" data-label="ID"><?php echo $data->id ?></div>
								<div class="col" data-label="Donor">
									<?php echo $user->first_name ?> <?php echo $user->last_name ?> (ID:<?php echo $data->donor_id ?>)
								</div>
								<div class="col" data-label="Amount (mL)"><?php echo $data->amount_ml ?></div>
								<div class="col" data-label="Time"><?php echo $data->time ?></div>
								<div class="col" data-label="Status"><?php echo $data->status ?></div>
								<div class="col col-3" data-label="Manage">
									<div class="row justify-content-center">
										<div class="col-auto">
											<button class="btn btn-warning" data-bs-toggle="modal" data-status="<?php echo $data->status ?>"
											data-amount="<?php echo $data->amount_ml ?>" data-time="<?php echo $data->time ?>"
											data-id="<?php echo $data->id ?>"
											data-bs-target="#editDonationModal" onclick="bd_set_edit_donation_form(this)">
											<i class="fas fa-pen text-light"></i></button>
										</div>
										<div class="col-auto">
											<?php 
												$id = $data->id;
												echo '<button class="btn btn-danger" data-nonce="' . $nonce_del . '" name="bd_delete_donation" id="bd_delete_donation" value="' . $id . '" onclick="bd_delete_donation_submit(this)">X</button>';
											?>
										</div>
										
									</div>
								</div>
							</li>
							<?php
						}
					?>
				</ul>
			</div>

			<div class="modal fade" id="editDonationModal" tabindex="-1" aria-labelledby="editDonationModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="editDonationModalLabel">Edit Donation</h5>
							<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form name="bd_edit_donation_form" id="bd_edit_donation_form" onsubmit="return false">
								<div>
									<label class="form-label fs-5" for="bd_edit_donation_amount_ml">Amount (mL): </label>
									<input type="text" class="form-control" id="bd_edit_donation_amount_ml" name="bd_edit_donation_amount_ml" placeholder="200 ml" maxlength="45" required>
								</div>
								<div class="my-3">
									<label class="form-label fs-5" for="bd_edit_donation_time">Time: </label>
									<input type="datetime-local" class="form-control" id="bd_edit_donation_time" name="bd_edit_donation_time" required>
								</div>
								<div>
									<label class="form-label fs-5" for="bd_edit_donation_status">Status: </label>
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
		</div>
	</div>
</div>