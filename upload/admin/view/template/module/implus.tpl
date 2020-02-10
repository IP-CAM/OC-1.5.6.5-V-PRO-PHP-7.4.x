<?php 
// Image Manager Plus
// author: Dotbox - www.dotbox.eu
 ?>

<?php echo $header; ?>

<style type="text/css">
  .image-box{height: 28px;}
  .rotated {
  transform: rotate(-90deg);
  transform-origin: 0 0;
  -ms-transform: rotate(-90deg); /* IE 9 */
  -ms-transform-origin: 0 0;
  -moz-transform: rotate(-90deg); /* Firefox */
  -moz-transform-origin: 0 0;
  -webkit-transform: rotate(-90deg); /* Safari and Chrome */
  -webkit-transform-origin: 0 0;
  -o-transform: rotate(-90deg); /* Opera */
  -o-transform-origin: 0 0;
  position: relative;
  top: 100%;}
</style>

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
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  <div class="content">
      <div id="tabs" class="htabs">
            <a href="#tab-general"><?php echo $tab_general; ?></a>
            <a href="#tab-config"><?php echo $tab_config; ?></a>
            <a href="#tab-design"><?php echo $tab_design; ?></a>
            <a href="#tab-watermark"><?php echo $tab_watermark; ?></a>
            <a href="#tab-autoresize"><?php echo $tab_autoresize; ?></a>
      </div>

    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
       <div id="tab-general">
          <table class="form">
            
            <tr>
              <td><?php echo $entry_language; ?></td>
              <td><select name="implus_language">
                  <option value=""> ENG </option>
                  <?php foreach ($languages as $language) {?>
                      <option value="<?php echo $language;?>" <?php if ($language==$implus_language){ echo " selected";}?>><?php echo strtoupper($language);?></option>
                  <?php } ?>
                </select></td>
            </tr>         
            <tr>
                <td><?php echo $entry_width; ?></td>
                <td>
                  <input type="text" name="implus_width" value="<?php echo $implus_width; ?>" size="3" />             
                </td>
            </tr>
            <tr>
                <td><?php echo $entry_height; ?></td>
                <td>
                  <input type="text" name="implus_height" value="<?php echo $implus_height; ?>" size="3" />             
                </td>
            </tr>                         
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="implus_status">
                  <?php if ($implus_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr> 
            
          </table>
       </div>
       <div id="tab-config">
        <table class="form">            
             <tr>
              <td><?php echo $entry_drag_upload_allow; ?></td>
              <td><select name="implus_drag_upload_allow">
                  <?php if ($implus_drag_upload_allow) { ?>
                  <option value="0" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="1"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_enabled; ?></option>
                  <option value="1" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr> 
            <tr>
              <td><?php echo $entry_lazy_load; ?></td>
              <td>
                <input type="text" name="implus_lazy_load" value="<?php echo $implus_lazy_load; ?>" size="4" />
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_lazy_load_treshold; ?></td>
              <td>
                <input type="text" name="implus_lazy_load_treshold" value="<?php echo $implus_lazy_load_treshold; ?>" size="4" />
              </td>    
            </tr>        
            <tr>
              <td><?php echo $entry_only_images; ?></td>
              <td><select name="implus_only_images">
                  <?php if ($implus_only_images) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
             <tr>
              <td><?php echo $entry_copy_overwrite; ?></td>
              <td><select name="implus_copy_overwrite">
                  <?php if ($implus_copy_overwrite) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr> 
            <tr>
              <td><?php echo $entry_upload_overwrite; ?></td>
              <td><select name="implus_upload_overwrite">
                  <?php if ($implus_upload_overwrite) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>  
            <tr>
              <td><?php echo $entry_upload_max_size; ?></td>
              <td> <input type="text" name="implus_upload_max_size" value="<?php echo $implus_upload_max_size; ?>" size="4" /> 
              <select name="implus_upload_type">
                  <option value="M" <?php if ($implus_upload_type == 'M' || !$implus_upload_type) {
                    echo " selected";}?> ><?php echo $text_megabytes; ?>
                  </option>
                  <option value="K" <?php if ($implus_upload_type == 'K') { 
                    echo " selected";}?>><?php echo $text_kilobytes; ?>
                  </option>
              </select></td>
            </tr>                                                          
        </table>
       </div>
      <div id="tab-design">
        <table class="form"> 
            <tr>
              <td><?php echo $entry_status_design; ?></td>
              <td><select name="implus_design_status">
                  <?php if ($implus_design_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
             <tr>
              <td><?php echo $entry_toolbar_image; ?></td>
              <td><select name="implus_toolbar_image" id="implus_toolbar_image">
                  <option value="color"><?php echo $text_toolbar_image; ?></option>
                  <?php foreach ($toolbars as $toolbar) {?>
                      <option value="<?php echo $toolbar;?>" <?php if ($toolbar==$implus_toolbar_image){ echo " selected";}?>><?php echo strtoupper($toolbar);?></option>
                  <?php } ?>
                </select>
                <?php if ($this->config->get('implus_toolbar_image')) {
                    $default_src = HTTP_SERVER . "view/image/image_manager_pro/toolbars/toolbar-" . $this->config->get('implus_toolbar_image') . ".png"; } else {  $default_src = HTTP_SERVER . "view/image/image_manager_pro/toolbars/toolbar-color.png"; } ?>
                <div class="image-box"><img class ="rotated" src="<?php echo $default_src; ?>" name="toolbar-image-swap"></div> 
                </td>
            </tr> 
            <tr>
              <td style="border-bottom: 0px;padding-top: 30px;font-weight: bold;"><?php echo $info_colors; ?></td>
            </tr>
             <tr>
              <td><?php echo $entry_theme_toolbar_bg_color; ?></td>
              <td>
                <input class="color" name="implus_theme_toolbar_bg_color" value="<?php echo $implus_theme_toolbar_bg_color; ?>">
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_theme_left_panel; ?></td>
              <td>
                <input class="color" name="implus_theme_left_panel" value="<?php echo $implus_theme_left_panel; ?>">
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_theme_right_panel; ?></td>
              <td>
                <input class="color" name="implus_theme_right_panel" value="<?php echo $implus_theme_right_panel; ?>">
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_theme_hower; ?></td>
              <td>
                <input class="color" name="implus_theme_hower" value="<?php echo $implus_theme_hower; ?>">
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_theme_selected_item; ?></td>
              <td>
                <input class="color" name="implus_theme_selected" value="<?php echo $implus_theme_selected; ?>">
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_theme_icon_color; ?></td>
              <td>
               <input class="color" name="implus_theme_icon_active" value="<?php echo $implus_theme_icon_active; ?>">
               <?php echo $entry_theme_icon_inactive; ?>
               <input class="color" name="implus_theme_icon_inactive" value="<?php echo $implus_theme_icon_inactive; ?>">
               <?php echo $entry_theme_icon_color_hover; ?>
               <input class="color" name="implus_theme_icon_hover" value="<?php echo $implus_theme_icon_hover; ?>">
              </td>    
            </tr> 
            <tr>
              <td style="border-bottom: 0px;padding-top: 30px;font-weight: bold;"><?php echo $info_extra; ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_theme_icon_border; ?></td>
              <td>
                <input type="text" name="implus_theme_icon_border" value="<?php echo $implus_theme_icon_border; ?>" size="4"/>
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_theme_icon_round; ?></td>
              <td>
                <input type="text" name="implus_theme_icon_round" value="<?php echo $implus_theme_icon_round; ?>" size="4"/>
              </td>    
            </tr> 
             <tr>
              <td><?php echo $entry_theme_toolbar_round; ?></td>
              <td>
                <input type="text" name="implus_theme_toolbar_round" value="<?php echo $implus_theme_toolbar_round; ?>" size="4" />
              </td>    
            </tr> 
        </table>
       </div>
       <div id="tab-watermark">
        <table class="form">
          <tr>
            <td><?php echo $info_watermark; ?></td>
          </tr>
        </table>
        <table class="form">
          <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="implus_watermark_status">
                  <?php if ($implus_watermark_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr> 

           <td><?php echo $entry_watermark; ?></td>
                <td><div class="image"><img src="<?php echo $implus_watermark_image; ?>" alt="" id="thumb-implus-watermark-image" />
                    <input type="hidden" name="implus_watermark_image_con" value="<?php echo $implus_watermark_image_con; ?>" id="implus-watermark-image" />
                    <br />
                    <a class="button" onclick="image_upload('implus-watermark-image', 'thumb-implus-watermark-image');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;&nbsp;<a class="button" onclick="$('#thumb-implus-watermark-image').attr('src', '<?php echo $no_image; ?>'); $('#implus-watermark-image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
              </tr>
            <tr>
              <td><?php echo $entry_watermark_margin_right; ?></td>
              <td>
                <input type="text" name="implus_watermark_margin_right" value="<?php echo $implus_watermark_margin_right; ?>" size="4" />
              </td>    
            </tr>
            <tr>
              <td><?php echo $entry_watermark_margin_bottom; ?></td>
              <td>
                <input type="text" name="implus_watermark_margin_bottom" value="<?php echo $implus_watermark_margin_bottom; ?>" size="4" />
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_watermark_quality; ?></td>
              <td>
                <input type="text" name="implus_watermark_quality" value="<?php echo $implus_watermark_quality; ?>" size="4" />
              </td>    
            </tr>
            <tr>
              <td><?php echo $entry_watermark_transparency; ?></td>
              <td>
                <input type="text" name="implus_watermark_transparency" value="<?php echo $implus_watermark_transparency; ?>" size="4" />
              </td>    
            </tr>  
        </table>
       </div>
       <div id="tab-autoresize">
        <table class="form">
          <tr>
            <td><?php echo $info_resize; ?></td>
          </tr>
        </form>
        <table class="form">
          <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="implus_resize_status">
                  <?php if ($implus_resize_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr> 
            <tr>
              <td><?php echo $entry_resize_max_width; ?></td>
              <td>
                <input type="text" name="implus_resize_max_width" value="<?php echo $implus_resize_max_width; ?>" size="4" />
              </td>    
            </tr>
            <tr>
              <td><?php echo $entry_resize_max_height; ?></td>
              <td>
                <input type="text" name="implus_resize_max_height" value="<?php echo $implus_resize_max_height; ?>" size="4" />
              </td>    
            </tr> 
            <tr>
              <td><?php echo $entry_resize_quality; ?></td>
              <td>
                <input type="text" name="implus_resize_quality" value="<?php echo $implus_resize_quality; ?>" size="4" />
              </td>    
            </tr>
        </table> 
    </div>    
    </form>
    </div>
  </div>
</div>


<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: '<?php echo $text_image_manager; ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
          dataType: 'text',
          success: function(data) {
            $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: <?php echo $this->config->get('implus_width')?$this->config->get('implus_width'):800;?>,
    height: <?php echo $this->config->get('implus_height')?$this->config->get('implus_height'):400;?>,
    resizable: false,
    modal: false
  });
};
//--></script> 
 <script type="text/javascript"> <!--
$(document).ready(function(){
 var imagepath = '<?php echo HTTP_SERVER."view/image/image_manager_pro/toolbars/toolbar-";?>';

 var themepath = '<?php echo HTTP_SERVER."view/stylesheet/image_manager_pro/themes/theme-";?>';

   $("#implus_toolbar_image").change(function(){
     $("img[name=toolbar-image-swap]").attr("src",imagepath + $(this).val() + ".png");
   });

   $("#implus_toolbar_theme").change(function(){
     $("img[name=toolbar-theme-swap]").attr("src",themepath + $(this).val() + ".jpg");
   });

});
//--></script>
<script type="text/javascript" src="view/javascript/image_manager_plus/jscolor/jscolor.js"></script>
<?php echo $footer; ?>