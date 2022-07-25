<div class="wrap">
	<h1>Sadik's Plugin</h1>
	<?php settings_errors(); ?>

	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<button class="nav-link active" id="nav-donors-tab" data-bs-toggle="tab" data-bs-target="#nav-donors" type="button" role="tab" aria-controls="nav-donors" aria-selected="true">Donors</button>
			<button class="nav-link" id="nav-donations-tab" data-bs-toggle="tab" data-bs-target="#nav-donations" type="button" role="tab" aria-controls="nav-donations" aria-selected="false">Donations</button>
		</div>
	</nav>

<!---------------------------------------- DONORS PAGE  -------------------------------------------------->
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active" id="nav-donors" role="tabpanel" aria-labelledby="nav-donors-tab" tabindex="0">
			<?php $nonce_del_donor = wp_create_nonce("bd_delete_donor_nonce"); ?>
			<div name="bd_admin_donor_danger_div" id="bd_admin_donor_danger_div" class="alert alert-danger alert-dismissible collapse"></div>
			<div name="bd_admin_donor_success_div" id="bd_admin_donor_success_div" class="alert alert-success alert-dismissible collapse"></div>
			<div class="row my-3">
				<div class="col"><h3>Current Donors</h3></div>
				<div class="col-auto">
					<button type="button" class="col-auto btn btn-success px-2 mx-3" data-bs-toggle="modal" data-bs-target="#addDonorModal">Add new donor</button>
					<button type="button" class="col-auto btn btn-warning px-2" data-bs-toggle="modal" data-preset=false 
					data-bs-target="#editDonorModal" onclick="bd_set_edit_donor_form(this)">Edit donor</button>
				</div>
			</div>
			<!-------------------------------------- DONORS TABLE -------------------------------------->
			<?php include BD_PLUGIN_PATH . 'templates\admin\donors\bd-donors-table.php'; ?>

			<!-------------------------------------- EDIT DONORS MODAL -------------------------------------->
			<?php include BD_PLUGIN_PATH . 'templates\admin\donors\bd-edit-donors-modal.php'; ?>

			<!-------------------------------------- CREATE DONORS MODAL -------------------------------------->
			<?php include BD_PLUGIN_PATH . 'templates\admin\donors\bd-create-donors-modal.php'; ?>

		</div>

<!---------------------------------------- DONATIONS PAGE  -------------------------------------------------->
		<div class="tab-pane fade" id="nav-donations" role="tabpanel" aria-labelledby="nav-donations-tab" tabindex="0">
			<?php $nonce_del_donation = wp_create_nonce("bd_delete_donation_nonce"); ?>
			<div name="bd_admin_donation_danger_div" id="bd_admin_donation_danger_div" class="alert alert-danger alert-dismissible collapse"></div>
			<div name="bd_admin_donation_success_div" id="bd_admin_donation_success_div" class="alert alert-success alert-dismissible collapse"></div>
			<div class="row my-3">
				<div class="col"><h3>To Be Accepted Donations</h3></div>
				<div class="col-auto">
					<button type="button" class="col-auto btn btn-success px-2 mx-3" data-bs-toggle="modal" data-bs-target="#createDonationModal">Create new donation</button>
					<button type="button" class="col-auto btn btn-warning px-2" data-bs-toggle="modal" data-preset=false 
					data-bs-target="#editDonationModal" onclick="bd_set_edit_donation_form(this)">Edit donation</button>
				</div>
			</div>
			<!-------------------------------------- TO BE ACCEPTED DONATIONS TABLE -------------------------------------->
			<?php include BD_PLUGIN_PATH . 'templates\admin\donations\bd-to-be-accepted-donations-table.php'; ?>

			<h3>Accepted Donations</h3>
			<!-------------------------------------- ACCEPTED DONATIONS TABLE -------------------------------------->
			<?php include BD_PLUGIN_PATH . 'templates\admin\donations\bd-accepted-donations-table.php'; ?>

			<!-------------------------------------- EDIT DONATIONS MODAL -------------------------------------->
			<?php include BD_PLUGIN_PATH . 'templates\admin\donations\bd-edit-donations-modal.php'; ?>

			<!-------------------------------------- CREATE DONATIONS MODAL -------------------------------------->
			<?php include BD_PLUGIN_PATH . 'templates\admin\donations\bd-create-donations-modal.php'; ?>
			
		</div>
	
	</div>
</div>