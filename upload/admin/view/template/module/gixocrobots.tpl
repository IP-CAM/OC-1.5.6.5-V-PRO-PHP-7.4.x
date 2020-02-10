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
      <h1><img src="view/image/log.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="create();" class="button"><?php echo $entry_create; ?></a>
        <a onclick="clean();" class="button"><?php echo $entry_clean; ?></a>
        <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></a>
        <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
	  </div>
	  </div>
    </div>
    <div class="content">
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <textarea id="text" name="robots" wrap="off" style="width: 98%; height: 300px; padding: 5px; border: 1px solid #CCCCCC; background: #FFFFFF; overflow: scroll;"><?php echo $text; ?></textarea> 
	 </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function create() {
	$.ajax({
		url: 'index.php?route=module/gixocrobots/create_robots&token=' + '<?php echo $token; ?>',
		dataType: 'text',
		success: function(res) {
			$('#text').val(res);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}	
	});
};
//--></script>
<script type="text/javascript"><!--
function  clean() {
	$('#text').val('');
};
//--></script>
<?php echo $footer; ?>