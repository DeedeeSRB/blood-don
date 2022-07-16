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
				<li class="table-row">
					<div class="col col-1" data-label="Id">1</div>
					<div class="col col-2" data-label="First Name">Sadik</div>
					<div class="col col-3" data-label="Last Name">Besata</div>
					<div class="col col-4" data-label="Blood Group">A+</div>
					<div class="col col-5" data-label="Phone Number">+90 535 735 03 41</div>
					<div class="col col-6" data-label="Email">sadik.bsata89@gmail.com</div>
					<div class="col col-7" data-label="Address">somewhere in tuekey in kayseri next to agu within student dorms</div>
				</li>
			</ul>
            <form method="post" action="<?php menu_page_url( 'blood_donation_plugin' ) ?>">
                <?php 
                    settings_fields( 'blood_don_options_group' );
                    do_settings_sections( 'blood_donation_plugin' );
                    submit_button( 'Add Donor' );
                ?>
            </form>
			
		</div>

		<div id="tab-2" class="tab-pane">
			<h3>Donations Database</h3>
		</div>
	</div>
</div>