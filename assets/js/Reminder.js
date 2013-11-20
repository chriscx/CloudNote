function deleteReminder(_this) {
    var id = _this.parentNode.getAttribute('id');
    var li = _this.parentNode;
    li.parentNode.removeChild(li);
    //alert(id);
    $.ajax({  
    type: 'POST',  
    url: 'http://localhost/CloudNote/index.php/main/deleteReminder', 
    data: { id_reminder: id },
    success: function(response) {
    }});
}

function syncReminder(_this) {
    var id, location, description;
    //alert(content.value);
    id = $('#reminder').attr('id_reminder');
    // name = $('#reminder_name').val();
    // date = $('#reminder_date').val();
    // console.log(date);
    // time = $('#reminder_time').val();
    location = $('#reminder_location').val();
    description = $('#reminder_description').val();
    $('#reminder').modal('hide');
    //alert(id_note);
    $.ajax({  
    type: 'POST',
    url: 'http://localhost/CloudNote/index.php/main/syncReminder', 
    data: { "id_reminder": id,
            // "name_r": name,
            // "date_r": date,
            // "time_r": time,
            "location_r": location,
            "description_r": description },
    success: function(response) {
        var id = $('#reminder').attr('id_reminder');
        var li =document.getElementById(id);

        var children = li.children[0].children;
        //TODO add the values
        for (var i = 0; i < children.length; i++) {
            console.log(children[i]);
            //alert(children[i].innerHTML);
            if(children[i].tagName === 'SPAN' && children[i].getAttribute('name') === 'description') {
                children[i].innerHTML = $('#reminder_description').val();
            } else
            if(children[i].tagName === 'SPAN' && children[i].getAttribute('name') === 'location') {
                children[i].innerHTML = $('#reminder_location').val();
            }
        }

        $('#reminder_location').val("");
        $('#reminder_description').val("");
    }});
}


function openModalReminder(_this) {
    var id, name, date, time, location, li, children;
    li = _this.parentNode;
    $('#reminder').attr("id_reminder", li.getAttribute("id"));
    regex = /(^|.)((M|m)eet|(M|m)eeting|(A|a)ppointment|(L|l)unch|(D|d)iner|)(.|$)/;
    children = li.children[0].children;
    //TODO add the values
    for (var i = 0; i < children.length; i++) {
        console.log(children[i]);
        //alert(children[i].innerHTML);
        if(children[i].tagName === 'SPAN' && children[i].getAttribute('name') === 'description') {
            $('#reminder_description').val(children[i].innerHTML);
        } else
        if(children[i].tagName === 'SPAN' && children[i].getAttribute('name') === 'location') {
            $('#reminder_location').val(children[i].innerHTML);
        }
    }
    $('#reminder').modal('show');
}

function getIcalFile(_this) {

}