<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $this->language->get('heading_title'); ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $this->language->get('button_save'); ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $this->language->get('button_cancel'); ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $this->language->get('entry_title'); ?> </td>
            <td><input type="text" name="title" value="<?php echo $title; ?>" size="128" />

              <?php if ($error_title) { ?>
              <span class="error"><?php echo $error_title; ?></span>
              <?php } ?></td>
            </td>
          <tr>
            <td><span class="required">*</span> <?php echo $this->language->get('entry_route'); ?></td>
            <td><input type="text" name="route" value="<?php echo $route; ?>" size="128" />
              <?php if ($error_route) { ?>
              <span class="error"><?php echo $error_route; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $this->language->get('entry_order'); ?></td>
            <td>
              <input type="text" name="order" value="<?php echo $order; ?>" size="32" />
              <?php if ($error_order) { ?>
              <span class="error"><?php echo $error_order; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $this->language->get('entry_img'); ?> </td>
            <td class="center"><input type="hidden" name="img" value="<?php echo $img; ?>" id="img" />
                <img src="<?php echo $preview; ?>" alt="" id="preview" class="image" onclick="image_upload('img', 'preview');" /></td>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div> 
<script type="text/javascript"><!--
function image_upload(field, preview) {
  $('#dialog').remove();

  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

  $('#dialog').dialog({
    title: '<?php echo $this->language->get('text_image_manager'); ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>',
          data: 'image=' + encodeURIComponent($('#' + field).val()),
          dataType: 'text',
          success: function(data) {
            $('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: 700,
    height: 400,
    resizable: false,
    modal: false
  });
};
//--></script> 
<?php echo $footer; ?>