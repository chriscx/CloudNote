
function createNote() {
	var name = document.getElementById("note_name");
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/create', 
    data: { name_note: name.value },
    success: function(response) {
        //alert(response);
        var json = jQuery.parseJSON(response);
    	$('#newFile').modal('hide');
        if(!json.error) {
            //"<li class=''><a href='#' id_note='" . $listOfNotes[$i]['id_note'] . "'> ". $listOfNotes[$i]['name'] . "</a></li>"
            var li = document.createElement('li');
            li.setAttribute('class', 'disabled');
            var a = document.createElement('a');
            a.setAttribute('href', '#');
            a.setAttribute('id_note', json.id_note);
            a.setAttribute('selected', 'true');
            a.appendChild(document.createTextNode(json.name_note));
            li.appendChild(a);
            document.getElementById("list_notes").insertBefore(li, document.getElementById("list_notes").firstChild);
            document.getElementById("note_content").setAttribute("id_note", json.id_note);
        }
        else if(json.error === 1) {
            alert("error 1");
        }
        else if(json.error === 2) {
            alert("error 2");
        }
    }});
}

function loadNote(_this) {
	var id = _this.getAttribute('id_note');
    //alert(id);
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/load/', 
    data: { id_note: id },
    success: function(response) {
        //alert(response);
        var json = jQuery.parseJSON(response);
        if(!json.error) {
        document.getElementById("note_content").setAttribute("id_note", json.id_note);
        document.getElementById("note_content").value = json.content_note;
        }  
    }});
}

function syncNote() {
	var content = document.getElementById("note_content");
    //alert(content.value);
    var content_note = content.value;
    var id_note = content.getAttribute('id_note');
    //alert(id_note);
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/sync', 
    data: { "content_note": content_note,
            "id_note": id_note},
    success: function(response) {
        //maybe show a green dot or so to show sync as been done.
        //alert(response);
    }});
}

function syncNoteBeforeUnload() {
    var content = document.getElementById("note_content");
    //alert(content.value);
    var content_note = content.value;
    var id_note = content.getAttribute('id_note');
    //alert(id_note);
    $.ajax({  
    type: 'POST',  
    async : false,
    url: 'http://localhost/CloudNote/index.php/main/sync', 
    data: { "content_note": content_note,
            "id_note": id_note},
    success: function(response) {
        //maybe show a green dot or so to show sync as been done.
        //alert(response);
    }});
}

// function deleteNote(this) {
// 	var id = document.getElementById(note_id);
// 	$.ajax({  
//     type: 'POST',  
//     url: 'http://localhost/CloudNote/index.php/main/delete', 
//     data: { id_note: id.innerHTML },
//     success: function(response) {
//         content.html(response);
//     }});
// }