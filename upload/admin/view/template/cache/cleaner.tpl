<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <div class="box">
	<div class="heading">
    <h1><img src="view/image/stock-status.png" alt=" <?php echo $heading_title; ?>" /><?php echo $heading_title; ?></h1>
	 <div class="buttons"><a class="button" href="<?php echo $this->url->link('cache/cleaner', 'token=' . $this->session->data['token'], 'SSL'); ?>"><?php echo $button_refresh; ?></a></div>
	</div>
	</div>
        <div class="content">
            <div class='response-div'></div>
            <form id="form1" action="<?php echo $action; ?>"  method="post">
                <table class="form">
                    <tbody>
                        <tr>
                            <td><?php echo $text_system; ?></td>
                            <td><a class='button delete_cache' data-isfile='0' data-file="<?php echo $mod_system; ?>"><?php echo $button_clean; ?></a></td>
                        </tr>                        
                        <tr>
                            <td><?php echo $text_vqcache; ?></td>
                            <td><a class='button delete_cache' data-isfile='0' data-file="<?php echo $mod_vqcache; ?>"><?php echo $button_clean; ?></a></td>
                        </tr>
                        <tr>
                            <td><?php echo $text_mode; ?></td>
                            <td><a class='button delete_cache' data-isfile='1' data-file="<?php echo $mod_cache; ?>"><?php echo $button_clean; ?></a></td>
                        </tr>
						<tr>
                            <td><?php echo $text_image; ?></td>
                            <td><a class='button delete_cache' data-isfile='0' data-file="<?php echo $mod_image; ?>"><?php echo $button_clean; ?></a></td>
                        </tr>
                    </tbody></table>
            </form>
            <table class="form">
            <tbody>
            <tr>
            <td>Database Cache:</td>
            <td><a class="button" href="<?php echo $this->url->link('module/db_cache/clear', 'token=' . $this->session->data['token'].'&redirectRoute='.$_GET['route'], 'SSL'); ?>">Clean DB Cache !</a>
            </tr>
            </tbody></table>
        </div>
    </div>
</div>
<?php echo $footer; ?>
<script>
    $('.delete_cache').on('click', function(e){
        e.preventDefault();
        var file = $(this).attr('data-file');
        var is_file = $(this).attr('data-isfile');
        $.ajax({
            url: 'index.php?route=cache/cleaner/delete&token=<?php echo $token; ?>',
            dataType: 'json',
            type:"POST",
            data:{'file':file,'is_file':is_file},
            success: function(json) {		
               $(".response-div").html(json.error);
               $(".response-div").addClass(json.type);
               $(".response-div").show(100);
            }
        });
    });
    $('.response-div').on('click', function(e){
        $(this).hide(300);
    });
</script>
