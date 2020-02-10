<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<?php if(isset($success)) { ?>
	<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/module.png" alt=""/> <?php echo $heading_title; ?></h1>

			<div class="buttons"><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<input type="hidden" name="action" id="action"/>
				<textarea style="width:100%" rows="14" cols="40" name="sql_query"><?php echo $sql_query; ?></textarea>

				<div class="buttons" style="float:right">
					<a onclick="$('#action').val('execute'); $('#form').submit();" class="button"><?php echo $button_execute; ?></a>
					<a onclick="$('#action').val('export'); $('#form').submit();" class="button"><?php echo $button_export; ?></a>
				</div>
			</form>

			<br/>
			<br/>
			<?php if($queries) { ?>
			<table>
				<?php foreach($queries as $i => $query) { ?>
				<tr>
					<td><?php echo $query?></td>
					<td><a href="<?php echo $query_href . $i . "&action=execute"; ?>">execute</a></td>
				</tr>
				<?php } ?>
			</table>
			<?php }?>
			<br/>
			<br/>
			<?php if(isset($result)) { ?>
			<table class="list">
				<tr>
					<?php foreach($cols as $col) { ?>
					<th><?php echo $col; ?></th>
					<?php } ?>
				</tr>
				<?php foreach($result as $row) { ?>
				<tr>
					<?php foreach($row as $cell) { ?>
					<td><?php echo $cell; ?></td>
					<?php } ?>
				</tr>
				<?php }?>
			</table>

			<?php }?>
		</div>
	</div>
<?php echo $footer; ?>