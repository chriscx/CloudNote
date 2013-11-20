
function createNote() {
	var name = document.getElementById("note_name");
	$.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/create', 
    data: { name_note: name.value },
    async: false,
    success: function(response) {
        //alert(response);
        var json = jQuery.parseJSON(response);
    	$('#newFile').modal('hide');
        if(!json.error) {
            //"<li class=''><a href='#' id_note='" . $listOfNotes[$i]['id_note'] . "'> ". $listOfNotes[$i]['name'] . "</a></li>"
            var disabled = document.getElementsByClassName('disabled');
            disabled[0].className = '';
            var li = document.createElement('li');
            li.setAttribute('class', 'disabled');
            var a = document.createElement('a');
            a.setAttribute('href', '#');
            a.setAttribute('id_note', json.id_note);
            a.setAttribute('selected', 'true');
            a.setAttribute('onclick', 'loadNote(this)');
            var span = document.createElement('span');
            span.setAttribute('onclick', 'deleteNote(this)');
            span.setAttribute('class', 'btn btn-mini');
            span.setAttribute("id_note", json.id_note);
            span.setAttribute('style', 'float:right');
            var i = document.createElement('i');
            i.setAttribute('class', 'icon-remove');
            span.appendChild(i);
            a.appendChild(document.createTextNode(json.name_note));
            a.appendChild(span);
            li.appendChild(a);
            document.getElementById("list_notes").insertBefore(li, document.getElementById("list_notes").firstChild);
            document.getElementById("note_content").setAttribute("id_note", json.id_note);
            document.getElementById("note_content").value = '';
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
    // if Note already loaded and diplayed, do not executed ajax
    if(_this.parentNode.getAttribute('class') !== 'disabled') {
    	var id = _this.getAttribute('id_note');
        if(typeof document.getElementsByClassName('disabled')[0] !== 'undefined') {
            var a = document.getElementsByClassName('disabled');
            a[0].className = '';
            syncNoteBeforeUnload();
        }
        _this.parentNode.className = 'disabled';
        //alert(id);
    	$.ajax({  
        type: 'POST',  
        url: 'http://localhost/CloudNote/index.php/main/load/', 
        data: { id_note: id },
        success: function(response) {
            //alert(response);
            response = response.replace('\n', '\\n');
            //alert(response);
            var json = jQuery.parseJSON(response);
            if(!json.error) {
            document.getElementById("note_content").setAttribute("id_note", json.id_note);
            document.getElementById("note_content").value = json.content_note;
            }  
        }});
    }
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

function deleteNote(_this) {
    var id = _this.getAttribute('id_note');
    var parent_a =_this.parentNode;
    var parent_li = parent_a.parentNode;
    parent_li.parentNode.removeChild(parent_li);
    //alert(id);
    $.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/delete', 
    data: { id_note: id },
    success: function(response) {
        //alert(response);
        var json = jQuery.parseJSON(response);
        if(!json.error) {
        //     var a = document.getElementByName('delete');
        // parent2.setAttribute('class', 'hide');

        var li_list = document.getElementsByTagName('li');
        loadNote(li_list[0].firstChild);
        li_list[0].setAttribute('class', 'disabled');

        }
    }});
}

function detectkeyword() {
    var regex, result1, result2, result3, sentences, i, text, id;
    text = $('#note_content').val();
    id = $('#note_content').attr('id_note');
    sentences = text.split(/[\\.!\?]/);

    for(i = 0; i < sentences.length - 1; i++) {

        regex = /(^|.)((M|m)eeting|(M|m)eet|(A|a)ppointment|(L|l)unch|(D|d)iner|)/;
        result1 = regex.exec(sentences[i]);
        if(result1 === null) {
            result1 = new Array();
            result1[0] = "null";
        }

        // TODO optimize the regex with ? for the years
        regex = /(^|.)((\d|[0]\d|[1][0-2])\/(\d|[0-2]\d|[3][0-1])(\/20\d\d|\/[0-9][0-9]))|((\d|[0]\d|[1][0-2])\/(\d|[0-2]\d|[3][0-1]))(.|$)/;
        result2 = regex.exec(sentences[i]);
        if(result2 === null) {
            result2 = new Array();
            result2[0] = "null";
        }
        //alert(result2);
        regex = /(^|.)(\d|[0]\d|[1][0-2]):([0-5]\d)\s?(?:AM|PM|am|pm)./;
        result3 = regex.exec(sentences[i]);
        if(result3 === null) {
            var result3 = new Array();
            result3[0] = "null";
        }

        var ident = result1[0]+result2[0]+result3[0];
        $.ajax({  
        type: 'POST',  
        url: 'http://localhost/CloudNote/index.php/main/addReminder', 
        data: { id_note: id,
                name: result1[0],
                date: result2[0],
                time: result3[0],
                identifier : ident },
        success: function(response) {
        }});
        
    }
}

// function detectDate() {
//     // TODO optimize the regex with ? for the years
//     var regex = /.((\d|[0]\d|[1][0-2])\/(\d|[0-2]\d|[3][0-1])(\/20\d\d|\/[0-9][0-9]))|((\d|[0]\d|[1][0-2])\/(\d|[0-2]\d|[3][0-1]))(.|$)/;
// }

// function detectTime() {
//     var regex = /.(\d|[0]\d|[1][0-2]):([0-5]\d)\s?(?:AM|PM|am|pm)\s?./;
// }
