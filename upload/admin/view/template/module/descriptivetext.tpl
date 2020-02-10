<?php echo $header; ?>
<style type="text/css">
	.customhelp { colour: #666; font-size:0.9em; }
</style>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) {
            echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
    <?php if ($success) { ?>
        <div class="success"><?php echo $success; ?></div>
    <?php } 
	if ($error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>

    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="$('#form').attr('action', '<?php echo $action; ?>&continue=1');$('#form').submit();" class="button"><?php echo $button_apply; ?></a> 
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
                <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div>
    
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        
                <div style="margin:0px;float:right;">
                    <label><?php echo $entry_status; ?></label> 
                    <select name="descriptive_status">
                        <?php if ($descriptive_status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                    </select>
                  </div>
        
                <div id="settings_tabs" class="htabs clearfix">
                    <a href="#tab_settings"><?php echo $tab_settings; ?></a>
                 </div>
                
                <div id="tab_settings" class="divtab">
                    <table class="form">
                    	<p><strong>Enter your custom text to be displayed on on the Product page:</strong></p>
                        <tr>
                            <td>
                                <?php echo $entry_descriptive_brand; ?>
                            </td>
                            <td>
                            	<?php foreach ($languages as $language) { ?>
                                	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?><br />
                            		<textarea name="descriptive_brand_<?php echo $language['language_id']; ?>"><?php echo $descriptive_brand.$language['language_id']; ?></textarea><br />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_descriptive_price; ?>
                            </td>
                            <td>
                            	<?php foreach ($languages as $language) { ?>
                                	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?><br />
                                    <textarea name="descriptive_price_<?php echo $language['language_id']; ?>"><?php echo $descriptive_price; ?></textarea><br />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_descriptive_profiles; ?>
                            </td>
                            <td>
                            	<?php foreach ($languages as $language) { ?>
                                	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?><br />
                                    <textarea name="descriptive_profiles_<?php echo $language['language_id']; ?>"><?php echo $descriptive_profiles; ?></textarea><br />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_descriptive_options; ?>
                            </td>
                            <td>
                            	<?php foreach ($languages as $language) { ?>
                                	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?><br />
                                    <textarea name="descriptive_options_<?php echo $language['language_id']; ?>"><?php echo $descriptive_options; ?></textarea><br />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_descriptive_cart; ?>
                            </td>
                            <td>
                            	<?php foreach ($languages as $language) { ?>
                                	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?><br />
                                    <textarea name="descriptive_cart_<?php echo $language['language_id']; ?>"><?php echo $descriptive_cart; ?></textarea><br />
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </div>              
            </form>
        </div>
    </div>
</div>

<?php echo $footer; ?>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
<?php foreach ($languages as $language) { ?>
	var langid = <?php echo $language['language_id']; ?>;
	CKEDITOR.replace('descriptive_brand_'+langid, {
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
	});  
	CKEDITOR.replace('descriptive_price_'+langid, {
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
	}); 
	CKEDITOR.replace('descriptive_profiles_'+langid, {
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
	}); 
	CKEDITOR.replace('descriptive_options_'+langid, {
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
	}); 
	CKEDITOR.replace('descriptive_cart_'+langid, {
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
	}); 
<?php } ?>
</script>

<script type="text/javascript">
	$('#settings_tabs a').tabs();
</script>