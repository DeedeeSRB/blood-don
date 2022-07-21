//// LOGIN USER ////
function submit_bd_login_form(button) 
{
	if ( !document.forms['bd_login_form'].reportValidity() ) return;

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "bd_login");
	fd.append('username',$("#bd_login_username").val());
	fd.append('password',$("#bd_login_password").val());

	js_submit(fd, submit_bd_login_callback);

}

function submit_bd_login_callback(data) {
	
	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;

	$("#bd_login_alert_box").show();
	$("#bd_login_alert_box").html('<div class="fs-5">' + mess + '</div>');
	$("#bd_login_alert_box").delay(3000).fadeOut(500, function() { $(this).hide(); });

	if (success == 1 ) {
		window.location.replace('http://localhost/wordpress');
	}
}

//// REGISTER USER ////
function submit_bd_register_form(button) 
{
	if ( !document.forms['bd_register_form'].reportValidity() ) return;
	
	phone_number = $("#bd_register_phone_number").val();
	var rx = new RegExp(/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/);
	var phone_verified = phone_number.length == 0 || ( phone_number.length > 9 && phone_number.match(rx) ) ;
	
	if ( !phone_verified ) {
		$("#bd_register_alert_box").show();
		$("#bd_register_alert_box").html('<div class="fs-5">Please enter a valid phone number!</div>');
		$("#bd_register_alert_box").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	} 

	password = $("#bd_register_password").val();
	if ( password !== $("#bd_register_password_confirm").val() ) {
		$("#bd_register_alert_box").show();
		$("#bd_register_alert_box").html('<div class="fs-5">Passwords don\'t match!</div>');
		$("#bd_register_alert_box").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	} 

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "bd_register");
	fd.append('username',$("#bd_register_username").val());
	fd.append('first_name',$("#bd_register_first_name").val());
	fd.append('last_name',$("#bd_register_last_name").val());
	fd.append('phone_number',phone_number);
	fd.append('email',$("#bd_register_email").val());
	fd.append('address',$("#bd_register_address").val());
	fd.append('password',password);

	js_submit(fd, submit_bd_register_callback);
}

function submit_bd_register_callback(data) 
{
	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;

	$("#bd_register_alert_box").show();
	$("#bd_register_alert_box").html('<div class="fs-5">' + mess + '</div>');
	$("#bd_register_alert_box").delay(3000).fadeOut(500, function() { $(this).hide(); });

	if (success == 1 ) {
		window.location.replace('http://localhost/wordpress');
	}
}

//// BECOME A DONOR ////
function submit_bd_be_donor(button) {
	if ( !document.forms['bd_be_donor_form'].reportValidity() ) return;

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "bd_be_donor");
	fd.append('blood_group',$("#bd_be_donor_bg").val());

	js_submit(fd, submit_bd_be_donor_callback);
}

function submit_bd_be_donor_callback(data) {

	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;

	$("#bd_be_donor_alert_box").show();
	$("#bd_be_donor_alert_box").html('<div class="fs-5">' + mess + '</div>');
	$("#bd_be_donor_alert_box").delay(3000).fadeOut(500, function() { $(this).hide(); });

	if (success == 1 ) {
		location.reload();
	}

	if (success == 3 ) {
		window.location.replace('http://localhost/wordpress/login');
	}
}

//// STOP BEING A DONOR ////

function bd_cancel_donor(button) {

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "bd_cancel_donor");
	fd.append('donor_to_cancel', button.value);

	js_submit(fd, submit_bd_cancel_donor_callback);
}

function submit_bd_cancel_donor_callback(data) {

	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;

	$("#bd_cancel_donor_alert_box").show();
	$("#bd_cancel_donor_alert_box").html('<div class="fs-5">' + mess + '</div>');
	$("#bd_cancel_donor_alert_box").delay(3000).fadeOut(500, function() { $(this).hide(); });

	if (success == 1 ) {
		location.reload();
	}

	if (success == 3 ) {
		window.location.replace('http://localhost/wordpress/login');
	}
}

//// CREATE TBA DONATION ////
function submit_bd_tba_donation_submit_form(button) {
	if ( !document.forms['bd_tba_donation_form'].reportValidity() ) return;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "bd_add_tba_donation");
	fd.append('amount_ml',$("#bd_tba_donation_amount_ml").val());
	fd.append('time',$("#bd_tba_donation_time").val());

	js_submit(fd, submit_bd_add_tba_donation_callback);
}

function submit_bd_add_tba_donation_callback(data) {
	
	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;

	$("#bd_home_page_alert_box").show();
	$("#bd_home_page_alert_box").html('<div class="fs-6">' + mess + '</div>');
	$("#bd_home_page_alert_box").delay(3000).fadeOut(500, function() { $(this).hide(); });

	if (success == 1 ) {
		$("#bd_tba_donations_table").load(location.href + " #bd_tba_donations_table");
		//location.reload();
	}

	if (success == 3 ) {
		window.location.replace('http://localhost/wordpress/login');
	}
}

//// DELETE TBA DONATION ////
function bd_delete_tba_donation_submit(button) {

	idToDelete = button.value;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "bd_delete_tba_donation");
	fd.append('id_to_delete', idToDelete);
	js_submit(fd, bd_delete_tba_donation_callback);
}

function bd_delete_tba_donation_callback(data) {

	var jdata = JSON.parse(data);

	var success = jdata.success;
	var id = jdata.id;

	if ( success == 1 ) {
		$('#bd_delete_tba__donation_'+id).remove();
		$("#bd_delete_tba_donation_response_div_"+id).show();
		$("#bd_delete_tba_donation_response_div_"+id).html('<div class="fs-6">Donation deleted successfuly!</div>');
		$("#bd_delete_tba_donation_response_div_"+id).delay(2000).fadeOut(500, function() { $(this).remove(); });
	}
	else if ( success == 2 ) {
		alert(mess);
	}
}

//// ADD DONOR ////
function submit_add_donor_form(button)
{
	if ( !document.forms['add_donor_form'].reportValidity() ) {
		$("#add_donor_response_div").show();
		$("#add_donor_response_div").html('Please fill out all the required fields!');
		$("#add_donor_response_div").css("background-color", "#f56565");
		$("#add_donor_response_div").css("padding","5px 15px");
		$("#add_donor_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	}

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "add_donor");
	fd.append('first_name',$("#first_name").val());
	fd.append('last_name',$("#last_name").val());
	fd.append('blood_group',$("#blood_group").val());
	fd.append('phone_number',$("#phone_number").val());
	fd.append('email',$("#email").val());
	fd.append('address',$("#address").val());

	js_submit(fd, submit_add_donor_callback);
}

function submit_add_donor_callback(data)
{
	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;

	$("#add_donor_response_div").show();
	$("#add_donor_response_div").html(mess);
	$("#add_donor_response_div").css("background-color", color);
	$("#add_donor_response_div").css("padding","5px 15px");
	$("#add_donor_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });

	if ( success == 1 && $("#donors-table").length ) {
		$("#donors-table").load(location.href + " #donors-table");
		//location.reload();
	}
}


//// ADD DONATION ////
function submit_add_donation_form(button)
{
	if ( !document.forms['add_donation_form'].reportValidity() ) {
		$("#add_donation_response_div").show();
		$("#add_donation_response_div").html('Please fill out all the required fields!');
		$("#add_donation_response_div").css("background-color", "#f56565");
		$("#add_donation_response_div").css("padding","5px 15px");
		$("#add_donation_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	}

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "add_donation");
	fd.append('donor_id',$("#donor_id").val());
	fd.append('amount_ml',$("#amount_ml").val());
	fd.append('time',$("#time").val());
	fd.append('status',$("#status").val());

	js_submit(fd, submit_add_donation_callback);
}

function submit_add_donation_callback(data)
{
	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;

	$("#add_donation_response_div").show();
	$("#add_donation_response_div").html(mess);
	$("#add_donation_response_div").css("background-color", color);
	$("#add_donation_response_div").css("padding","5px 15px");
	$("#add_donation_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });

	if ( success == 1 && $("#donations-table").length ) {
		$("#donations-table").load(location.href + " #donations-table");
		//location.reload();
	}
}


//// GET DONOR ////
function fill_donor_details() {

	var fd = new FormData();
	
	fd.append('action', "get_donor");
	fd.append('id', $("#ud_id").val());

	js_submit(fd, fill_donor_details_callback);
}

function fill_donor_details_callback(data) {

	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;

	if (success == 2) {
		cantFindDonor(mess);
	}

	if (success == 1) {
		$("#ud_first_name").val(jdata.first_name);
		$("#ud_last_name").val(jdata.last_name);
		$("#ud_blood_group").val(jdata.blood_group);
		$("#ud_phone_number").val(jdata.phone_number);
		$("#ud_email").val(jdata.email);
		$("#ud_address").val(jdata.address);
	}
}


//// GET DONATION ////
function fill_donation_details() {
	
	var fd = new FormData();
	
	fd.append('action', "get_donation");
	fd.append('id', $("#donation_id").val());

	js_submit(fd, fill_donation_details_callback);
}

function fill_donation_details_callback(data) {

	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;

	if (success == 2) {
		$("#update_donation_response_div").show();
		$("#update_donation_response_div").html(mess);
		$("#update_donation_response_div").css("background-color", "#f56565");
		$("#update_donation_response_div").css("padding","5px 15px");
		$("#update_donation_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });

		$("#ud_donor_id").val("");
		$("#ud_amount_ml").val("");
		$("#ud_time").val("");
		$("#ud_status").val("");
	}

	if (success == 1) {
		$("#ud_donor_id").val(jdata.donor_id);
		$("#ud_amount_ml").val(jdata.amount_ml);
		$("#ud_time").val(jdata.time);
		$("#ud_status").val(jdata.status);
	}
}


//// UPDATE DONOR ////
function submit_update_donor_form(button) {

	if ( !document.forms['update_donor_form'].reportValidity() ) {
		$("#update_donor_response_div").show();
		$("#update_donor_response_div").html('Please fill out all the required fields!');
		$("#update_donor_response_div").css("background-color", "#f56565");
		$("#update_donor_response_div").css("padding","5px 15px");
		$("#update_donor_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	}

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "update_donor");
	fd.append('id',$("#ud_id").val());
	fd.append('first_name',$("#ud_first_name").val());
	fd.append('last_name',$("#ud_last_name").val());
	fd.append('blood_group',$("#ud_blood_group").val());
	fd.append('phone_number',$("#ud_phone_number").val());
	fd.append('email',$("#ud_email").val());
	fd.append('address',$("#ud_address").val());

	js_submit(fd, update_donor_callback);
}

function update_donor_callback(data) {
	
	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;

	$("#update_donor_response_div").show();
	$("#update_donor_response_div").html(mess);
	$("#update_donor_response_div").css("background-color", color);
	$("#update_donor_response_div").css("padding","5px 15px");
	$("#update_donor_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });
	
	if ( success == 1 && $("#donors-table").length ) {
		$("#donors-table").load(location.href + " #donors-table");
		$("#ud_id").load(location.href + " #ud_id");
		//location.reload();
	}
}


//// UPDATE DONATION ////
function submit_update_donation_form(button) {

	if ( !document.forms['update_donation_form'].reportValidity() ) {
		$("#update_donation_response_div").show();
		$("#update_donation_response_div").html('Please fill out all the required fields!');
		$("#update_donation_response_div").css("background-color", "#f56565");
		$("#update_donation_response_div").css("padding","5px 15px");
		$("#update_donation_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	}

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "update_donation");
	fd.append('id',$("#donation_id").val());
	fd.append('donor_id',$("#ud_donor_id").val());
	fd.append('amount_ml',$("#ud_amount_ml").val());
	fd.append('time',$("#ud_time").val());
	fd.append('status',$("#ud_status").val());

	js_submit(fd, update_donation_callback);
}

function update_donation_callback(data) {
	
	var jdata = JSON.parse(data);
	
	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;

	$("#update_donation_response_div").show();
	$("#update_donation_response_div").html(mess);
	$("#update_donation_response_div").css("background-color", color);
	$("#update_donation_response_div").css("padding","5px 15px");
	$("#update_donation_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });
	
	if ( success == 1 && $("#donations-table").length ) {
		$("#donations-table").load(location.href + " #donations-table");
		//location.reload();
	}
}


//// DELETE DONOR ////
function delete_donor(button) {
	
	var fd = new FormData();
	
	idToDelete = button.value;
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "delete_donor");
	fd.append('id_to_delete', idToDelete);

	js_submit(fd, delete_donor_callback);
}

function delete_donor_callback(data)
{
	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;
	var id = jdata.id;

	if ( success == 1 ) {
		$("#delete_donor_response_div_"+id).show();
		$("#delete_donor_response_div_"+id).children().css("background-color", color);
		$("#delete_donor_response_div_"+id).children().children().html(mess);
		//$('#delete_donor_'+id).hide();
		$('#delete_donor_'+id).remove();
		$("#delete_donor_response_div_"+id).delay(2000).fadeOut(500, function() { $(this).remove(); });
	}
	else if ( success == 2 ) {
		alert(mess);
	}
}


//// DELETE DONATION ////
function delete_donation(button) {
	
	idToDelete = button.value;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', nonce);
	fd.append('action', "delete_donation");
	fd.append('id_to_delete', idToDelete);
	js_submit(fd, delete_donation_callback);
}

function delete_donation_callback(data)
{
	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;
	var id = jdata.id;

	if ( success == 1 ) {
		$("#delete_donation_response_div_"+id).show();
		$("#delete_donation_response_div_"+id).children().css("background-color", color);
		$("#delete_donation_response_div_"+id).children().children().html(mess);
		$('#delete_donation_'+id).remove();
		$("#delete_donation_response_div_"+id).delay(2000).fadeOut(500, function() { $(this).remove(); });
	}
	else if ( success == 2 ) {
		alert(mess);
	}
}

function cantFindDonor(mess) {
	$("#update_donor_response_div").show();
	$("#update_donor_response_div").html(mess);
	$("#update_donor_response_div").css("background-color", "#f56565");
	$("#update_donor_response_div").css("padding","5px 15px");
	$("#update_donor_response_div").delay(3000).fadeOut(500, function() { $(this).hide(); });

	$("#ud_first_name").val("");
	$("#ud_last_name").val("");
	$("#ud_blood_group").val("");
	$("#ud_phone_number").val("");
	$("#ud_email").val("");
	$("#ud_address").val("");
}

function js_submit(data, callback)
{
	$.ajax({
		url: admin_url_object.ajaxurl,
		method:'post',
		data:data,
		contentType:false,
		processData:false,
		success: function ( response ) { callback( response ); },
	});
}

window.addEventListener("load", function() {

	var tabs = document.querySelectorAll("ul.nav-tabs > li");
	
	for (let i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}

	function switchTab(event) {
		event.preventDefault();

		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");

		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");

		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");

	}

	

	if ($("#ud_id").length) {
		$("#ud_id").change(function() {
			if ($("#ud_id").val() != "") {
				fill_donor_details();
			}
		});
	}

	
	$('#ud_id').select2({
		placeholder: 'Select an option'
	});
	
	
	if ($("#donation_id").length) {
		$("#donation_id").change(function() {
			if ($("#donation_id").val() != "") {
				fill_donation_details();
			}
		});
	}

	$('#donation_id').select2({
		placeholder: 'Select an option'
	});

	
});