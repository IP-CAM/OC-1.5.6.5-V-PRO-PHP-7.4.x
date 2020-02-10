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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save_reload; ?></a><a href="<?php echo $done; ?>" class="button"><?php echo $button_done; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $text_product; ?><span class="help"><?php echo $help_product; ?></span></td>
            <td><?php if ($warranty_front) { ?>
              <input type="radio" name="warranty_front" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="warranty_front" value="0" /><?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="warranty_front" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="warranty_front" value="0" checked="checked" /><?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
		</table>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 