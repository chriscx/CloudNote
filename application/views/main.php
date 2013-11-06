<?php include "header.php";?>
    <div style="width: 90%; padding-left: 5%;" class="row-fluid">
        <div class="span12">
            <div class="span3">
                <div class="row">
                    <button class="btn btn-large" style="width: 100%;" data-toggle="modal" href="#newFile">New Note</button>
                        <div id="newFile" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>New Note</h3>
                            </div>
                            <div class="modal-body">
                               <input type="text" placeholder="Name">
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" onclick="$('#newFile').modal('hide')">Close</a>
                                <a href="#" class="btn btn-primary" onclick="$('#newFile').modal('hide')">Create Note</a>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="">
                            <ul class="nav nav-tabs nav-stacked">
                                <li class="disabled"><a href="#">File 1</a></li>
                                <li class=""><a href="#">File 2</a></li>
                                <li class=""><a href="#">File 3</a></li>
                                <li class=""><a href="#">File 4</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="span9">
                    <div style="height: 90%;">
                        <textarea style="width: 100%; height: 100%;" rows="25" spellcheck="true"></textarea>
                    </div>
                </div>
            </div>
        </div>
<?php include "footer.php"?>