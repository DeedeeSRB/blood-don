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