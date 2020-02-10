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
      <div class="buttons"><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td style="text-align:left;"><?php echo $column_serial; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php
           if ($serials) { ?>
          <?php foreach ($serials as $serial) { ?>
          <tr>
            <td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $serial['id']; ?>" /></td>
            <td style="text-align:left;" rel="<?php echo $serial['id']; ?>"><span class="editable" id="serial_key_<?php echo $serial['id']; ?>"><?php echo $serial['key']; ?></span></td>
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
      <div class="buttons"><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
	</div>
	</div>
  </div>
</div>
<script type="text/javascript"><!--
$(function() {
	var token = '<?php echo $this->session->data['token']; ?>';
	$('.editable').editable(function(value, settings) {
		var serial_id = $(this).parent().attr('rel');
		$.getJSON(
			'index.php',
			{
				'route'	: 'catalog/serial/updateSerial',
				'serial_id' : serial_id,
				'serial' : value.toString(),
				'token' : token
			},
			function(data) {
				if(data.error) {
					alert('The serial was not updated');
				}
			}
		);
		return(value);
	}, {
		submit  : 'Update',
	});
});
--></script>
<?php echo $footer; ?>