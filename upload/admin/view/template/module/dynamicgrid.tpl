<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
        <div class="warning">
        	<?php echo $error_warning; ?>
        </div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
                <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            	<div style="margin-bottom: 10px">
                    <label><?php echo $entry_bootstrap; ?></label>
                    <select name="bootstrap_status">
                        <?php if ($bootstrap_status) { ?>
                            <option value="1" selected="selected">Yes</option>
                            <option value="0">No</option>
                        <?php } else { ?>
                            <option value="1">Yes</option>
                            <option value="0" selected="selected">No</option>
                        <?php } ?>
                    </select>
                </div>
                <div style="margin-bottom: 10px">
                    <label><?php echo $entry_modernizr; ?></label>
                    <select name="modernizr_status">
                        <?php if ($modernizr_status) { ?>
                            <option value="1" selected="selected">Yes</option>
                            <option value="0">No</option>
                        <?php } else { ?>
                            <option value="1">Yes</option>
                            <option value="0" selected="selected">No</option>
                        <?php } ?>
                    </select>
                </div>

                <table id="module" class="list">
                    <thead>
                        <tr>
                            <td class="left"><?php echo $entry_title; ?></td>
                            <td class="left"><?php echo $entry_selection; ?></td>
                            <td class="left"><?php echo $entry_effect; ?></td>
                            <td class="left"><?php echo $entry_limit; ?></td>
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
                                <td style="vertical-align: top" class="left">              
                                    <?php echo $entry_code; ?> <input type="text" name="dynamicgrid_module[<?php echo $module_row; ?>][code]" value="<?php echo $module['code']; ?>" />
                                    <br/>&nbsp;<br/>
                                    <?php echo $entry_titlelink ?> <input type="text" name="dynamicgrid_module[<?php echo $module_row; ?>][titlelink]" value="<?php echo $module['titlelink']; ?>" />
                                    <br/>&nbsp;<br/>
                                    <?php foreach ($languages as $language) { ?>
                                        <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name'] . " " . $entry_title; ?> <input type="text" name="dynamicgrid_module[<?php echo $module_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo (isset($module['title'][$language['language_id']]) ? $module['title'][$language['language_id']] : ''); ?>" />
                                        <br/>
                                    <?php } ?>
                                </td>
                                <td style="vertical-align: top" class="left">
                                    <br /><b><?php echo $entry_category; ?></b>:<br />
                                    <div class="scrollbox">
                                        <?php $class = 'odd'; 
                                        foreach ($categories as $category) { 
                                            $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                            <div class="<?php echo $class; ?>">
                                                <?php if (isset($module['category']) and in_array($category['category_id'], $module['category'] )) { ?>
                                                <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][category][]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                                                <?php echo $category['name'];
                                                } else { ?>
                                                <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][category][]" value="<?php echo $category['category_id']; ?>" />
                                                <?php echo $category['name'];
                                                } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                                    <br />&nbsp;<br /><b><?php echo $entry_products; ?></b>:<br />
                                    <div style="padding-bottom: 4px;">
                                        <?php echo $entry_product; ?> <input type="text" name="product_<?php echo $module_row; ?>"/>
                                        <br/>
                                    </div>
                                    <div id="dynamicgrid-product-<?php echo $module_row; ?>" class="scrollbox">
                                        <?php $class = 'odd'; 
                                        foreach ($module['products_list'] as $p) { 
                                            $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                            <div id="dynamicgrid-product-<?php echo $module_row . '-' . $p['product_id']; ?>" class="<?php echo $class; ?>">
                                                <?php echo $p['name']; ?> 
                                                <img id="deleteImage_<?php echo $module_row; ?>" src="view/image/delete.png" />
                                                <input type="hidden" value="<?php echo $p['product_id']; ?>" />
                                            </div>
                                        <?php } ?>
                                    </div>			  
                                    <br />&nbsp;<br />
                                    <b><?php echo $entry_latest_text; ?>:</b> <input size="3" type="text" name="dynamicgrid_module[<?php echo $module_row; ?>][latest]" value="<?php echo (isset($module['latest'])) ? $module['latest'] : 0; ?>"/>
                                    <br />&nbsp;<br />
                                    <b><?php echo $entry_specials_text; ?>:</b> <input size="3" type="text" name="dynamicgrid_module[<?php echo $module_row; ?>][specials]" value="<?php echo (isset($module['specials'])) ? $module['specials'] : 0; ?>"/>
                                    <input type="hidden" name="dynamicgrid_module[<?php echo $module_row; ?>][products]" value="<?php echo $module['products']; ?>" />
                                    <!-- <hr/>
                                    <b><?php echo $entry_sort_order; ?></b>
                                    <select name="dynamicgrid_module[<?php echo $module_row; ?>][sortfield]">
                                        <option value="">Dont Sort</option>
                                        <?php foreach ($prodfields as $f) { ?>
                                            <option value="<?php echo $f; ?>" <?php echo (isset($module['sortfield']) and $f==$module['sortfield']) ? ' selectd="selected"' : ''; ?> ><?php echo $f; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($module['sortorder']) and $module['sortorder']=='desc') { ?> 
                                        <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][sortorder]" value="desc" checked="checked"/> <?php echo $entry_sort_descending; 
                                    } else { ?>
                                        <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][sortorder]" value="desc"/> <?php echo $entry_sort_descending; ?>
                                    <?php } ?> -->
                                </td>
       
                                <td style="vertical-align: top" class="left">
                                    <select name="dynamicgrid_module[<?php echo $module_row; ?>][effect]">
                                        <?php switch ($module['effect']) { 
                                        case "1": ?>
                                            <option value="1" selected="selected">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "2": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2" selected="selected">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "3": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3" selected="selected">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "4": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4" selected="selected">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "5": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5" selected="selected">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "6": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6" selected="selected">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "7": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7" selected="selected">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "8": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8" selected="selected">Effect 8</option>
                                            <option value="9">No Effect</option>
                                            <?php break;
                                        case "9": ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9" selected="selected">No Effect</option>
                                            <?php break;
                                        default: ?>
                                            <option value="1">Effect 1</option>
                                            <option value="2">Effect 2</option>
                                            <option value="3">Effect 3</option>
                                            <option value="4">Effect 4</option>
                                            <option value="5">Effect 5</option>
                                            <option value="6">Effect 6</option>
                                            <option value="7">Effect 7</option>
                                            <option value="8">Effect 8</option>
                                            <option value="9" selected="selected">No Effect</option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="vertical-align: top" class="right">
                                    <input type="text" name="dynamicgrid_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="3" />
                                </td>
                                <td style="vertical-align: top" class="left">
                                    <select name="dynamicgrid_module[<?php echo $module_row; ?>][layout_id]" id="dynamicgrid_module_layout_<?php echo $module_row; ?>">
                                        <?php $limitfilter = ''; 
                                        foreach ($layouts as $layout) { 
                                            if ($layout['layout_id'] == $module['layout_id']) { ?>
                                                <option limitfilter="<?php echo $layout['filter']; ?>" id="dynamicgrid_module_layout_<?php echo $module_row; ?>_option_<?php echo $layout['layout_id']; ?>" value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                                <?php $limitfilter = $layout['filter']; ?>
                                            <?php } else { ?>
                                                <option limitfilter="<?php echo $layout['filter']; ?>" id="dynamicgrid_module_layout_<?php echo $module_row; ?>_option_<?php echo $layout['layout_id']; ?>" value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                        
                                    <div id="limitproduct_<?php echo $module_row; ?>" <?php echo ($limitfilter!='product') ? 'style="display:none;"' : ''; ?> >
                                        <br />
                                        <b><?php echo $entry_manufacturer; ?></b>
                                        <br />
                                        <div class="help">
                                            <?php echo $entry_limit_help; ?>
                                        </div>
                                        <br/>
                                        <div class="scrollbox">
                                            <?php $class = 'odd'; 
                                            foreach ($manufacturers as $manufacturer) { 
                                                $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                                <div class="<?php echo $class; ?>">
                                                    <?php if (isset($module['limitproduct_manufacturer']) and in_array($manufacturer['manufacturer_id'], $module['limitproduct_manufacturer'] )) { ?>
                                                    <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitproduct_manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                                                    <?php echo $manufacturer['name']; 
                                                    } else { ?>
                                                    <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitproduct_manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                                                    <?php echo $manufacturer['name']; 
                                                    } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <br />
                                        <b><span style="color:red">AND</span><br/>&nbsp;<br /><?php echo $entry_category; ?></b>
                                        <br />
                                        <div class="help">
                                            <?php echo $entry_limit_help; ?>
                                        </div>
                                        <br/>
                                        <div class="scrollbox">
                                            <?php $class = 'odd'; 
                                            foreach ($categories as $category) {
                                                $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                                <div class="<?php echo $class; ?>">
                                                    <?php if (isset($module['limitproduct_category']) and in_array($category['category_id'], $module['limitproduct_category'] )) { ?>
                                                    <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitproduct_category][]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                                                    <?php echo $category['name']; 
                                                    } else { ?>
                                                    <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitproduct_category][]" value="<?php echo $category['category_id']; ?>" />
                                                    <?php echo $category['name']; 
                                                    } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
        
                                    <div id="limitmanufacturer_<?php echo $module_row; ?>" <?php echo ($limitfilter!='manufacturer') ? 'style="display:none;"' : ''; ?> >
                                        <br /><b><?php echo $entry_manufacturer; ?></b><br />
                                        <div class="help">
                                            <?php echo $entry_limit_help; ?>
                                        </div>
                                        <br/>
                                        <div class="scrollbox">
                                            <?php $class = 'odd'; 
                                            foreach ($manufacturers as $manufacturer) { 
                                            $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                                <div class="<?php echo $class; ?>">
                                                    <?php if (isset($module['limitmanufacturer']) and in_array($manufacturer['manufacturer_id'], $module['limitmanufacturer'] )) { ?>
                                                        <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitmanufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                                                        <?php echo $manufacturer['name']; 
                                                    } else { ?>
                                                        <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitmanufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                                                        <?php echo $manufacturer['name']; 
                                                    } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
        
                                    <div id="limitcategory_<?php echo $module_row; ?>" <?php echo ($limitfilter!='category') ? 'style="display:none;"' : ''; ?> >
                                        <br /><b><?php echo $entry_category; ?></b><br /><div class="help"><?php echo $entry_limit_help; ?></div><br/>
                                        <div class="scrollbox">
                                            <?php $class = 'odd'; 
                                            foreach ($categories as $category) { 
                                                $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                                <div class="<?php echo $class; ?>">
                                                    <?php if (isset($module['limitcategory']) and in_array($category['category_id'], $module['limitcategory'] )) { ?>
                                                    <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitcategory][]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                                                    <?php echo $category['name']; 
                                                    } else { ?>
                                                    <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitcategory][]" value="<?php echo $category['category_id']; ?>" />
                                                    <?php echo $category['name']; 
                                                    } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                                <td style="vertical-align: top" class="left">
                                    <select name="dynamicgrid_module[<?php echo $module_row; ?>][position]">
                                        <?php if ($module['position'] == 'content_top') { ?>
                                            <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                                        <?php } else { ?>
                                            <option value="content_top"><?php echo $text_content_top; ?></option>
                                        <?php }
                                        if ($module['position'] == 'content_bottom') { ?>
                                            <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                                        <?php } else { ?>
                                            <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                                        <?php }
                                        if ($module['position'] == 'column_left') { ?>
                                            <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                                        <?php } else { ?>
                                            <option value="column_left"><?php echo $text_column_left; ?></option>
                                        <?php } 
                                        if ($module['position'] == 'column_right') { ?>
                                            <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                                        <?php } else { ?>
                                            <option value="column_right"><?php echo $text_column_right; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="vertical-align: top" class="left">
                                    <select name="dynamicgrid_module[<?php echo $module_row; ?>][status]">
                                        <?php if ($module['status']) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                            <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                    <br /><br />
                                    <?php echo $text_period; ?>
                                    <input type="text" class="datetime" size="12" value="<?php echo (isset($module['date_start'])) ? $module['date_start'] : ''; ?>" name="dynamicgrid_module[<?php echo $module_row; ?>][date_start]"/> to <input type="text" class="datetime" size="12" value="<?php echo (isset($module['date_end'])) ? $module['date_end'] : ''; ?>" name="dynamicgrid_module[<?php echo $module_row; ?>][date_end]"/>
                                </td>
                                <td style="vertical-align: top" class="right">
                                    <input type="text" name="dynamicgrid_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
                                </td>
                                <td style="vertical-align: top" class="left">
                                    <a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a>
                                </td>
                            </tr>
                        </tbody>
                        <?php $module_row++; 
                    } ?>
                    <tfoot>
                        <tr>
                            <td colspan="9" class="right">
                            	<a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript"><!--
<?php for($i=0; $i<$module_row; $i++) { ?>

$('input[name=\'product_<?php echo $i; ?>\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#dynamicgrid-product-<?php echo $i; ?>-' + ui.item.value).remove();
		
		$('#dynamicgrid-product-<?php echo $i; ?>').append('<div id="dynamicgrid-product-<?php echo $i; ?>-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" value="' + ui.item.value + '" /></div>');

		$('#dynamicgrid-product-<?php echo $i; ?> div:odd').attr('class', 'odd');
		$('#dynamicgrid-product-<?php echo $i; ?> div:even').attr('class', 'even');
		
		data = $.map($('#dynamicgrid-product-<?php echo $i; ?> input'), function(element){
			return $(element).attr('value');
		});
						
		$('input[name=\'dynamicgrid_module[<?php echo $i; ?>][products]\']').attr('value', data.join());
					
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#dynamicgrid-product-<?php echo $i; ?> div img').live('click', function() {
	$(this).parent().remove();
	
	$('#dynamicgrid-product-<?php echo $i; ?> div:odd').attr('class', 'odd');
	$('#dynamicgrid-product-<?php echo $i; ?> div:even').attr('class', 'even');

	data = $.map($('#dynamicgrid-product-<?php echo $i; ?> input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'dynamicgrid_module[<?php echo $i; ?>][products]\']').attr('value', data.join());
});



$('#dynamicgrid_module_layout_<?php echo $i; ?>').change( function() {
    document.getElementById('limitcategory_<?php echo $i; ?>').style.display = 'none';    
    document.getElementById('limitproduct_<?php echo $i; ?>').style.display = 'none';    
    document.getElementById('limitmanufacturer_<?php echo $i; ?>').style.display = 'none';    

	var filter = $('#dynamicgrid_module_layout_<?php echo $i; ?>_option_'+$('#dynamicgrid_module_layout_<?php echo $i; ?>').attr('value')).attr('limitfilter');
    if (filter!='')
        document.getElementById('limit'+filter+'_<?php echo $i; ?>').style.display = '';    
});
<?php } ?>
//--></script> 

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"> 
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'hh:mm'
});
</script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left" style="vertical-align: top">';
	html += '<?php echo $entry_code; ?> <input type="text" name="dynamicgrid_module['+module_row+'][code]" value="" /><br/>&nbsp;<br/>'
	html += '<?php echo $entry_titlelink ?> <input type="text" name="dynamicgrid_module['+module_row+'][titlelink]" value="" /><br/>&nbsp;<br/>';
          <?php foreach ($languages as $language) { ?>
	html += '<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name'] . ' ' . $entry_title; ?> <input type="text" name="dynamicgrid_module['+module_row+'][title][<?php echo $language['language_id']; ?>]" value="" /><br/>';
          <?php } ?>
	html += '</td>';
	html += '<td style="vertical-align: top">';
    html += '    <br/><b><?php echo $entry_category; ?></b>:';
    html += '<div class="scrollbox">';
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  	<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html += 	'<div class="<?php echo $class; ?>"><input type="checkbox" name="dynamicgrid_module['+module_row+'][category][]" value="<?php echo $category['category_id']; ?>" /><?php echo addslashes($category['name']); ?></div>';
                  <?php } ?>
    html += '</div><a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
	html += '<br/>'
    html += '    <br/><b><?php echo $entry_products; ?>:</b>';
	html += '		<div style="padding-bottom: 4px;"><?php echo $entry_product; ?> <input type="text" name="product_'+module_row+'"/><br/></div>';
	html += '		<div id="dynamicgrid-product-'+module_row+'" class="scrollbox"></div>';
    html += '    <br/>&nbsp;<br/><b><?php echo $entry_latest_text;   ?>:</b> <input size="3" type="text" name="dynamicgrid_module['+module_row+'][latest]" value="0"/>';
    html += '	 <br/>&nbsp;<br/><b><?php echo $entry_specials_text; ?>:</b> <input size="3" type="text" name="dynamicgrid_module['+module_row+'][specials]" value="0"/>';
	html += '    <input type="hidden" name="dynamicgrid_module[' + module_row + '][products]" value="" />';
	
	html += '	  <hr/>';
	html += '		  <b><?php echo $entry_sort_order; ?></b>';
	html += ' 		<select name="dynamicgrid_module['+module_row+'][sortfield]"><option value="">[no sort]</option>';
	                <?php foreach ($prodfields as $f) { ?>
	html += '         <option value="<?php echo $f; ?>"><?php echo $f; ?></option>';
	                <?php } ?>
	html += '       </select>';
	html += '</td>'; 	
	html += '    <td class="left" style="vertical-align: top"><select name="dynamicgrid_module['+module_row+'][effect]">';
	html += '      <option value="1">Effect 1</option>';
	html += '      <option value="2">Effect 2</option>';
	html += '      <option value="3">Effect 3</option>';
	html += '      <option value="4">Effect 4</option>';
	html += '      <option value="5">Effect 5</option>';
	html += '      <option value="6">Effect 6</option>';
	html += '      <option value="7">Effect 7</option>';
	html += '      <option value="8">Effect 8</option>';
	html += '      <option value="9">No Effect</option>';
	html += '    </select></td>';	
	html += '<td class="right" style="vertical-align: top"><input type="text" name="dynamicgrid_module['+module_row+'][limit]" value="8" size="3" /></td>';
	html += '    <td class="left" style="vertical-align: top"><select name="dynamicgrid_module[' + module_row + '][layout_id]" id="dynamicgrid_module_layout_'+module_row+'">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option limitfilter="<?php echo $layout['filter']; ?>" id="dynamicgrid_module_layout_'+module_row+'_option_<?php echo $layout['layout_id']; ?>"  value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select>';



	
    html += '<div id="limitproduct_'+ module_row +'" style="display:none;"><br/><b><?php echo $entry_product; ?></b><br /><div class="help"><?php echo $entry_limit_help; ?></div><br/>';
	html += '	<div class="scrollbox">';
				      <?php $class = 'odd'; ?>
	                  <?php foreach ($manufacturers as $manufacturer) { ?>
	                  	  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
	html += '	          <div class="<?php echo $class; ?>">';
	html += '	           <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitproduct_manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" /><?php echo addslashes($manufacturer['name']); ?>';
	html += '	         </div>';
	                  <?php } ?>
	html += '		</div>';
    html += '	<br/><b><span style="color:red">AND</span><br/>&nbsp;<br/><?php echo $entry_category; ?></b><br /><div class="help"><?php echo $entry_limit_help; ?></div><br/>';
	html += '   <div class="scrollbox">';
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
    				<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html += '     <div class="<?php echo $class; ?>">';
    html += '       <input type="checkbox" name="dynamicgrid_module['+module_row+'][limitproduct_category][]" value="<?php echo $category['category_id']; ?>" /><?php echo addslashes($category['name']); ?>';
    html += '     </div>';
                  <?php } ?>
    html += '   </div>';
    html += '</div>';


	
	
    html += '<div id="limitmanufacturer_'+ module_row +'" style="display:none;"><br/><b><?php echo $entry_manufacturer; ?></b><br /><div class="help"><?php echo $entry_limit_help; ?></div><br/>';
	html += '	<div class="scrollbox">';
				      <?php $class = 'odd'; ?>
	                  <?php foreach ($manufacturers as $manufacturer) { ?>
	                  	  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
	html += '	          <div class="<?php echo $class; ?>">';
	html += '	           <input type="checkbox" name="dynamicgrid_module[<?php echo $module_row; ?>][limitmanufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" /><?php echo addslashes($manufacturer['name']); ?>';
	html += '	         </div>';
	                  <?php } ?>
	html += '		</div>';
	html += '</div>';
	
    html += '<div id="limitcategory_'+ module_row +'" style="display:none;"><br/><b><?php echo $entry_category; ?></b><br /><div class="help"><?php echo $entry_limit_help; ?></div><br/>';
	html += '   <div class="scrollbox">';
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
    				<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html += '     <div class="<?php echo $class; ?>">';
    html += '       <input type="checkbox" name="dynamicgrid_module['+module_row+'][limitcategory][]" value="<?php echo $category['category_id']; ?>" /><?php echo addslashes($category['name']); ?>';
    html += '     </div>';
                  <?php } ?>
    html += '   </div>';
    html += '</div>';
	
	
	
	html += '    </td>';
	html += '    <td class="left" style="vertical-align: top"><select name="dynamicgrid_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left" style="vertical-align: top"><select name="dynamicgrid_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select>';
	
    html += '	<br /><br /><?php echo $text_period; ?>';
    html += '	<input type="text" class="datetime" size="12" value="" name="dynamicgrid_module['+ module_row +'][date_start]"/> to <input type="text" class="datetime" size="12" value="" name="dynamicgrid_module[' + module_row + '][date_end]"/>';
	
    html += '</td>';
	html += '    <td class="right" style="vertical-align: top"><input type="text" name="dynamicgrid_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left" style="vertical-align: top"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);

	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm'
	});


$('#dynamicgrid_module_layout_'+module_row).change( function() {
	var mod_row = this.id.toString();
	mod_row = parseInt(mod_row.substr(22,10));
    document.getElementById('limitcategory_'+mod_row).style.display = 'none';    
    document.getElementById('limitproduct_'+mod_row).style.display = 'none';    
    document.getElementById('limitmanufacturer_'+mod_row).style.display = 'none';    

	var filter = $('#dynamicgrid_module_layout_'+mod_row+'_option_'+$('#dynamicgrid_module_layout_'+mod_row).attr('value')).attr('limitfilter');
    if (filter!='')
        document.getElementById('limit'+filter+'_'+mod_row).style.display = '';    
});


$('input[name=\'product_'+module_row+'\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		var name = this.name.toString();
		var module_row = name.substr(name.indexOf('_')+1,10);
		$('#dynamicgrid-product-'+module_row +'-'+ui.item.value).remove();

		$('#dynamicgrid-product-'+module_row).append('<div id="dynamicgrid-product-'+module_row + '-'+ ui.item.value + '">' + ui.item.label + '<img id="deleteImage_'+module_row+'" src="view/image/delete.png" /><input type="hidden" value="' + ui.item.value + '" /></div>');

		$('#dynamicgrid-product-'+module_row+' div:odd').attr('class', 'odd');
		$('#dynamicgrid-product-'+module_row+' div:even').attr('class', 'even');
		
		data = $.map($('#dynamicgrid-product-'+module_row+' input'), function(element){
			return $(element).attr('value');
		});
						
		$('input[name=\'dynamicgrid_module['+module_row+'][products]\']').attr('value', data.join());
					
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#dynamicgrid-product-'+module_row+' div img').live('click', function() {
	var id = this.id.toString();
	var module_row = name.substr(name.indexOf('_')+1,10);
	$(this).parent().remove();
	
	$('#dynamicgrid-product-'+module_row+' div:odd').attr('class', 'odd');
	$('#dynamicgrid-product-'+module_row+' div:even').attr('class', 'even');

	data = $.map($('#dynamicgrid-product-'+module_row+' input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'dynamicgrid_module['+module_row+'][products]\']').attr('value', data.join());
});

	module_row++;
}
//--></script> 
<?php echo $footer; ?>