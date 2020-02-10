<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?><span class="close" style="float:right;cursor: pointer;">( x )</span></div>
	<?php } ?>
	<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?><span class="close" style="float:right;cursor: pointer;">( x )</span></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
		</div>
		<div class="content">
			<div id="tabs" class="htabs"><a href="#tab-export"><?php echo $tab_export; ?></a><a href="#tab-import"><?php echo $tab_import; ?></a><a href="#tab-settings"><?php echo $tab_settings; ?></a></div>
			<div id="tab-export">
				<form action="<?php echo $export; ?>" method="post" enctype="multipart/form-data" id="export">
					<table class="form">
						<tr>
							<td><?php echo $entry_export; ?></td>
						</tr>
						<tr>
							<td style="vertical-align:top;">
								<?php echo $entry_export_type; ?><br />
								<?php if ($export_type=='c') { ?>
								<input type="radio" name="export_type" value="c" checked="checked" />
								<?php } else { ?>
								<input type="radio" name="export_type" value="c" />
								<?php } ?>
								<?php echo $text_export_type_category; ?>
								<br />
								<?php if ($export_type=='p') { ?>
								<input type="radio" name="export_type" value="p" checked="checked" />
								<?php } else { ?>
								<input type="radio" name="export_type" value="p" />
								<?php } ?>
								<?php echo $text_export_type_product; ?>
								<br />
								<?php if ($export_type=='o') { ?>
								<input type="radio" name="export_type" value="o" checked="checked" />
								<?php } else { ?>
								<input type="radio" name="export_type" value="o" />
								<?php } ?>
								<?php echo $text_export_type_option; ?>
								<br />
								<?php if ($export_type=='a') { ?>
								<input type="radio" name="export_type" value="a" checked="checked" />
								<?php } else { ?>
								<input type="radio" name="export_type" value="a" />
								<?php } ?>
								<?php echo $text_export_type_attribute; ?>
								<br />
								<?php if ($exist_filter) { ?>
								<?php if ($export_type=='f') { ?>
								<input type="radio" name="export_type" value="f" checked="checked" />
								<?php } else { ?>
								<input type="radio" name="export_type" value="f" />
								<?php } ?>
								<?php echo $text_export_type_filter; ?>
								<br />
								<?php } ?>
								<?php if ($export_type=='u') { ?>
								<input type="radio" name="export_type" value="u" checked="checked" />
								<?php } else { ?>
								<input type="radio" name="export_type" value="u" />
								<?php } ?>
								<?php echo $text_export_type_customer; ?>
								<br />
							</td>
						</tr>

						<tr id="category_filter">
							<td style="vertical-align:top;">
								<?php echo $entry_category_filter; ?><span class="help"><?php echo $help_category_filter; ?></span><br />
								<input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" /><br /><br />
								<div id="categories" class="scrollbox">
									<?php $class = 'odd'; ?>
									<?php foreach ($categories as $category) { ?>
									<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
									<div id="category<?php echo $category['category_id']; ?>" class="<?php echo $class; ?>"><?php echo $category['name']; ?><img src="view/image/delete.png" alt="" />
										<input type="hidden" name="categories[]" value="<?php echo $category['category_id']; ?>" />
									</div>
									<?php } ?>
								</div>
							</td>
						</tr> 

						<tr id="range_type">
							<td style="vertical-align:top;"><?php echo $entry_range_type; ?><span class="help"><?php echo $help_range_type; ?></span><br />
								<input type="radio" name="range_type" value="id" id="range_type_id"><?php echo $button_export_id; ?> &nbsp;&nbsp;
								<input type="radio" name="range_type" value="page" id="range_type_page"><?php echo $button_export_page; ?>
								<br /><br />
								<span class="id"><?php echo $entry_start_id; ?></span>
								<span class="page"><?php echo $entry_start_index; ?></span>
								<br />
								<input type="text" name="min" value="<?php echo $min; ?>" />
								<br />
								<span class="id"><?php echo $entry_end_id; ?></span>
								<span class="page"><?php echo $entry_end_index; ?></span>
								<br />
								<input type="text" name="max" value="<?php echo $max; ?>" />
							</td>
						</tr>

						<tr>
							<td class="buttons"><a onclick="downloadData();" class="button"><span><?php echo $button_export; ?></span></a></td>
						</tr>
					</table>
				</form>
			</div>
			<div id="tab-import">
				<form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import">
					<table class="form">
						<tr>
							<td>
								<?php echo $entry_import; ?>
								<span class="help"><?php echo $help_import; ?></span>
								<span class="help"><?php echo $help_format; ?></span>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo $entry_incremental; ?><br />
								<?php if ($incremental) { ?>
								<input type="radio" name="incremental" value="1" checked="checked" />
								<?php echo $text_yes; ?> <?php echo $help_incremental_yes; ?>
								<br />
								<input type="radio" name="incremental" value="0" />
								<?php echo $text_no; ?> <?php echo $help_incremental_no; ?>
								<?php } else { ?>
								<input type="radio" name="incremental" value="1" />
								<?php echo $text_yes; ?> <?php echo $help_incremental_yes; ?>
								<br />
								<input type="radio" name="incremental" value="0" checked="checked" />
								<?php echo $text_no; ?> <?php echo $help_incremental_no; ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_upload; ?><br /><br /><input type="file" name="upload" id="upload" /></td>
						</tr>
						<tr>
							<td class="buttons"><a onclick="uploadData();" class="button"><span><?php echo $button_import; ?></span></a></td>
						</tr>
					</table>
				</form>
			</div>
			<div id="tab-settings">
				<form action="<?php echo $settings; ?>" method="post" enctype="multipart/form-data" id="settings">
					<table class="form">
						<tr>
							<td>
								<label>
								<?php if ($settings_use_option_id) { ?>
								<input type="checkbox" name="export_import_settings_use_option_id" value="1" checked="checked" /><?php echo $entry_settings_use_option_id; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_option_id" value="1" /><?php echo $entry_settings_use_option_id; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label>
								<?php if ($settings_use_option_value_id) { ?>
								<input type="checkbox" name="export_import_settings_use_option_value_id" value="1" checked="checked" /><?php echo $entry_settings_use_option_value_id; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_option_value_id" value="1" /><?php echo $entry_settings_use_option_value_id; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label>
								<?php if ($settings_use_attribute_group_id) { ?>
								<input type="checkbox" name="export_import_settings_use_attribute_group_id" value="1" checked="checked" /><?php echo $entry_settings_use_attribute_group_id; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_attribute_group_id" value="1" /><?php echo $entry_settings_use_attribute_group_id; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label>
								<?php if ($settings_use_attribute_id) { ?>
								<input type="checkbox" name="export_import_settings_use_attribute_id" value="1" checked="checked" /><?php echo $entry_settings_use_attribute_id; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_attribute_id" value="1" /><?php echo $entry_settings_use_attribute_id; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<?php if ($exist_filter) { ?>
						<tr>
							<td>
								<label>
								<?php if ($settings_use_filter_group_id) { ?>
								<input type="checkbox" name="export_import_settings_use_filter_group_id" value="1" checked="checked" /><?php echo $entry_settings_use_filter_group_id; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_filter_group_id" value="1" /><?php echo $entry_settings_use_filter_group_id; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label>
								<?php if ($settings_use_filter_id) { ?>
								<input type="checkbox" name="export_import_settings_use_filter_id" value="1" checked="checked" /><?php echo $entry_settings_use_filter_id; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_filter_id" value="1" /><?php echo $entry_settings_use_filter_id; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td>
								<label>
								<?php if ($settings_use_export_cache) { ?>
								<input type="checkbox" name="export_import_settings_use_export_cache" value="1" checked="checked" /><?php echo $entry_settings_use_export_cache; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_export_cache" value="1" /><?php echo $entry_settings_use_export_cache; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label>
								<?php if ($settings_use_import_cache) { ?>
								<input type="checkbox" name="export_import_settings_use_import_cache" value="1" checked="checked" /><?php echo $entry_settings_use_import_cache; ?>
								<?php } else { ?>
								<input type="checkbox" name="export_import_settings_use_import_cache" value="1" /><?php echo $entry_settings_use_import_cache; ?>
								<?php } ?>
								</label>
							</td>
						</tr>
						<tr>
							<td class="buttons"><a onclick="updateSettings();" class="button"><span><?php echo $button_settings; ?></span></a></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 

<script type="text/javascript"><!--

function getNotifications() {
	$('#export_import_notification').empty().html('<div id="export_import_loading"><img src="<?php echo HTTP_SERVER; ?>/view/image/loading.gif" /><?php echo $text_loading_notifications; ?></div>');
	setTimeout(
		function(){
			$.ajax({
				type: 'GET',
				url: 'index.php?route=tool/export_import/getNotifications&token=<?php echo $token; ?>',
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						$('#export_import_notification').empty().html(json['error']+' <span style="cursor:pointer;font-weight:bold;text-decoration:underline;float:right;" onclick="getNotifications();"><?php echo $text_retry; ?></span>');
					} else if (json['message']) {
						$('#export_import_notification').html(json['message']);
					} else {
						$('#export_import_notification').html('<?php echo $error_no_news; ?>');
					}
				},
				failure: function(){
					$('#export_import_notification').html('<?php echo $error_notifications; ?> <span style="cursor:pointer;font-weight:bold;text-decoration:underline;float:right;" onclick="getNotifications();"><?php echo $text_retry; ?></span>');
				},
				error: function() {
					$('#export_import_notification').html('<?php echo $error_notifications; ?> <span style="cursor:pointer;font-weight:bold;text-decoration:underline;float:right;" onclick="getNotifications();"><?php echo $text_retry; ?></span>');
				}
			});
		},
		500
	);
}

function check_category_filter(export_type) {
	if (export_type=='p') {
		$('#category_filter').show();
	} else {
		$('#category_filter').hide();
	}
}

function check_range_type(export_type) {
	if ((export_type=='p') || (export_type=='c') || (export_type=='u')) {
		$('#range_type').show();
		$('#range_type_id').prop('checked',true);
		$('#range_type_page').prop('checked',false);
		$('.id').show();
		$('.page').hide();
	} else {
		$('#range_type').hide();
	}
}

$(document).ready(function() {

	check_category_filter($('input[name=export_type]:checked').val());
	check_range_type($('input[name=export_type]:checked').val());

	$("#range_type_id").click(function() {
		$(".page").hide();
		$(".id").show();
	});

	$("#range_type_page").click(function() {
		$(".id").hide();
		$(".page").show();
	});

	$('input[name=export_type]').click(function() {
		check_category_filter($(this).val());
		check_range_type($(this).val());
	});

	$('span.close').click(function() {
		$(this).parent().remove();
	});

	$('.htabs > a').click(function() {
		$('#export_import_notification').remove();
	});

	getNotifications();
});

function checkFileSize(id) {
	// See also http://stackoverflow.com/questions/3717793/javascript-file-upload-size-validation for details
	var input, file, file_size;

	if (!window.FileReader) {
		// The file API isn't yet supported on user's browser
		return true;
	}

	input = document.getElementById(id);
	if (!input) {
		// couldn't find the file input element
		return true;
	}
	else if (!input.files) {
		// browser doesn't seem to support the `files` property of file inputs
		return true;
	}
	else if (!input.files[0]) {
		// no file has been selected for the upload
		alert( "<?php echo $error_select_file; ?>" );
		return false;
	}
	else {
		file = input.files[0];
		file_size = file.size;
		<?php if (!empty($post_max_size)) { ?>
		// check against PHP's post_max_size
		post_max_size = <?php echo $post_max_size; ?>;
		if (file_size > post_max_size) {
			alert( "<?php echo $error_post_max_size; ?>" );
			return false;
		}
		<?php } ?>
		<?php if (!empty($upload_max_filesize)) { ?>
		// check against PHP's upload_max_filesize
		upload_max_filesize = <?php echo $upload_max_filesize; ?>;
		if (file_size > upload_max_filesize) {
			alert( "<?php echo $error_upload_max_filesize; ?>" );
			return false;
		}
		<?php } ?>
		return true;
	}
}

function uploadData() {
	if (checkFileSize('upload')) {
		$('#import').submit();
	}
}

function isNumber(txt){ 
	var regExp=/^[\d]{1,}$/;
	return regExp.test(txt); 
}

count_product = <?php echo $count_product; ?>;

function updateCountProducts() {
	$.ajax({
		url: 'index.php?route=tool/export_import/getCountProduct&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data: $("input[name='categories[]']").serialize(),
		success: function(json) {
			if (json['count']) {
				count_product = json['count'];
			} else {
			}
			console.log("success: count_product='"+count_product+"'");
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function validateExportForm(id) {
	var export_type = $('input[name=export_type]:checked').val();
	if ((export_type!='c') && (export_type!='p') && (export_type!='u')) {
		return true;
	}

	var val = $("input[name=range_type]:checked").val();
	var min = $("input[name=min]").val();
	var max = $("input[name=max]").val();

	if ((min=='') && (max=='')) {
		return true;
	}

	if (!isNumber(min) || !isNumber(max)) {
		alert("<?php echo $error_param_not_number; ?>");
		return false;
	}

	var count_item;
	switch (export_type) {
		case 'p': count_item = count_product-1;  break;
		case 'c': count_item = <?php echo $count_category-1; ?>; break;
		default:  count_item = <?php echo $count_customer-1; ?>; break;
	}
	var batchNo = parseInt(count_item/parseInt(min))+1; // Maximum number of item-batches, namely, item number/min, and then rounded up (that is, integer plus 1)
	var minItemId;
	switch (export_type) {
		case 'p': minItemId = parseInt( <?php echo $min_product_id; ?> );  break;
		case 'c': minItemId = parseInt( <?php echo $min_category_id; ?> ); break;
		default:  minItemId = parseInt( <?php echo $min_customer_id; ?> ); break;
	
	}
	var maxItemId;
	switch (export_type) {
		case 'p': maxItemId = parseInt( <?php echo $max_product_id; ?> );  break;
		case 'c': maxItemId = parseInt( <?php echo $max_category_id; ?> ); break;
		default:  maxItemId = parseInt( <?php echo $max_customer_id; ?> ); break;
	
	}

	if (val=="page") {  // Min for the batch size, Max for the batch number
		if (parseInt(max) <= 0) {
			alert("<?php echo $error_batch_number; ?>");
			return false;
		}
		if (parseInt(max) > batchNo) {        
			alert("<?php echo $error_page_no_data; ?>"); 
			return false;
		} else {
			$("input[name=max]").val(parseInt(max)+1);
		}
	} else {
		if (minItemId <= 0) {
			alert("<?php echo $error_min_item_id; ?>");
			return false;
		}
		if (parseInt(min) > maxItemId || parseInt(max) < minItemId || parseInt(min) > parseInt(max)) {  
			alert("<?php echo $error_id_no_data; ?>"); 
			return false;
		}
	}
	return true;
}

function downloadData() {
	if (validateExportForm('export')) {
		$('#export').submit();
	}
}

function updateSettings() {
	$('#settings').submit();
}

// Category
$('input[name=\'category\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.category_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#categories' + ui.item.value).remove();
		
		$('#categories').append('<div id="categories' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="categories[]" value="' + ui.item.value + '" /></div>');

		$('#categories div:odd').attr('class', 'odd');
		$('#categories div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#categories div img').live('click', function() {
	$(this).parent().remove();
	updateCountProducts();
	$('#categories div:odd').attr('class', 'odd');
	$('#categories div:even').attr('class', 'even');	
});
//--></script>

<?php echo $footer; ?>