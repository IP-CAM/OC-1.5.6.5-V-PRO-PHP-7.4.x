<?php echo $header; ?>
<style type="text/css">	
	body, td, th, input, select, textarea, option, optgroup {font-family: Tahoma,Geneva,sans-serif;color: #383838;}
	.box > .color-content {padding: 10px;border-left: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;border-bottom: 1px solid #CCCCCC;min-height: 300px;overflow: auto;}
	.box > .heading {-webkit-border-radius: 3px 3px 0px 0px;-moz-border-radius: 3px 3px 0px 0px;-khtml-border-radius: 3px 3px 0px 0px;border-radius: 3px 3px 0px 0px;}
	.box > .heading h1 img {width: 24px;height: 24px;}
	.vtabs {padding: 0px 0px;}
	.htabs {height: 38px;margin-bottom: 35px;}
	.htabs a.selected {padding-bottom: 12px;color: #383838;border-top: 1px solid #DDDDDD;border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;}
	.htabs a {font-family: Tahoma,Geneva,sans-serif;background: #F2F2F2;padding: 10px 25px 10px 25px;color: #383838;text-transform: uppercase;}
	label {margin-left: 5px;}
	.vtabs a.selected {padding-right: 15px;background: #FB9337;text-align: right;color: #f7f7f7;}
	.vtabs a, .vtabs span {font-family: Tahoma,Geneva,sans-serif;padding: 10px 14px 10px 15px;text-align: left;font-size: 12px;color: #383838;text-transform: uppercase;background: #F2F2F2;}
	.customhelp { color: #575757; font-size:9px; }	
	.color { border:1px solid #AAA; }
	.colourcode {text-align: right;padding: 10px 30px 0 0;border-left: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;overflow: auto;border-bottom: 1px solid #eee;}
	.imagpatt {width: 25px;display: inline-block; text-align: center;margin: 7px;}
	table.form {margin-bottom:0;}
	table.form b {color:#383838;text-transform: uppercase;font-size:13px}	
	table.form div {margin: 5px 0;}
	.help {font-size: 10px;font-family: Tahoma,Geneva,sans-serif;}
	table.form > tbody > tr > td {padding: 7px 10px 0px 10px;color: #383838;border-bottom: 1px dotted #eee;}
	table.form > tbody > tr > td.head {border-bottom: 2px solid #FB9337;}
	.scrollbox {width: 200px;overflow-x: hidden;height:auto;max-height:100px;padding: 2px 5px;color: #808080; border: 1px solid #ccc; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }
	input,input[type="text"],select,.uneditable-input{display:inline-block;height:18px;padding:4px;margin-bottom:9px;font-size:13px;line-height:18px;color:#555555;border:1px solid #ccc;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}
	textarea {display:inline-block;padding:4px;margin-bottom:9px;font-size:13px;line-height:18px;color:#555555;border:1px solid #ccc;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}
	input[type="image"],input[type="checkbox"],input[type="radio"]{width:auto;height:auto;padding:0;margin:3px 0;*margin-top:0;line-height:normal;border:0;cursor:pointer;border-radius:0 \0/;}
	select,input[type="file"]{height:28px;*margin-top:4px;line-height:28px;}
	select{width: 120px;background-color:#ffffff;}
	.list tbody td a {text-decoration: none;}
	.list .left {padding: 14px;}
	input,textarea{-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition:border linear 0.2s,box-shadow linear 0.2s;-moz-transition:border linear 0.2s,box-shadow linear 0.2s;-ms-transition:border linear 0.2s,box-shadow linear 0.2s;-o-transition:border linear 0.2s,box-shadow linear 0.2s;transition:border linear 0.2s,box-shadow linear 0.2s;}
	input:focus,textarea:focus{border-color:rgba(82, 168, 236, 0.8);-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 8px rgba(82, 168, 236, 0.6);-moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 8px rgba(82, 168, 236, 0.6);box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 8px rgba(82, 168, 236, 0.6);outline:0;outline:thin dotted \9;}
	a.button {text-decoration: none;background: #003A88;-webkit-border-radius: 10px 10px 10px 10px;-moz-border-radius: 10px 10px 10px 10px;-khtml-border-radius: 10px 10px 10px 10px;color: #ffffff;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);background-color: #006dcc;background-image: -moz-linear-gradient(top, #0088cc, #0044cc);background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));background-image: -webkit-linear-gradient(top, #0088cc, #0044cc);background-image: -o-linear-gradient(top, #0088cc, #0044cc);background-image: linear-gradient(to bottom, #0088cc, #0044cc);background-repeat: repeat-x;border-color: #0044cc #0044cc #002a80;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0044cc', GradientType=0);filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);margin-bottom: 0;display: inline-block;padding: 4px 12px;margin-top: -3px;font-size: 14px;line-height: 20px;text-align: center;vertical-align: middle;cursor: pointer;background-repeat: repeat-x;border: 1px solid #bbbbbb;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);}
	a.button:hover { color: #ffffff;background-color: #0044cc;*background-color: #003bb3;  text-decoration: none;background-position: 0 -15px;-webkit-transition: background-position 0.1s linear;}
	.preview-image {background: #fff;padding: 3px;border: none;box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.2);margin-bottom: 20px;}
	a.button2:hover {color: #fff;text-decoration: none;background-position: 0 -15px;-webkit-transition: background-position 0.1s linear;}
	a.button2{text-decoration: none;background: #999;color: #777;text-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);background-color: #ccc;background-image: -moz-linear-gradient(top, #eee, #ddd);background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#eee), to(#ddd));background-image: -webkit-linear-gradient(top, #eee, #ddd);background-image: -o-linear-gradient(top, #eee, #ddd);background-image: linear-gradient(to bottom, #eee, #ddd);background-repeat: repeat-x;border-color: #ccc #ccc #ccc;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0044cc', GradientType=0);filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);margin-bottom: 0;display: inline-block;padding: 4px 12px;margin-top: -3px;line-height: 13px;text-align: center;vertical-align: middle;cursor: pointer;background-repeat: repeat-x;border: 1px solid #ddd;-webkit-border-radius: 2px;-moz-border-radius: 0px;border-radius: 4px;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);}
	.prewbagr {width: 250px;height: 100px;text-align: center;background-color: #fff;border: 1px solid #DDDDDD;}
	.tooltip-mark {background: #575757;border-radius: 10px;color: #fff;font-size: 10px;margin-left: 10px;margin-right: 5px;padding: 1px 4px;box-shadow: 0 1px 3px #999;-moz-box-shadow: 0 1px 3px #999;-webkit-box-shadow: 0 1px 3px #999;}
	.tooltip {background: #F9F9F9;border: 1px solid #CCC;color: #383838;display: none;font-size: 11px;font-weight: normal;line-height: 1.3;margin-left: -20px;margin-top: 20px;max-width: 100%;padding: 15px;position: absolute;text-align: left;z-index: 100;box-shadow: 0 6px 9px #AAA;-moz-box-shadow: 0 6px 9px #AAA;-webkit-box-shadow: 0 6px 9px #AAA;}
	.tooltip-mark:hover, .tooltip-mark:hover + .tooltip, .tooltip:hover {display: inline;cursor: help;}
	.hidden {display:none;}
</style>
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
      <h1><img src="view/image/label32.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_banner; ?></td>
              <td class="left"><span class="required">*</span> <?php echo $entry_dimension; ?></td>
              <td class="right"><?php echo $entry_style; ?></td>
			  <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="right"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
          <?php foreach ($modules as $module) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left"><select name="card_module[<?php echo $module_row; ?>][banner_id]">
                  <?php foreach ($banners as $banner) { ?>
                  <?php if ($banner['banner_id'] == $module['banner_id']) { ?>
                  <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><input type="text" name="card_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="3" />
                <input type="text" name="card_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="3" />
                <?php if (isset($error_dimension[$module_row])) { ?>
                <span class="error"><?php echo $error_dimension[$module_row]; ?></span>
                <?php } ?></td>
              <td class="left"><input type="text" name="card_module[<?php echo $module_row; ?>][custom_style]" value="<?php echo $module['custom_style']; ?>" size="5" /></td>
			  <td class="left"><select name="card_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="card_module[<?php echo $module_row; ?>][position]">
                  <?php if ($module['position'] == 'content_top') { ?>
                  <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                  <?php } else { ?>
                  <option value="content_top"><?php echo $text_content_top; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_bottom') { ?>
                  <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                  <?php } else { ?>
                  <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_left') { ?>
                  <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                  <?php } else { ?>
                  <option value="column_left"><?php echo $text_column_left; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_right') { ?>
                  <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                  <?php } else { ?>
                  <option value="column_right"><?php echo $text_column_right; ?></option>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="card_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="card_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="7"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="card_module[' + module_row + '][banner_id]">';
	<?php foreach ($banners as $banner) { ?>
	html += '      <option value="<?php echo $banner['banner_id']; ?>"><?php echo addslashes($banner['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><input type="text" name="card_module[' + module_row + '][width]" value="" size="3" /> <input type="text" name="card_module[' + module_row + '][height]" value="" size="3" /></td>';
	html += '    <td class="left"><input type="text" name="card_module[' + module_row + '][custom_style]" value="card" size="5" /></td>';
	html += '    <td class="left"><select name="card_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="card_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="card_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="card_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script> 
<?php echo $footer; ?>