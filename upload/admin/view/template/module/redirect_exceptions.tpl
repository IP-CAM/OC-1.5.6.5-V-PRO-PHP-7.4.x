<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/redirect.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" id="form">
        <table class="form">
		<tr>
			<td><?php echo $entry_exceptions; ?></td>
			<td><textarea name="exceptions" style="width:380px;height:200px;padding:5px"><?php echo $exceptions; ?></textarea>
		</td>
		</tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 