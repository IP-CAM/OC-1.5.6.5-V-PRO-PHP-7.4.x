<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div class="vtabs">
          <?php $module_row = 1; ?>
          <?php foreach ($modules as $module) { ?>
          <a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>"><?php echo isset($module['title']) ? $module['title'] : ''; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
          <?php $module_row++; ?>
          <?php } ?>
          <span id="module-add" onclick="addModule();" style="cursor: pointer;"><?php echo $add_template; ?>&nbsp;<img src="view/image/add.png" /></span> 
		</div>
        <?php $module_row = 1; ?>
        <?php foreach ($modules as $module) { ?>
        <div id="tab-module-<?php echo $module_row; ?>" class="vtabs-content">
        <table class="form">
          <tr>
            <td><div style="background: #EFEFEF;border-radius: 3px;border: 1px solid #DDDDDD;color: #000;padding: 0 10px;width: 98%;"><?php echo $name_template; ?> <input type="text" name="settings[<?php echo $module_row; ?>][title]" id="title-<?php echo $module_row; ?>" value="<?php echo isset($module['title']) ? $module['title'] : ''; ?>" style="width: 80%;" /><input type="hidden" name="settings[<?php echo $module_row; ?>][template_id]" value="<?php echo $module_row; ?>" /></div></td>
          </tr>
          <tr>
		    <td>
                <table class="list">
                  <thead>
                    <tr>
                      <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input.ch<?php echo $module_row; ?>').attr('checked', this.checked);" /></td>
                      <td class="left"><?php echo $attribute_name; ?></td>
					  <td class="left"><?php echo $attribute_value; ?></td>
                      <td class="left"><?php echo $attribute_group; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($attributes as $attribute) { ?>
                    <tr>
                      <td style="text-align: center;">
						<?php if (isset($module['selected'][$attribute['attribute_id']]) && (($module['selected'][$attribute['attribute_id']]) == ($attribute['attribute_id']))) { ?>
                        <input type="checkbox" name="settings[<?php echo $module_row; ?>][selected][<?php echo $attribute['attribute_id']; ?>]" value="<?php echo $attribute['attribute_id']; ?>" checked="checked" class="ch<?php echo $module_row; ?>" />
                        <?php } else { ?>
                        <input type="checkbox" name="settings[<?php echo $module_row; ?>][selected][<?php echo $attribute['attribute_id']; ?>]" value="<?php echo $attribute['attribute_id']; ?>" class="ch<?php echo $module_row; ?>" />
                        <?php } ?>
					  </td>
                      <td class="left"><?php echo $attribute['name']; ?></td>
                      <td class="left">
					  <?php foreach ($languages as $language) { ?>
					  <img style="margin: 12px 5px;" src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" />
					  <textarea name="settings[<?php echo $module_row; ?>][<?php echo $attribute['attribute_id']; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="2"><?php echo isset($module[$attribute['attribute_id']]['product_attribute_description'][$language['language_id']]) ? $module[$attribute['attribute_id']]['product_attribute_description'][$language['language_id']]['text'] : ''; ?></textarea>
					  <?php } ?>
					  </td>
                      <td class="left"><?php echo $attribute['attribute_group']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
			</td>
          </tr>
        </table>
        </div>
        <?php $module_row++; ?>
        <?php } ?>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';
	html += '      <table class="form">';
	html += '        <tr>';
	html += '          <td><div style="background: #EFEFEF;border-radius: 3px;border: 1px solid #DDDDDD;color: #000;padding: 0 10px;width: 98%;"><?php echo $name_template; ?> <input name="settings[' + module_row + '][title]" id="title-' + module_row + '" style="width: 80%;"></input><input type="hidden" name="settings[' + module_row + '][template_id]" value="' + module_row + '" /></div></td>';
	html += '        </tr>';
	html += '        <tr>';
	html += '          <td>';
	html += '              <table class="list">';
	html += '                <thead>';
	html += '                  <tr>';
	html += '                    <td width="1" style="text-align: center;"><input type="checkbox" onclick="$(\'input.ch' + module_row + '\').attr(\'checked\', this.checked);"  /></td>';
	html += '                    <td class="left"><?php echo $attribute_name; ?></td>';
	html += '                    <td class="left"><?php echo $attribute_value; ?></td>';
	html += '                    <td class="left"><?php echo $attribute_group; ?></td>';
	html += '                  </tr>';
	html += '                </thead>';
	html += '                <tbody>';
                               <?php foreach ($attributes as $attribute) { ?>
	html += '                  <tr>';
	html += '                    <td style="text-align: center;"><input type="checkbox" name="settings[' + module_row + '][selected][<?php echo $attribute['attribute_id']; ?>]" value="<?php echo $attribute['attribute_id']; ?>" class="ch' + module_row + '" /></td>';
	html += '                    <td class="left"><?php echo $attribute['name']; ?></td>';
	html += '                    <td class="left">';
                                   <?php foreach ($languages as $language) { ?>
	html += '                      <img style="margin: 12px 5px;" src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" />';
	html += '                      <textarea name="settings[' + module_row + '][<?php echo $attribute['attribute_id']; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="2"></textarea>';
                                   <?php } ?>
	html += '                    </td>';
	html += '                    <td class="left"><?php echo $attribute['attribute_group']; ?></td>';
	html += '                  </tr>';
                               <?php } ?>
	html += '                </tbody>';
	html += '               </table>';
	html += '           </td>';
	html += '         </tr>';
	html += '      </table>';
	html += '</div>';
	
	$('#form').append(html);

	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><?php echo $tab_template; ?> ' + module_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	$('.vtabs a').tabs();

	$('#module-' + module_row).trigger('click');
	
	module_row++;
}

$('.vtabs a').tabs();

setInterval (function () {
    $('.breadcrumb + .success').fadeOut('slow');
}, 5000);
//--></script>
<?php echo $footer; ?>