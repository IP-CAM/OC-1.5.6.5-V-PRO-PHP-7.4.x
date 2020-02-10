<?php echo $header; ?>
<div id="content">
<div class="box" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
<div class="heading">
<h1><img src="view/image/lockscreen.png" alt="" /> <?php echo $heading_title; ?></h1>
</div>
<div class="content" style="min-height: 150px; overflow: hidden;">
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<table style="width: 100%;">
<tr>
<td style="text-align: center;" rowspan="4" colspan="2"><img src="view/image/login.png" alt="<?php echo $heading_title; ?>" /></td>
</tr>
<tr>
<td colspan="2"><?php echo $entry_code; ?><br />
<input type="text" name="code" value="" style="margin-top: 4px;" autocomplete="off" />
</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td style="text-align: left;"><a href="<?php echo $resend; ?>" class="button"><?php echo $button_resend; ?></a></td>
<td style="text-align: right;"><a onclick="$('#form').submit();" class="button"><?php echo $button_authenticate; ?></a></td>
</tr>
</table>
</form>
</div>
</div>
</div>
<script type="text/javascript"><!--
	$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
	$('#form').submit();
	}
	});
//--></script> 
<?php echo $footer; ?>