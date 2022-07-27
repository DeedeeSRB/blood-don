//// LOGIN USER ////
function submit_bd_login_form(button) 
{
	if ( !document.forms['bd_login_form'].reportValidity() ) return;

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', 		nonce);
	fd.append('action', 	"bd_login");
	fd.append('username',	$("#bd_login_username").val());
	fd.append('password',	$("#bd_login_password").val());

	js_submit(fd, submit_bd_login_callback, "#bd_login_success_box", "#bd_login_danger_box");
}

function submit_bd_login_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	if (success == 1 ) window.location.replace('http://localhost/wordpress');
}


//// REGISTER USER ////
function submit_bd_register_form(button) 
{
	if ( !document.forms['bd_register_form'].reportValidity() ) return;
	
	phone_number = $("#bd_register_phone_number").val();
	var rx = new RegExp(/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/);
	var phone_verified = phone_number.length == 0 || ( phone_number.length > 9 && phone_number.match(rx) ) ;
	
	if ( !phone_verified ) {
		$("#bd_register_danger_box").show();
		$("#bd_register_danger_box").html('<div class="fs-5">Please enter a valid phone number!</div>');
		$("#bd_register_danger_box").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	} 

	password = $("#bd_register_password").val();
	if ( password !== $("#bd_register_password_confirm").val() ) {
		$("#bd_register_danger_box").show();
		$("#bd_register_danger_box").html('<div class="fs-5">Passwords don\'t match!</div>');
		$("#bd_register_danger_box").delay(3000).fadeOut(500, function() { $(this).hide(); });
		return;
	} 

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', 			nonce);
	fd.append('action', 		"bd_register");
	fd.append('username',		$("#bd_register_username").val());
	fd.append('first_name',		$("#bd_register_first_name").val());
	fd.append('last_name',		$("#bd_register_last_name").val());
	fd.append('phone_number',	phone_number);
	fd.append('email',			$("#bd_register_email").val());
	fd.append('address',		$("#bd_register_address").val());
	fd.append('password',		password);

	js_submit(fd, submit_bd_register_callback, "#bd_register_success_box", "#bd_register_danger_box");
}

function submit_bd_register_callback(data) 
{
	var jdata = JSON.parse(data);
	var success = jdata.success;
	if (success == 1 ) window.location.replace('http://localhost/wordpress');
}

//// BECOME A DONOR ////
function submit_bd_be_donor(button) {
	if ( $("#bd_be_donor_form").length ) if ( !document.forms['bd_be_donor_form'].reportValidity() ) return;
	if ( $("#bd_create_donor_form").length ) if ( !document.forms['bd_create_donor_form'].reportValidity() ) return;
	

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	id = -1;

	if ( $("#bd_create_donor_user_id").length ) id = $("#bd_create_donor_user_id").val();

	fd.append('nonce', 			nonce);
	fd.append('action', 		"bd_be_donor");
	fd.append('id', 			id);
	fd.append('blood_group',	$("#bd_be_donor_bg").val());

	js_submit(fd, submit_bd_be_donor_callback, "#bd_admin_donor_success_div", "#bd_admin_donor_danger_div");
}

function submit_bd_be_donor_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	var mess = jdata.message;
	if ( success == 1 && $("#bd_donors_table").length ) $("#bd_donors_table").load(location.href + " #bd_donors_table");
	else if ( success == 1 ) location.reload();
	else if ( success == 2 ) alert(mess);
}

//// STOP BEING A DONOR ////
function bd_cancel_donor(button) {

	var fd = new FormData();

	nonce = $(button).attr("data-nonce");
	fd.append('nonce', 				nonce);
	fd.append('action', 			"bd_cancel_donor");
	fd.append('donor_to_cancel', 	button.value);

	js_submit(fd, submit_bd_cancel_donor_callback, "#bd_delete_donor_response_div_"+button.value, "#bd_cancel_donor_alert_box");
}

function submit_bd_cancel_donor_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	var mess = jdata.message;
	var id = jdata.id;
	if ( success == 1 && $("#bd_donors_table").length ) $("#bd_remove_donor_"+id).remove();
	else if ( success == 1 ) location.reload();
	else if ( success == 2 ) alert(mess);
}

//// CREATE TBA DONATION ////
function submit_bd_tba_donation_submit_form(button) {

	if ( !document.forms['bd_tba_donation_form'].reportValidity() ) return;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', 		nonce);
	fd.append('action', 	"bd_add_tba_donation");
	fd.append('amount_ml',	$("#bd_tba_donation_amount_ml").val());
	fd.append('time',		$("#bd_tba_donation_time").val());

	js_submit(fd, submit_bd_add_tba_donation_callback, "#bd_home_page_success_box" , "#bd_home_page_alert_box");
}

function submit_bd_add_tba_donation_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	if ( success == 1 ) $("#bd_tba_donations_table").load(location.href + " #bd_tba_donations_table");
}

//// DELETE DONATION ////
function bd_delete_donation_submit(button) {

	idToDelete = button.value;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', 			nonce);
	fd.append('action', 		"bd_delete_donation");
	fd.append('id_to_delete', 	idToDelete);

	js_submit(fd, bd_delete_donation_callback, "#bd_delete_donation_response_div_"+idToDelete, "");
}

function bd_delete_donation_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	var mess = jdata.message;
	var id = jdata.id;

	if ( success == 1 ) $('#bd_delete_donation_'+id).remove();
	if ( success == 2 ) alert(mess);
}


//// APPROVE TBA DONATION ////
function bd_approve_tba_donation_submit(button) {

	idToApprove = button.value;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	fd.append('nonce', 			nonce);
	fd.append('action', 		"bd_approve_tba_donation");
	fd.append('id_to_approve', 	idToApprove);

	js_submit(fd, bd_approve_tba_donation_callback, "#bd_delete_donation_response_div_"+idToApprove, "#bd_admin_donation_danger_div");
}

function bd_approve_tba_donation_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	var id = jdata.id;

	if ( success == 1 ) {
		$("#bd_approved_donations_table").load(location.href + " #bd_approved_donations_table");
		$('#bd_delete_donation_'+id).remove();
	}
}


//// SET DONATION FORM ////
function bd_set_edit_donation_form(button) {

	if ( $(button).attr("data-preset") == "true" ) {
		bd_donation_id = $(button).attr("data-id");
		bd_amount = $(button).attr("data-amount");
		bd_time = $(button).attr("data-time");
		bd_status = $(button).attr("data-status");

		$("#bd_edit_donation_submit").attr("data-id", bd_donation_id);
		$("#bd_edit_donation_amount_ml").val(bd_amount);
		$("#bd_edit_donation_time").val(bd_time);
		$("#bd_edit_donation_status").val(bd_status); 

		$("#bd_edit_donation_id_sec").hide();
		$("#bd_edit_donation_donor_id_sec").hide();

		$("#bd_edit_donation_id").attr("required", false); 
		$("#bd_edit_donation_donor_id").attr("required", false); 
		return;
	}
	
	$("#bd_edit_donation_submit").attr("data-id", -1);
	$("#bd_edit_donation_id").val(null).trigger('change');
	$("#bd_edit_donation_donor_id").val(null).trigger('change');
	$("#bd_edit_donation_amount_ml").val(null);
	$("#bd_edit_donation_time").val(null);
	$("#bd_edit_donation_status").val(null); 

	$("#bd_edit_donation_id_sec").show();
	$("#bd_edit_donation_donor_id_sec").show();

	$("#bd_edit_donation_id").attr("required", true); 
	$("#bd_edit_donation_donor_id").attr("required", true); 
	
}


//// EDIT DONATION SUBMIT ////
function bd_edit_donation_submit_from(button) {

	if ( !document.forms['bd_edit_donation_form'].reportValidity() ) return;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	id_to_edit = $(button).attr("data-id");
	donor_id = -1;
	
	if ( id_to_edit == -1 ) {
		id_to_edit = $("#bd_edit_donation_id").val();
		donor_id = $("#bd_edit_donation_donor_id").val();
	}

	fd.append('nonce', 		nonce);
	fd.append('action', 	"bd_edit_donation");
	fd.append('id',			id_to_edit);
	fd.append('donor_id',	donor_id);
	fd.append('amount_ml',	$("#bd_edit_donation_amount_ml").val());
	fd.append('time',		$("#bd_edit_donation_time").val());
	fd.append('status',		$("#bd_edit_donation_status").val());

	js_submit(fd, submit_bd_edit_donation_callback, "#bd_admin_donation_success_div", "#bd_admin_donation_danger_div");
}

function submit_bd_edit_donation_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	if ( success == 1 ) {
		$("#bd_approved_donations_table").load(location.href + " #bd_approved_donations_table");
		$("#bd_to_be_accepted_donations_table").load(location.href + " #bd_to_be_accepted_donations_table");
	}
}

//// CREATE DONATION ////
function bd_create_donation_submit_from(button) {

	if ( !document.forms['bd_create_donation_form'].reportValidity() ) return;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");

	fd.append('nonce', 		nonce);
	fd.append('action', 	"bd_create_donation");
	fd.append('donor_id',	$("#bd_create_donation_donor_id").val());
	fd.append('amount_ml',	$("#bd_create_donation_amount_ml").val());
	fd.append('time',		$("#bd_create_donation_time").val());
	fd.append('status',		$("#bd_create_donation_status").val());

	js_submit(fd, submit_bd_create_donation_callback, "#bd_admin_donation_success_div", "#bd_admin_donation_danger_div");
}

function submit_bd_create_donation_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	if (success == 1) {
		$("#bd_approved_donations_table").load(location.href + " #bd_approved_donations_table");
		$("#bd_to_be_accepted_donations_table").load(location.href + " #bd_to_be_accepted_donations_table");
	}
}


//// GET DONATION ////
function get_donation(id) {
	var fd = new FormData();

	fd.append('action', "bd_get_donation");
	fd.append('id',		id);

	js_submit(fd, get_donation_callback, "", "");
}

function get_donation_callback(data) {

	var jdata = JSON.parse(data);

	var success = jdata.success;

	var donor_id = jdata.donor_id;
	var amount_ml = jdata.amount_ml;
	var time = jdata.time;
	var status = jdata.status;
	
	if (success == 1) {
		$("#bd_edit_donation_donor_id").val(donor_id).trigger('change');;
		$("#bd_edit_donation_amount_ml").val(amount_ml);
		$("#bd_edit_donation_time").val(time);
		$("#bd_edit_donation_status").val(status); 
	}
}


//// SET DONOR FORM ////
function bd_set_edit_donor_form(button) {

	if ( $(button).attr("data-preset") == "true" ) {
		donor_id = $(button).attr("data-id");
		first_name = $(button).attr("data-fn");
		last_name = $(button).attr("data-ln");
		email = $(button).attr("data-email");
		phone_number = $(button).attr("data-pn");
		blood_group = $(button).attr("data-bg");
		address = $(button).attr("data-address");

		$("#bd_edit_donor_submit").attr("data-id", donor_id);
		$("#bd_edit_donor_first_name").val(first_name);
		$("#bd_edit_donor_last_name").val(last_name);
		$("#bd_edit_donor_email").val(email);
		$("#bd_edit_donor_phone_number").val(phone_number);
		$("#bd_edit_donor_blood_group").val(blood_group);
		$("#bd_edit_donor_address").val(address); 

		$("#bd_edit_donor_id_sec").hide();
		$("#bd_edit_donor_id").attr("required", false); 
		return;
	}
	
	$("#bd_edit_donor_submit").attr("data-id", -1);
	$("#bd_edit_donor_id").val(null).trigger('change');
	$("#bd_edit_donor_first_name").val(null);
	$("#bd_edit_donor_last_name").val(null);
	$("#bd_edit_donor_email").val(null);
	$("#bd_edit_donor_phone_number").val(null);
	$("#bd_edit_donor_blood_group").val(null);
	$("#bd_edit_donor_address").val(null); 

	$("#bd_edit_donor_id_sec").show();
	$("#bd_edit_donor_id").attr("required", true); 
}


//// EDIT DONOR SUBMIT ////
function bd_edit_donor_submit_from(button) {

	if ( !document.forms['bd_edit_donor_form'].reportValidity() ) return;

	var fd = new FormData();
	
	nonce = $(button).attr("data-nonce");
	
	id_to_edit = $(button).attr("data-id");
	
	if ( id_to_edit == -1 ) id_to_edit = $("#bd_edit_donor_id").val();

	fd.append('nonce', 			nonce);
	fd.append('action', 		"bd_edit_donor");
	fd.append('id',				id_to_edit);
	fd.append('first_name',		$("#bd_edit_donor_first_name").val());
	fd.append('last_name',		$("#bd_edit_donor_last_name").val());
	fd.append('email',			$("#bd_edit_donor_email").val());
	fd.append('phone_number',	$("#bd_edit_donor_phone_number").val());
	fd.append('blood_group',	$("#bd_edit_donor_blood_group").val());
	fd.append('address',		$("#bd_edit_donor_address").val());

	js_submit(fd, submit_bd_edit_donor_callback, "#bd_admin_donor_success_div", "#bd_admin_donor_danger_div");
}

function submit_bd_edit_donor_callback(data) {
	var jdata = JSON.parse(data);
	var success = jdata.success;
	if (success == 1) $("#bd_donors_table").load(location.href + " #bd_donors_table");
}

//// GET DONOR ////
function get_donor(id) {
	var fd = new FormData();

	fd.append('action', "bd_get_donor");
	fd.append('id',		id);

	js_submit(fd, get_donor_callback, "", "");
}

function get_donor_callback(data) {

	var jdata = JSON.parse(data);

	var success = jdata.success;

	var first_name = jdata.first_name;
	var last_name = jdata.last_name;
	var email = jdata.email;
	var phone_number = jdata.phone_number;
	var blood_group = jdata.blood_group;
	var address = jdata.address;
	
	if (success == 1) {
		$("#bd_edit_donor_first_name").val(first_name);
		$("#bd_edit_donor_last_name").val(last_name);
		$("#bd_edit_donor_email").val(email);
		$("#bd_edit_donor_phone_number").val(phone_number);
		$("#bd_edit_donor_blood_group").val(blood_group);
		$("#bd_edit_donor_address").val(address); 
	}
}

function bd_delete_confirm(button) {
	$("#bd_delete_confirm").val(button.value);
	$("#bd_delete_confirm").attr("data-nonce", button.getAttribute("data-nonce"));
	if (button.getAttribute("data-fn") == 1) $("#bd_delete_confirm").attr("data-fn", "1");
	else if (button.getAttribute("data-fn") == 2) $("#bd_delete_confirm").attr("data-fn", "2");
}

function bd_delete_submit(button) {
	if ( button.getAttribute("data-fn") == 1 ) bd_cancel_donor(button);
	else if ( button.getAttribute("data-fn") == 2 ) bd_delete_donation_submit(button);
}

function js_submit(data, callback, suc_div, alert_div)
{
	$.ajax({
		url: admin_url_object.ajaxurl,
		method:'post',
		data:data,
		contentType:false,
		processData:false,
		success: function ( response ) { callback( response ); submit_callback( response, suc_div, alert_div ); },
	});
}

function submit_callback(data, suc_div, alert_div) {

	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;

	if ( success == 1) {
		$(suc_div).show();
		$(suc_div).html('<div class="fs-6">' + mess + '</div>');
		$(suc_div).delay(2500).fadeOut(500, function() { $(this).hide(); });
	}

	if ( success == 2) {
		//alert(mess);
		$(alert_div).show();
		$(alert_div).html('<div class="fs-6">' + mess + '</div>');
		$(alert_div).delay(2500).fadeOut(500, function() { $(this).hide(); });
	}
	
	if (success == 3 ) {
		window.location.replace('http://localhost/wordpress/login');
	}
}

window.addEventListener("load", function() {

	$('#bd_edit_donation_id').select2({
		dropdownParent: $('#editDonationModal'),
	});

	$('#bd_edit_donation_donor_id').select2({
		dropdownParent: $('#editDonationModal'),
	});

	$('#bd_create_donation_donor_id').select2({
		dropdownParent: $('#createDonationModal'),
	});

	$('#bd_edit_donor_id').select2({
		dropdownParent: $('#editDonorModal'),
	});

	$('#bd_create_donor_user_id').select2({
		dropdownParent: $('#addDonorModal'),
	});

	$('#bd_edit_donation_id').on('select2:select', function (e) {
		var donationToGet = e.params.data.id;
		get_donation(donationToGet);
	});

	$('#bd_edit_donor_id').on('select2:select', function (e) {
		var donorToGet = e.params.data.id;
		get_donor(donorToGet);
	});

});