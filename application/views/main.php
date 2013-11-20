<?php include "header.php";?>
 <script> 
    window.setInterval("syncNote()",10000);
    window.setInterval("detectkeyword()", 15000);
 </script>
    <div style="width: 90%; padding-left: 5%;" class="row-fluid">
        <div class="span12">
            <div class="span3" id='list_note_new_button'>
                <div class="row">
                    <button class="btn btn-large" style="width: 100%;" data-toggle="modal" href="#newFile">New Note</button>
                        <div id="newFile" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>New Note</h3>
                            </div>
                            <div class="modal-body">
                               <input type="text" id="note_name" placeholder="Name">
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" onclick="$('#newFile').modal('hide')">Close</a>
                                <a class="btn btn-primary" onclick="createNote()">Create Note</a>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="">
                            <ul class="nav nav-tabs nav-stacked" id="list_notes">
                                <?php
                                    for($i = 0; $i < count($listOfNotes); $i++) {
                                        if($i === 0) {
                                            echo "<li class='disabled'><a onclick='loadNote(this)' selected='true' id_note='" . $listOfNotes[$i]['id_note'] . "'> ". $listOfNotes[$i]['name'] . " <span onclick='deleteNote(this)' class='btn btn-mini' id_note='" . $listOfNotes[$i]['id_note'] . "' style='float:right'><i class='icon-remove'></i></span></a></li>";
                                        }
                                        else
                                            echo "<li><a onclick='loadNote(this)' selected='false' id_note='" . $listOfNotes[$i]['id_note'] . "'> ". $listOfNotes[$i]['name'] . " <span onclick='deleteNote(this)' class='btn btn-mini' id_note='" . $listOfNotes[$i]['id_note'] . "' style='float:right'><i class='icon-remove'></i></span></a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="span7">
                    <div style="height: 90%;">
                        <textarea spellcheck="true" style="width: 95%;" id="note_content" <?php echo "id_note='". $listOfNotes[0]['id_note']. "'"?>><?php echo $content_note_displayed; ?></textarea>
                    </div>
                </div>
                <div class="span2">
                    <div class="row">
                        <div class="">
                            <ul class="nav nav-tabs nav-stacked" id="list_reminders">
                                <?php
                                    // for($i = 0; $i < count($listOfNotes); $i++) {
                                    //     if($i === 0) {
                                    //         echo "<li class='disabled'><a onclick='loadNote(this)' selected='true' id_note='" . $listOfNotes[$i]['id_note'] . "'> ". $listOfNotes[$i]['name'] . " <span onclick='deleteNote(this)' class='btn btn-mini' style='float:right'><i class='icon-remove'></i></span></a></li>";
                                    //     }
                                    //     else
                                    //         echo "<li class=''><a onclick='loadNote(this)' selected='false' id_note='" . $listOfNotes[$i]['id_note'] . "'> ". $listOfNotes[$i]['name'] . " <span onclick='deleteNote(this)' class='btn btn-mini' style='float:right'><i class='icon-remove'></i></span></a></li>";
                                    // }
                                ?>
                                <div id="reminder" id_reminder="" class="modal hide fade">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h3>Reminder</h3>
                                    </div>
                                    <div class="modal-body">
<!--                                        <input type="text" id="reminder_name" placeholder="Name">
                                       <input type="text" id="reminder_date" placeholder="Date">
                                       <input type="text" id="reminder_time" placeholder="Time"> -->
                                       <textarea type="text" id="reminder_description" placeholder="Description"></textarea><br>
                                       <input type="text" id="reminder_location" placeholder="Location">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#" class="btn" onclick="$('#reminder').modal('hide')">Close</a>
                                        <a class="btn btn-primary" onclick="syncReminder(this)">Save</a>
                                    </div>
                                </div>
                                <?php
                                    for($i = 0; $i < count($listOfReminders); $i++) {
                                        echo "<li id='".$listOfReminders[$i]['id_reminder']."' id_note='".$listOfReminders[$i]['id_note']."'><a><span>name: </span><span name='name'>".$listOfReminders[$i]['name']."</span><br /><span>date: </span><span name='date'>".$listOfReminders[$i]['date']."</span><br /><span>time: </span><span name='time'>".$listOfReminders[$i]['time']."</span><br /><span>location: </span><span name ='location'>".$listOfReminders[$i]['location']."</span><span name='description' class='hide'></span></a><button class='btn' onclick='openModalReminder(this)'>Open</button><button class='btn' onclick='deleteReminder(this)'>Remove</button></li><li><br /></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 <script> 
    $(window).bind('beforeunload', syncNoteBeforeUnload());
    var height = $(document).height() - 85;
    document.getElementById('note_content').rows = height / 20;
    window.onresize = resize;
 </script>
<?php include "footer.php"?>