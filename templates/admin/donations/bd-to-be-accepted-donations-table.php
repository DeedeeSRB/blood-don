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
												echo '<button class="btn btn-danger" data-nonce="' . $nonce_del_donation . '" name="bd_delete_donation" id="bd_delete_donation" value="' . $id . '" onclick="bd_delete_donation_submit(this)">X</button>';
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