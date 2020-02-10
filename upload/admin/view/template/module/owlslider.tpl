<?php echo $header; $module_row=0; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div>
			<table class="form">
						<tr>
						  <td><?php echo $entry_layout; ?></td>
						  <td><select name="owlslider_module[<?php echo $module_row; ?>][layout_id]">
							 <?php foreach ($layouts as $layout) { ?>
							  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
							  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
							  <?php } else { ?>
							  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
							  <?php } ?>
							  <?php } ?>
							</select></td>
						</tr>
						<tr>
						  <td><?php echo $entry_position; ?></td>
						  <td><select name="owlslider_module[<?php echo $module_row; ?>][position]">
							  <?php foreach( $positions as $pos ) { ?>
							  <?php if ($module['position'] == $pos) { ?>
							  <option value="<?php echo $pos;?>" selected="selected"><?php echo $this->language->get('text_'.$pos); ?></option>
							  <?php } else { ?>
							  <option value="<?php echo $pos;?>"><?php echo $this->language->get('text_'.$pos); ?></option>
							  <?php } ?>
							  <?php } ?> 
							</select></td>
						</tr>
						<tr>
						  <td><?php echo $entry_status; ?></td>
						  <td><select name="owlslider_module[<?php echo $module_row; ?>][status]">
							  <?php if ($module['status']) { ?>
							  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							  <option value="0"><?php echo $text_disabled; ?></option>
							  <?php } else { ?>
							  <option value="1"><?php echo $text_enabled; ?></option>
							  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							  <?php } ?>
							</select></td>
						</tr>
						<tr>
						  <td><?php echo $entry_sort_order; ?></td>
						  <td><input type="text" name="owlslider_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
						</tr>
						
						<tr>
						  <td><?php echo $entry_width; ?></td>
						  <td><input type="text" name="owlslider_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="8" /></td>
						</tr>
						<tr>
						  <td><?php echo $entry_height; ?></td>
						  <td><input type="text" name="owlslider_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="8" /></td>
						</tr>
						<?php //print_r($module); ?>
                        <tr>
						  <td><?php echo $entry_responsive; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][responsive]" value="1" <?php if(isset($module['responsive']) && $module['responsive'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][responsive]" value="0" <?php if(isset($module['responsive']) && $module['responsive'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_autoheight; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][autoheight]" value="1" <?php if(isset($module['autoheight']) && $module['autoheight'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][autoheight]" value="0" <?php if(isset($module['autoheight']) && $module['autoheight'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_autoplay; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][autoplay]" value="1" <?php if(isset($module['autoplay']) && $module['autoplay'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][autoplay]" value="0" <?php if(isset($module['autoplay']) && $module['autoplay'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_stoponhover; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][stoponhover]" value="1" <?php if(isset($module['stoponhover']) && $module['stoponhover'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][stoponhover]" value="0" <?php if(isset($module['stoponhover']) && $module['stoponhover'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
						<tr>
						  <td><?php echo $entry_transition; ?></td>
						  <td><select name="owlslider_module[<?php echo $module_row; ?>][transition]">
                                <?php foreach( $transitions as $transition ) { ?>
								<option value="<?php echo $transition; ?>" <?php if( $transition==$module['transition']){ ?> selected="selected" <?php } ?>><?php echo $transition; ?></option>
								<?php } ?>
							 </select></td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_pagination; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][pagination]" value="1" <?php if(isset($module['pagination']) && $module['pagination'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][pagination]" value="0" <?php if(isset($module['pagination']) && $module['pagination'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_pagination_no; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][pagination_no]" value="1" <?php if(isset($module['pagination_no']) && $module['pagination_no'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][pagination_no]" value="0" <?php if(isset($module['pagination_no']) && $module['pagination_no'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_navigation; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][navigation]" value="1" <?php if(isset($module['navigation']) && $module['navigation'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][navigation]" value="0" <?php if(isset($module['navigation']) && $module['navigation'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_navigation_text; ?></td>
						  <td><input type="text" name="owlslider_module[<?php echo $module_row; ?>][navigation_text]" value="<?php echo $module['navigation_text']; ?>" size="50" />&nbsp; &nbsp; &nbsp; e.g. ["prev","next"]</td>
                        </tr>
                        
                        <tr>
						  <td><?php echo $entry_rewindnav; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][rewindnav]" value="1" <?php if(isset($module['rewindnav']) && $module['rewindnav'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][rewindnav]" value="0" <?php if(isset($module['rewindnav']) && $module['rewindnav'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        <tr>
						  <td><?php echo $entry_rewind_speed; ?></td>
						  <td><input type="text" name="owlslider_module[<?php echo $module_row; ?>][rewind_speed]" value="<?php echo $module['rewind_speed']; ?>" size="8" /></td>
                        </tr>
                        
                        <tr>
						  <td><?php echo $entry_slide_speed; ?></td>
						  <td><input type="text" name="owlslider_module[<?php echo $module_row; ?>][slide_speed]" value="<?php echo $module['slide_speed']; ?>" size="8" /></td>
                        </tr>
                        
                        <tr>
						  <td><?php echo $entry_pagination_speed; ?></td>
						  <td><input type="text" name="owlslider_module[<?php echo $module_row; ?>][pagination_speed]" value="<?php echo $module['pagination_speed']; ?>" size="8" /></td>
                        </tr>
                        
                        <tr>
						  <td><?php echo $entry_lazyload; ?></td>
						  <td>
                          		<input type="radio" name="owlslider_module[<?php echo $module_row; ?>][lazyload]" value="1" <?php if(isset($module['lazyload']) && $module['lazyload'] == "1" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_yes; ?>
			                    <input type="radio" name="owlslider_module[<?php echo $module_row; ?>][lazyload]" value="0" <?php if(isset($module['lazyload']) && $module['lazyload'] == "0" ) { ?> checked="checked" <?php } ?> /> <?php echo $text_no; ?>
                          </td>
						</tr>
                        
                        </table>
		</div>
		<h3>List of Banner Images</h3>
        <div class="vtabs">
	
          <?php 
		  
	// 	  echo '<pre>'.print_r( $banner_image,1 ); die; 
		  $banner_row=1;
		  
		  foreach ($banner_image as $banner_row=> $banner) { ?>
          <a href="#tab-module-<?php echo $banner_row; ?>" id="module-<?php echo $banner_row; ?>"><?php echo $tab_module . ' ' . $banner_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $banner_row; ?>').remove(); $('#tab-module-<?php echo $banner_row; ?>').remove(); return false;" /></a>
 
          <?php } ?>
          <span id="module-add"><?php echo $button_add_module; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addModule();" /></span> </div>
        <?php $banner_row = 1; ?>
        <?php foreach ($banner_image as $banner_row=> $banner) { ?>
        <div id="tab-module-<?php echo $banner_row; ?>" class="vtabs-content">
		
		 <table class="form">
		 
			 <tr>
				<td>Image</td>
			 <td class="left"><div class="image"><img src="<?php echo $banner['thumb']; ?>" alt="" id="thumb<?php echo $banner_row; ?>" />
                  <input type="hidden" name="banner_image[<?php echo $banner_row; ?>][image]" value="<?php echo $banner['image']; ?>" id="image<?php echo $banner_row; ?>"  />
                  <br />
                  <a onclick="image_upload('image<?php echo $banner_row; ?>', 'thumb<?php echo $banner_row; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $banner_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $banner_row; ?>').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
				  
			</tr>
			<tr>
				<td>Link</td>
				<td><input name="banner_image[<?php echo $banner_row;?>][link]" value="<?php echo $banner['link']?>" type="text"/></td>
			</tr>
		  </table>
		  
          <div id="language-<?php echo $banner_row; ?>" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#tab-language-<?php echo $banner_row; ?>-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>

          <?php foreach ($languages as $language) { ?>
          <div id="tab-language-<?php echo $banner_row; ?>-<?php echo $language['language_id']; ?>">
            <table class="form">
				<tr>
                    <td><?php echo $entry_title; ?></td>
                    <td><input size="60" name="banner_image[<?php echo $banner_row; ?>][title][<?php echo $language['language_id']; ?>]" id="title-<?php echo $banner_row; ?>-<?php echo $language['language_id']; ?>" value="<?php echo isset($banner['title'][$language['language_id']]) ? $banner['title'][$language['language_id']] : ''; ?>"/></td>
	            </tr>
			</table>
          </div>
          <?php } ?>
         
 
        </div>
 
        <?php $banner_row++; } ?>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php $banner_row = 1; ?>
<?php foreach ($banner_image as $banner) { ?>
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description-<?php echo $banner_row; ?>-<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
<?php $banner_row++; ?>
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
var banner_row = <?php echo $banner_row; ?>;

function addModule() {	
	html  = '<div id="tab-module-' + banner_row + '" class="vtabs-content">';
	
	
	html += '<table class="form"><tr><td>Image</td><td class="left"><div class="image"><img src="<?php echo $no_image; ?>" alt="" id="thumb' + banner_row + '" /><input type="hidden" name="banner_image[' + banner_row + '][image]" value="" id="image' + banner_row + '" /><br /><a onclick="image_upload(\'image' + banner_row + '\', \'thumb' + banner_row + '\');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#thumb' + banner_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + banner_row + '\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a></div></td>';
	html += '<tr><td>Link</td><td><input name="banner_image['+banner_row+'][link]" type="text" value=""/></td></tr>';
	html += '</table>';
	html += '  <div id="language-' + banner_row + '" class="htabs">';
    <?php foreach ($languages as $language) { ?>
    html += '    <a href="#tab-language-'+ banner_row + '-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
    <?php } ?>
	html += '  </div>';
	<?php foreach ($languages as $language) { ?>
	html += '    <div id="tab-language-'+ banner_row + '-<?php echo $language['language_id']; ?>">';
	html += '      <table class="form">';
	html += '		 <tr>';
	html += '          <td><?php echo $entry_title; ?></td>';
	html += '          <td><input name="banner_image[' + banner_row + '][title][<?php echo $language['language_id']; ?>]" id="title-' + banner_row + '-<?php echo $language['language_id']; ?>" type="text"/></td>';
	html += '        </tr>';
	html += '      </table>';
	html += '    </div>';
	<?php } ?>


	html += '</div>';
	
	$('#form').append(html);
	
	$('#language-' + banner_row + ' a').tabs();
	
	$('#module-add').before('<a href="#tab-module-' + banner_row + '" id="module-' + banner_row + '"><?php echo $tab_module; ?> ' + banner_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + banner_row + '\').remove(); $(\'#tab-module-' + banner_row + '\').remove(); return false;" /></a>');
	
	$('.vtabs a').tabs();
	
	$('#module-' + banner_row).trigger('click');
	
	banner_row++;
}
//--></script> 
<script type="text/javascript"><!--
$('.vtabs a').tabs();
//--></script> 
<script type="text/javascript"><!--
<?php $banner_row = 1; ?>
<?php foreach ($banner_image as $banner) { ?>
$('#language-<?php echo $banner_row; ?> a').tabs();
<?php $banner_row++; ?>
<?php } ?> 
//--></script> 

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<?php echo $footer; ?>