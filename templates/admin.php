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