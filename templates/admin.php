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
			<ul class="responsive-table">
				<li class="table-header">
					<div class="col col-1">Id</div>
					<div class="col col-2">First Name</div>
					<div class="col col-3">Last Name</div>
					<div class="col col-4">Blood Group</div>
					<div class="col col-5">Phone Number</div>
					<div class="col col-6">Email</div>
					<div class="col col-7">Address</div>
				</li>
				<?php 
					global $wpdb;

					$tablename_donors = $wpdb->prefix . 'donors'; 
					$query = "SELECT * FROM $tablename_donors";

					$result = $wpdb->get_results( $query );
					foreach ( $result as $data ) {
						?>
						<li class="table-row">
							<div class="col col-1" data-label="Id"><?php echo $data->id ?></div>
							<div class="col col-2" data-label="First Name"><?php echo $data->first_name ?></div>
							<div class="col col-3" data-label="Last Name"><?php echo $data->last_name ?></div>
							<div class="col col-4" data-label="Blood Group"><?php echo $data->blood_group ?></div>
							<div class="col col-5" data-label="Phone Number"><?php echo $data->phone_number ?></div>
							<div class="col col-6" data-label="Email"><?php echo $data->email ?></div>
							<div class="col col-7" data-label="Address"><?php echo $data->address ?></div>
						</li>
						<?php
					}
				?>
			</ul>
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
			<h3>Donations Database</h3>
			<?php echo do_shortcode( '[donations-table]' ); ?>
			<div style="display: inline-flex;">
				<div>
					<h2>Add donation</h2>
					<?php echo do_shortcode( '[add-donation]' ); ?>
				</div>
				<div>
					<h2>Update donation</h2>
					<?php echo do_shortcode( '[update-donation]' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>