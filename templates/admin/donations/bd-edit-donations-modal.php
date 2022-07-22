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