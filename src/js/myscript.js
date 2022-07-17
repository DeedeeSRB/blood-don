
function submit_contact_form()
{
	if ( !document.forms['add_donor_form'].reportValidity() ) {
		$("#response_div").html('Please fill out all the required fields!');
		$("#response_div").css("background-color", "red");
		$("#response_div").css("color","#FFFFFF");
		$("#response_div").css("padding","20px");
		return;
	}
	
	var fd = new FormData();
	
	fd.append('donorFormSubmit','1');
	fd.append('first_name',$("#first_name").val());
	fd.append('last_name',$("#last_name").val());
	fd.append('blood_group',$("#blood_group").val());
	fd.append('phone_number',$("#phone_number").val());
	fd.append('email',$("#email").val());
	fd.append('address',$("#address").val());
	js_submit(fd,submit_contact_form_callback);
}

function submit_contact_form_callback(data)
{
	var jdata = JSON.parse(data);

	var success = jdata.success;
	var mess = jdata.message;
	var color = jdata.color;

	$("#response_div").html(mess);
	$("#response_div").css("background-color", color);
	$("#response_div").css("color","#FFFFFF");
	$("#response_div").css("padding","20px");

	if ( success == 1 && $("#donors-table").length ) {
		location.reload();
	}
	

}

function js_submit( fd, callback )
{
	var submitUrl = "http://localhost/wordpress/wp-content/plugins/blood-don/templates/process/add-donor-process.php";

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