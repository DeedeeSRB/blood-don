
function submit_contact_form()
{
	if ( !document.forms['add_donor_form'].reportValidity() ) {
		$("#add_donor_response_div").show();
		$("#add_donor_response_div").html('Please fill out all the required fields!');
		$("#add_donor_response_div").css("background-color", "#f56565");
		$("#add_donor_response_div").css("padding","20px");
		$("#add_donor_response_div").delay(2000).fadeOut(500, function() { $(this).hide(); });
		return;
	}

	var submitUrl = "http://localhost/wordpress/wp-content/plugins/blood-don/templates/process/add-donor-process.php";
	var fd = new FormData();
	
	fd.append('donorFormSubmit','1');
	fd.append('first_name',$("#first_name").val());
	fd.append('last_name',$("#last_name").val());
	fd.append('blood_group',$("#blood_group").val());
	fd.append('phone_number',$("#phone_number").val());
	fd.append('email',$("#email").val());
	fd.append('address',$("#address").val());

	js_submit(fd, submit_contact_form_callback, submitUrl);
}

function submit_contact_form_callback(data)
{
	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;

	$("#add_donor_response_div").show();
	$("#add_donor_response_div").html(mess);
	$("#add_donor_response_div").css("background-color", color);
	$("#add_donor_response_div").css("padding","20px");
	$("#add_donor_response_div").delay(2000).fadeOut(500, function() { $(this).hide(); });

	if ( success == 1 && $("#donors-table").length ) {
		$("#donors-table").load(location.href + " #donors-table");
		//location.reload();
	}
}

function delete_donor(button) {
	
	idToDelete = button.value;

	var submitUrl = "http://localhost/wordpress/wp-content/plugins/blood-don/templates/process/delete-donor-process.php";
	var fd = new FormData();
	
	fd.append('deleteDonorSubmit','1');
	fd.append('id_to_delete', idToDelete);
	js_submit(fd, delete_donor_callback, submitUrl);
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

function js_submit( fd, callback, submitUrl )
{
	$.ajax( {
		url: submitUrl,
		type:'post',
		data:fd,
		contentType:false,
		processData:false,
		success: function ( response ) { callback( response ); },
	});
}

window.addEventListener("load", function() {

	// store tabs variables
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

});