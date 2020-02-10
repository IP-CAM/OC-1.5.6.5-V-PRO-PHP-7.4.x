<?php
//-----------------------------------------------------
// System Check for Opencart v1.5.6   					
// Created by villagedefrance                          		
// contact@villagedefrance.net           					
//-----------------------------------------------------
?>

<?php echo $header; ?>
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
		<div class="buttons">
			<a onclick="location = '<?php echo $refresh; ?>';" class="button"><?php echo $button_refresh; ?></a>
			<a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
		</div>
	</div>
	<div class="content">
		<?php if ($success_optimize) { ?>
			<div class="success"><?php echo $success_optimize; ?></div>
		<?php } ?>
		<?php if ($success_repair) { ?>
			<div class="success"><?php echo $success_repair; ?></div>
		<?php } ?>
		<form action="<?php echo $systemcheck; ?>" method="post" enctype="multipart/form-data" id="form" name="systemcheck">
		<?php if ($output != '') { ?>
			<h2><?php echo $text_output; ?></h2>
			<div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
				<table width="100%">
					<tr>
						<td><?php echo $output; ?></td>
					</tr>
				</table>
			</div>
		<?php } ?>
		<div id="tabs" class="htabs">
			<a href="#tab-1"><span><?php echo $tab_info; ?></span></a>
			<a href="#tab-2"><span><?php echo $tab_system; ?></span></a>
			<a href="#tab-3"><span><?php echo $tab_maintenance; ?></span></a>
		</div>
		<div id="tab-1" style="clear: both;">
			<h2><?php echo $text_storeinfo; ?></h2>
			<table class="form">
				<tr>
					<td><?php echo $text_system; ?></td>
					<td><?php echo $text_opencart; ?></td>
				</tr>
				<tr>
					<td><?php echo $text_theme; ?></td>
					<td>
						<?php foreach ($templates as $template) { ?>
							<?php if ($template == $config_template) { ?>
								<span style='color: #225599;'><b><?php echo $template; ?></b></span> 
							<?php } ?>
						<?php } ?>
					</td>
				</tr>
			</table>
			<h2><?php echo $text_serverinfo; ?></h2>
			<div style="background: #F7F7F7; border: 1px solid #DDD; padding: 10px; margin-bottom: 15px;">
			<table width="100%">
				<tr>
					<th width="35%" align="left"><?php echo $column_php; ?></th>
					<th width="25%" align="left"><?php echo $column_current; ?></th>
					<th width="25%" align="left"><?php echo $column_required; ?></th>
					<th width="15%" align="left"><?php echo $column_status; ?></th>
				</tr>
				<tr>
					<td><?php echo $text_phpversion; ?></td>
					<td><?php echo phpversion(); ?></td>
					<td>5.0+</td>
					<td align="left"><?php echo (phpversion() >= '5.0') ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
				<tr>
					<td><?php echo $text_registerglobals; ?></td>
					<td><?php echo (ini_get('register_globals')) ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_off; ?></td>
					<td align="left"><?php echo (!ini_get('register_globals')) ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
				<tr>
					<td><?php echo $text_magicquotes; ?></td>
					<td><?php echo (ini_get('magic_quotes_gpc')) ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_off; ?></td>
					<td align="left"><?php echo (!ini_get('magic_quotes_gpc')) ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>        
				<tr>
					<td><?php echo $text_fileuploads; ?></td>
					<td><?php echo (ini_get('file_uploads')) ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_on; ?></td>
					<td align="left"><?php echo (ini_get('file_uploads')) ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
				<tr>
					<td><?php echo $text_autostart; ?></td>
					<td><?php echo (ini_get('session_auto_start')) ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_off; ?></td>
					<td align="left"><?php echo (!ini_get('session_auto_start')) ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
			</table>
			</div>
			<div style="background: #F7F7F7; border: 1px solid #DDD; padding: 10px; margin-bottom: 15px;">
			<table width="100%">
				<tr>
					<th width="35%" align="left"><?php echo $column_extension; ?></th>
					<th width="25%" align="left"><?php echo $column_current; ?></th>
					<th width="25%" align="left"><?php echo $column_required; ?></th>
					<th width="15%" align="left"><?php echo $column_status; ?></th>
				</tr>
				<tr>
					<td><?php echo $text_mysqli; ?></td>
					<td><?php echo extension_loaded('mysqli') ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_on; ?></td>
					<td align="left"><?php echo extension_loaded('mysqli') ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
				<tr>
					<td><?php echo $text_gd; ?></td>
					<td><?php echo extension_loaded('gd') ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_on; ?></td>
					<td align="left"><?php echo extension_loaded('gd') ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
				<tr>
					<td><?php echo $text_curl; ?></td>
					<td><?php echo extension_loaded('curl') ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_on; ?></td>
					<td align="left"><?php echo extension_loaded('curl') ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
				<tr>
					<td><?php echo $text_mcrypt; ?></td>
					<td><?php echo function_exists('mcrypt_encrypt') ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_on; ?></td>
					<td align="left"><?php echo function_exists('mcrypt_encrypt') ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>          
				<tr>
					<td><?php echo $text_zlib; ?></td>
					<td><?php echo extension_loaded('zlib') ? 'On' : 'Off'; ?></td>
					<td><?php echo $text_on; ?></td>
					<td align="left"><?php echo extension_loaded('zlib') ? '<img src="view/image/good.png" alt="Good" />' : '<img src="view/image/bad.png" alt="Bad" />'; ?></td>
				</tr>
			</table>
			</div>
			<div style="background: #F7F7F7; border: 1px solid #DDD; padding: 10px; margin-bottom: 15px;">
			<table width="100%">
				<tr>
					<th width="85%" align="left"><?php echo $column_directories; ?></th>
					<th width="15%" align="left"><?php echo $column_status; ?></th>
				</tr>
				<tr>
					<td><?php echo $cache . '/'; ?></td>
					<td><?php echo is_writable($cache) ? '<span style="color:#38BC00;">Writable</span>' : '<span style="color:#880033;">Not Writable</span>'; ?></td>
				</tr>
				<tr>
					<td><?php echo $logs . '/'; ?></td>
					<td><?php echo is_writable($logs) ? '<span style="color:#38BC00;">Writable</span>' : '<span style="color:#880033;">Not Writable</span>'; ?></td>
				</tr>
				<tr>
					<td><?php echo $image_cache . '/'; ?></td>
					<td><?php echo is_writable($image_cache) ? '<span style="color:#38BC00;">Writable</span>' : '<span style="color:#880033;">Not Writable</span>'; ?></td>
				</tr>
				<tr>
					<td><?php echo $image_data . '/'; ?></td>
					<td><?php echo is_writable($image_data) ? '<span style="color:#38BC00;">Writable</span>' : '<span style="color:#880033;">Not Writable</span>'; ?></td>
				</tr>
			</table>
			</div>
		</div><!-- Server -->
		<div id="tab-2" style="clear: both;">
			<h2><?php echo $text_systeminfo; ?></h2>
			<div style="background: #F7F7F7; border: 1px solid #DDD; padding: 10px; margin-bottom: 15px;">
			<table width="100%">
				<tr>
					<th width="85%" align="left"><?php echo $column_database_files; ?></th>
					<th width="15%" align="left"><?php echo $column_status; ?></th>
				</tr>
				<?php foreach ($databases as $database) { ?>
				<?php if ($oc_version == '1.5.4') { ?>
					<?php if ($database == $url_mysqli) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $database; ?></td>
							<td width="15%" align="left"><?php echo $text_present; ?></td>
						</tr>
					<?php } else if ($url_mysqli) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $database; ?></td>
							<td width="15%" align="left"><?php echo $text_missing; ?></td>
						</tr>
					<?php } else { ?>
						<tr>
							<td width="85%" align="left"><?php echo $database; ?></td>
							<td width="15%" align="left"><?php echo $text_unknown; ?></td>
						</tr>
					<?php } ?>
				<?php } else if ($oc_version == '1.5.5' || $oc_version == '1.5.6') { ?>
					<?php if ($database == $url_mysqli) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $database; ?></td>
							<td width="15%" align="left"><?php echo $text_present; ?></td>
						</tr>
					<?php } else if (!$url_mysqli) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $database; ?></td>
							<td width="15%" align="left"><?php echo $text_missing; ?></td>
						</tr>
					<?php } else { ?>
						<tr>
							<td width="85%" align="left"><?php echo $database; ?></td>
							<td width="15%" align="left"><?php echo $text_unknown; ?></td>
						</tr>
					<?php } ?>
				<?php } else { ?>
					<tr>
						<td width="85%" align="left"><?php echo $text_no_version; ?></td>
						<td width="15%" align="left"></td>
					</tr>
				<?php } ?>
				<?php } ?>
			</table>
			</div>
			<div style="background: #F7F7F7; border: 1px solid #DDD; padding: 10px; margin-bottom: 15px;">
			<table width="100%">
				<tr>
					<th width="85%" align="left"><?php echo $column_engine_files; ?></th>
					<th width="15%" align="left"><?php echo $column_status; ?></th>
				</tr>
				<?php foreach ($engines as $engine) { ?>
					<?php if ($engine == $url_action || $engine == $url_controller || $engine == $url_front || $engine == $url_loader || $engine == $url_model || $engine == $url_registry) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $engine; ?></td>
							<td width="15%" align="left"><?php echo $text_present; ?></td>
						</tr>
					<?php } else if (!$url_action || !$url_controller || !$url_front || !$url_loader || !$url_model || !$url_registry) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $engine; ?></td>
							<td width="15%" align="left"><?php echo $text_missing; ?></td>
						</tr>
					<?php } else { ?>
						<tr>
							<td width="85%" align="left"><?php echo $engine; ?></td>
							<td width="15%" align="left"><?php echo $text_unknown; ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</table>
			</div>
			<div style="background: #F7F7F7; border: 1px solid #DDD; padding: 10px; margin-bottom: 15px;">
			<table width="100%">
				<tr>
					<th width="85%" align="left"><?php echo $column_helper_files; ?></th>
					<th width="15%" align="left"><?php echo $column_status; ?></th>
				</tr>
				<?php foreach ($helpers as $helper) { ?>
					<?php if ($helper == $url_csv_helper || $helper == $url_json || $helper == $url_utf8 || $helper == $url_vat) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $helper; ?></td>
							<td width="15%" align="left"><?php echo $text_present; ?></td>
						</tr>
					<?php } else if (!$url_json || !$url_utf8 || !$url_vat) { ?>
						<tr>
							<td width="85%" align="left"><?php echo $helper; ?></td>
							<td width="15%" align="left"><?php echo $text_missing; ?></td>
						</tr>
					<?php } else { ?>
						<tr>
							<td width="85%" align="left"><?php echo $helper; ?></td>
							<td width="15%" align="left"><?php echo $text_unknown; ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</table>
			</div>
			<div style="background: #F7F7F7; border: 1px solid #DDD; padding: 10px; margin-bottom: 15px;">
			<table width="100%">
				<tr>
					<th width="60%" align="left"><?php echo $column_library_files; ?></th>
					<th width="25%" align="left"><?php echo $column_library_names; ?></th>
					<th width="15%" align="left"><?php echo $column_status; ?></th>
				</tr>
				<?php if ($core_version == '1.5.4' || $core_version == '1.5.5' || $core_version == '1.5.6') { ?>
					<?php foreach ($libraries as $library) { ?>
					<tr>
						<td width="60%" align="left"><?php echo $library; ?></td>
						<?php foreach ($library_files as $library_file) { ?>
							<?php if ($library == $library_file['url']) { ?>
								<td width="25%" align="left"><?php echo $library_file['name']; ?></td>
								<td width="15%" align="left"><?php echo $text_present; ?></td>
							<?php } ?>
						<?php } ?>
					</tr>
					<?php } ?>
				<?php } else { ?>
					<tr>
						<td width="60%" align="left"><?php echo $text_no_version; ?></td>
						<td width="25%" align="left"></td>
						<td width="15%" align="left"></td>
					</tr>
				<?php } ?>
			</table>
			</div>
		</div><!-- System -->
		<div id="tab-3" style="clear: both;">
			<h2><?php echo $text_optimize; ?></h2>
			<div>
				<table class="form">
					<tr style="text-align:left;">
						<td width="20%"><b><?php echo $text_optimize; ?></b></td>
						<td width="55%"><?php echo $text_help_optimize; ?></td>
						<td width="25%">
							<a onclick="Optimize();" class="button"><?php echo $button_optimize; ?></a>
						</td>
					</tr>
				</table>
			</div>
			<h2><?php echo $text_repair; ?></h2>
			<div>
				<table class="form">
					<tr style="text-align:left;">
						<td width="20%"><b><?php echo $text_repair; ?></b></td>
						<td width="55%"><?php echo $text_help_repair; ?></td>
						<td width="25%">
							<a onclick="Repair();" class="button"><?php echo $button_repair; ?></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="tab-4" style="clear: both;">
			<h2><?php echo $text_supportinfo; ?></h2>
			<div class="versioncheck">
				<table class="form">
					<tr>
						<td></td>
						<td colspan="2"><?php echo $module_name; ?><b><?php echo $module_current_name; ?></b></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2"><?php echo $module_list; ?>
						<?php foreach ($compatibles as $compatible) { ?>
							<?php if($store_base_version == $compatible['opencart']) { ?>
								<b><?php echo $compatible['title']; ?></b>
							<?php } else { ?>
								<?php echo $compatible['title']; ?>
							<?php } ?>
						<?php } ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2"><?php echo $store_version; ?>
						&nbsp;&nbsp;&nbsp;
						<?php foreach ($compatibles as $compatible) { ?>
							<?php if($store_base_version == $compatible['opencart']) { ?>
								<img src="view/image/success.png" alt="" />
							<?php } ?>
						<?php } ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2"><?php echo $text_template; ?>
							<?php foreach ($templates as $template) { ?>
								<?php if ($template == $config_template) { ?>
									<b><?php echo $template; ?></b>
								<?php } ?>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">
			&nbsp;
						</td>
					</tr>
					
				</table>
			</div>
			<table class="form">
			</table>
		</div>
		<input type="hidden" name="buttonForm" value="" />
		</form>
	</div>
		<br />
		<div style="text-align:center; color:#555;">System Check v<?php echo $systemcheck_version; ?></div>
	</div>
</div>

<script type="text/javascript"><!--
function Optimize() {document.systemcheck.buttonForm.value='optimize'; $('#form').submit();}
function Repair() {document.systemcheck.buttonForm.value='repair'; $('#form').submit();}
//--></script>

<script type="text/javascript"><!--
$(function() { $('#tabs a').tabs(); });
//--></script>

<script type="text/javascript"><!--
$(document).ready(function(){	
	$('.versioncheck').hide().before('<a href="#" id="<?php echo 'versioncheck'; ?>" class="button" style="margin-bottom:10px;"><span><?php echo $button_showhide; ?></span></a>');
	$('a#<?php echo 'versioncheck'; ?>').click(function() {
		$('.versioncheck').slideToggle(1000);
		return false;
	});
});
//--></script>

<?php echo $footer; ?>