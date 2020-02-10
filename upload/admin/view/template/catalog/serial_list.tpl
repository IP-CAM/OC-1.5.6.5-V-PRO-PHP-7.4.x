<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb) { ?>
<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
<?php } ?>
	</div>
<?php if (!empty($error_warning)) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if (!empty($success)) { ?>
	<div class="success"><?php echo $success; ?></div>
<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_add; ?></span></a>
				<a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
				<a onclick="quickfind();" class="button"><span><?php echo $button_quickfind; ?></span></a>
			</div>
		</div>
		<div class="content">
			<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
				<table class="list">
					<thead>
						<tr>
							<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
							<td style="text-align:left;"><?php echo $column_product; ?></td>
							<td style="text-align:right;"><?php echo $column_keys; ?></td>
							<td style="text-align: center;"><?php echo $column_action; ?></td>
						</tr>
					</thead>
					<tbody>
<?php
if ($serials) { ?>
<?php foreach ($serials as $serial) { ?>
						<tr>
							<td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $serial['id']; ?>" /></td>
							<td style="text-align:left;"><?php echo $serial['name']; ?></td>
							<td style="text-align:right;"><?php echo $serial['text']; ?></td>
							<td style="text-align: center;"><a href="index.php?route=catalog/serial/edit&amp;id=<?php echo $serial['id']; ?>&amp;token=<?php echo $this->session->data['token']; ?>">[<?php echo $text_action; ?>]</a></td>
						</tr>
<?php } ?>
<?php } else { ?>
						<tr>
							<td style="text-align: center;" colspan="4"><?php echo $text_no_keys; ?></td>
						</tr>
<?php } ?>
					</tbody>
				</table>
			</form>
		</div>
<div class="box_2">
	<div class="heading_2">
 			<h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_add; ?></span></a>
				<a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
				<a onclick="quickfind();" class="button"><span><?php echo $button_quickfind; ?></span></a>
			</div>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
var looking = false;
function quickfind() {
	if(looking) return false;
	looking = true;
	
	var serial = prompt('Enter Serial (full or partial)', '');
	
	if(serial === null || serial.length == 0) {
		looking = false;
		return false;
	}
	
	$.getJSON(
		'index.php',
		{
			'route'		: 'catalog/serial/find',
			'serial'	: serial,
			'token'		: '<?php echo $this->session->data['token']; ?>'
		},
		function(data) {
			if(data.message.length > 0) {
				alert(data.message);
			} else {
				// console.log(data.redirect.replace(/&amp;/g, '&'));
				window.location = data.redirect.replace(/&amp;/g, '&');
			}
			looking = false;
		}
	)
}
--></script>
<?php echo $footer; ?>