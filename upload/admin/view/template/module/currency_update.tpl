<?php echo $header ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<?php if ($error_success) { ?>
	<div class="success"><?php echo $error_success; ?></div>
	<?php } ?>
  <div class="box">
	<div class="heading">
		<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
		<div class="buttons">
			<a href="<?php echo $update; ?>" onClick="$(this).text('<?php echo $text_loading; ?>');" class="button"><?php echo $button_update; ?></a>
			<a onclick="$('#form-module').submit();" class="button"><?php echo $button_save; ?></a>
			<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
		</div>
	</div>
	<div class="content">
	  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
	  <table class="form">
		<tr>
			<td><?php echo $entry_autoupdate; ?></td>
			<td>
              <select name="module_currency_update_autoupdate">
                <option value="1"<?php echo $module_currency_update_autoupdate ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0"<?php echo $module_currency_update_autoupdate ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
              </select>
			</td>
		</tr>
		<tr>
			<td><?php echo $entry_comission; ?></td>
			<td>
				<input name="module_currency_update_comission" value="<?php echo $module_currency_update_comission; ?>" placeholder="<?php echo $help_comission; ?>" />
				<?php if ($error_comission) { ?>
                <span class="error"><?php echo $error_comission; ?></span>
                <?php } ?>
			</td>
		</tr>
		<tr>
			<td><?php echo $entry_source; ?></td>
			<td>
              <select name="module_currency_update_source" id="input-source" class="form-control">
                <option value="alphavantage.co"<?php echo $module_currency_update_source == 'alphavantage.co' ? ' selected="selected"' : ''; ?>><?php echo $text_source_alphavantage; ?></option>
               </select>
			</td>
		</tr>
		<tr class="optional" data-source="alphavantage.co"<?php echo $module_currency_update_source == 'alphavantage.co' ? '' : ' style="display:none;"'; ?>>
			<td><span class="required">*</span> <?php echo $entry_alphavantage_api_key; ?></td>
			<td>
				<input name="module_currency_update_alphavantage_api_key" value="<?php echo $module_currency_update_alphavantage_api_key; ?>" id="input-alphavantage-api-key" class="form-control" />
                <span><?php echo $text_alphavantage_api_key; ?></span>
				<?php if ($error_alphavantage_api_key) { ?>
                <span class="error"><?php echo $error_alphavantage_api_key; ?></span>
                <?php } ?>
			</td>
		</tr>
		<tr>
			<td><?php echo $entry_debug; ?></td>
			<td>
              <select name="module_currency_update_debug" id="input-debug" class="form-control">
                <option value="1"<?php echo $module_currency_update_debug ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0"<?php echo $module_currency_update_debug ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
              </select>
			</td>
		</tr>
		<tr>
			<td><?php echo $entry_status; ?></td>
			<td>
              <select name="module_currency_update_status" id="input-status" class="form-control">
                <option value="1"<?php echo $module_currency_update_status ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0"<?php echo $module_currency_update_status ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
              </select>
			</td>
		</tr>
	    </table>
	  </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$('select[name="module_currency_update_source"]').on('change', function() {
	var sel = $('option:selected', $(this)).val();
	$('.optional[data-source!="'+sel+'"]').hide();
	$('.optional[data-source="'+sel+'"]').show();
});
</script>
<?php echo $footer; ?>