function resize(e) {
   	document.getElementById('note_content').rows = ($(document).height() - 85) / 20;
   	document.getElementById('list_note_new_button').setAttribute('style', "overflow:scroll; height:" + ($(document).height() - 85) + "px;");
}

function check_signup() {
	var email, email_conf, password, password_conf;
	email = $('email');
	email_conf = $('email_c');
	password = $('password');
	password_conf = $('password_c');

	if(email !== email_c) {
		return false;
	}
	else {
		if(password !== password_c) {

			
			return false;
		}else {
			return true;
		}
	}
}