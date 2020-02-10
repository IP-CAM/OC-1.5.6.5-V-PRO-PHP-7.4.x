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
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>

    </div>
    <div class="content">
      <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import">
        <table class="form">
          <tr>
            <td><?php echo $entry_import; ?><br/><span class="help"><?php echo $entry_import_help; ?></span></td>
            <td><input type="file" name="import" /></td>
          </tr>
       <tr><td align="left" colspan="2"> <div class="buttons"><a onclick="$('#import').submit();" class="button"><span><?php echo $button_import; ?></span></a></div></td></tr>
        </table>
      </form>
      <form action="<?php echo $export; ?>" method="post" enctype="multipart/form-data" id="export">
         <table class="form">
            <tr>
              <td><?php echo $entry_category; ?><br/><span class="help"><?php echo $entry_category_help; ?></span></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>

                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr><td align="left" colspan="2"> <div class="buttons"><a onclick="$('#export').submit();" class="button"><span><?php echo $button_export; ?></span></a></div></td></tr>
		</table>
      </form>
     <?php echo $text_notes; ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>