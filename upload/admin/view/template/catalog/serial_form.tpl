<?php echo $header; ?>

<!-- START CONTENT -->
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
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>&nbsp;<a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
		</div>
		<div class="content">
		
			<!-- START FORM -->
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<table class="form">
					<tr>
						<td>
							<span class="required">*</span> <?php echo $entry_product; ?>
<?php if($error_product): ?>
							<span class="error"><?php echo $error_product; ?></span>
<?php endif; ?>
						</td>
						<td>
							<select id="product_id" name="product_id">
								<option value="0"> <?php echo $text_select; ?></option>
<?php foreach($products as $product) : ?>
								<option value="<?php echo $product['product_id']?>"<?php if($selected && $selected == $product['product_id']) echo ' selected="selected"'; ?>><?php echo $product['name']?></option>
<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_keys; ?>
<?php if($error_keys): ?>
							<span class="error"><?php echo $error_keys; ?></span>
<?php endif; ?></td>
						<td><textarea id="serials" name="serials" cols="100" rows="10"><?php echo $text; ?></textarea></td>
					</tr>
					<tr>
						<td><?php echo $entry_file; ?></td>
						<td><input type="file" name="csv" /></td>
					</tr>
				</table>
			</form>
			<!-- END FORM -->
		</div>
	<div class="box_2">
	<div class="heading_2">
 			<h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>&nbsp;<a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
 	</div>
	</div>
</div>
<!-- END CONTENT -->

<?php echo $footer; ?>