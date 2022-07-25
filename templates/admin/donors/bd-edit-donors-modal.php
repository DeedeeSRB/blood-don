<div class="modal fade" id="editDonorModal" aria-labelledby="editDonorModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editDonorModalLabel">Edit donor</h5>
				<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form name="bd_edit_donor_form" id="bd_edit_donor_form" onsubmit="return false">
					<div id="bd_edit_donor_id_sec">
						<label class="form-label fs-5 w-100" for="bd_edit_donor_id">Donor</label>
						<select id="bd_edit_donor_id" name="bd_edit_donor_id" class="form-select" style="width: 100%;">
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
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label fs-5" for="bd_edit_donor_first_name">First Name</label>
                            <input class="form-control" type="text" name="bd_edit_donor_first_name" id="bd_edit_donor_first_name" required>
                        </div>
                        <div class="col">
                            <label class="form-label fs-5" for="bd_edit_donor_last_name">Last Name</label>
                            <input class="form-control" type="text" name="bd_edit_donor_last_name" id="bd_edit_donor_last_name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label fs-5" for="bd_edit_donor_email">Email</label>
                            <input class="form-control" type="email" name="bd_edit_donor_email" id="bd_edit_donor_email" required>
                        </div>
                        <div class="col">
                            <label class="form-label fs-5" for="bd_edit_donor_phone_number">Phone Number</label>
                            <input class="form-control" type="tel" name="bd_edit_donor_phone_number" id="bd_edit_donor_phone_number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label fs-5" for="bd_edit_donor_blood_group">Blood Group</label>
                            <select id="bd_edit_donor_blood_group" style="width: 100%; display: inline;"
                                    name="bd_edit_donor_blood_group" class="form-control" required>
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
                        <div class="col">
                            <label class="form-label fs-5" for="bd_edit_donor_address">Address</label>
                            <textarea class="form-control" rows=1 name="bd_edit_donor_address" id="bd_edit_donor_address"></textarea>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<?php 
						$nonce = wp_create_nonce("bd_edit_donor_nonce");
						echo '<input class="btn btn-success" data-nonce="' . $nonce . '" name="bd_edit_donor_submit" 
						id="bd_edit_donor_submit" onclick="bd_edit_donor_submit_from(this)" data-id=""
						type="submit" value="Confirm Edit">';
					?>
				</div>
			</form>
		</div>
	</div>
</div>