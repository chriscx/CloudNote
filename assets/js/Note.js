
function createNote() {
	var name = document.getElementById("note_name");
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/create', 
    data: { name_note: name.value },
    success: function(response) {
    	document.getElementById("note_content").value = response;
    	$('#newFile').modal('hide');
    }});
}

function loadNote(note_id) {
	var id = document.getElementById(note_id);
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/load', 
    data: { id_note: id.value },
    success: function(response) {
        content.html(response);
    }});
}

function syncNote() {
	var content = document.getElementById("note_content");
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/sync', 
    data: { id_note: content.value },
    success: function(response) {
        content.html(response);
    }});
}

function deleteNote(note_id) {
	var id = document.getElementById(note_id);
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/delete', 
    data: { id_note: id.innerHTML },
    success: function(response) {
        content.html(response);
    }});
}

function refreshListOfNotes() {
    
}