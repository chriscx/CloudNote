<?php include "header.php"?>
    <div class="container">

        <form class="form-horizontal" action="send" method="post">
            <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                    <input type="text" id="title" name="title" placeholder="" style="width : 500px">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                    <textarea id="description" style="width : 500px" name="description" placeholder="Describe the problem in detail... mostly when, how, on what action the bug happened..."></textarea>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn">Send bug report</button>
                </div>
            </div>
        </form>
    </div>
<script> 
    var height = $(document).height() - 85;
    document.getElementById('description').rows = height / 20;
    window.onresize = resize;
</script>
<?php include "footer.php"?>