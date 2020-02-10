<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php if ($error_warning) { ?>
<div class="warning" style="font-size:1.0em; color:red;"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><img src="view/image/product.png" alt="<?php echo $heading_title; ?>" /><?php echo $heading_title; ?></h1>
		<div class="buttons">
		<a class="button" href="<?php echo $troubleshoot_link ?>"><?php echo $vqmod_troubleshoot; ?></a>
		<a class="button" href="<?php echo $this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'); ?>"><?php echo $text_button_refresh; ?></a> 
		<a class="button" href="<?php echo $clear_vqcache; ?>"><?php echo $text_clear_vqcache; ?></a>
		<a class="button" href="<?php echo $clear_log; ?>"><?php echo $text_clear_log; ?></a>
		  </div>
	  </div>
    <div class="success" id="working" style="display:none;"><b><?php echo $vqmod_manual_wait; ?></b> <img src="view/image/loading.gif"></div>
  <div class="content">
     <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	   <!-- Error Log -->
    <?php if ($log) { ?>
    <h4 style="font-size:15px; background-color:#EEEEEE; padding:9px 0px 9px 40px; border:solid 1px #B6B8D3; background-image:url('view/image/log.png'); background-repeat:no-repeat; background-position:1% 50%;"><?php echo $heading_error_log; ?></h4>
    <div>
      <table class="form">
        <tr>
          <td style="border-bottom-color:#fff;"><textarea rows="20" cols="160" style="width: 99%; height: 300px; padding: 5px; border: 1px solid #CCCCCC; background: #FFFFFF; overflow: scroll;"><?php echo $log; ?></textarea></td>
        </tr>
        <tr>
           <td style="border-top-color:#fff;"><div style="text-align:right;"><a href="<?php echo $clear_log; ?>" class="button"><span><?php echo $button_clear; ?></span></a></div></td>
        </tr>
      </table>
    </div>
    <?php } ?>
    <!-- /Error Log -->
    <?php if ($path_set == TRUE) { ?>
    <!-- VQMods -->
    <div>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_file_name; ?>&nbsp;&nbsp;&nbsp;|&nbsp;<span style="font-size:0.9em; color:red;"><input type="checkbox" <?php if ($hidden) { ?>checked="true" <?php } ?>onchange="location='<?php echo $hidden_link; ?>';"> <?php printf($show_hidden,$nhidden); ?></span></td>
            <td class="center"><?php echo $column_action; ?></td>
            <td class="center"><?php echo $column_version; ?></td>
            <td class="center"><?php echo $column_author; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($vqmods)) { ?>
          <?php $i=0; foreach ($vqmods as $vqmod) { $i++; ?>
          <tr>
            <td class="left">
                <?php if (!$vqmod['enabled']) { ?><font color=grey><?php } ?>
                <strong><?php echo $vqmod['file_name']; ?></strong>
                <?php if ($vqmod['hide']) { ?> <span style="font-size:1.0em; font-style: color:darkblue;">( <?php echo $hidden_file; ?>! )</span><?php } ?>

                <?php if ($vqmod['errors']) { ?>
                    &nbsp;&nbsp;<a style="text-decoration:none; font-weight: bold; font-size:1.2em; color:red;" onclick="$('#err<?php echo $i ?>').toggle(250)"><?php echo count($vqmod['errors'])." ".$vqmod_nerrors; ?></a>
                <?php } ?>

                <br /><div style="font-size:0.9em; margin:3px 0px;"><?php echo $vqmod['id']; ?></div>

                <?php if (!$vqmod['enabled']) { ?></font><?php } ?>
              <?php if ($vqmod['errors']) { ?>
                <div style="margin-left: 20px; display:none" id="err<?php echo $i ?>">

                    <ul>
                    <?php foreach ($vqmod['errors'] as $error) { ?>
                        <li style="font-size:0.9em;"><?php echo $error ?></li>
                    <?php } ?>
                    </ul>
                </div>
              <?php } ?>
                <?php echo $vqmod['tadd']; ?>
            </td>
              <td class="center" style="white-space:nowrap;"><?php foreach ($vqmod['action'] as $action) { ?>
                  <a class="button" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                  <?php } ?></td>
            <td class="center"><?php echo $vqmod['version']; ?></td>
            <td class="center"><?php echo $vqmod['author']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <!-- VQMOD Upload -->
      <table class="form">
        <tr>
          <td><?php echo $entry_upload; ?>&nbsp;<input type="file" name="vqmod_file" onchange="$('#qupload').click();" /><input style="display:none;" type="submit" id="qupload" name="upload" value="Upload" /></td>
        </tr>
      </table>
      <!-- /VQMOD Upload -->
    </div>
    <!-- /VQMods -->
    <?php } ?>

    </form>
  </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	// Confirm Delete
	$('a').click(function(){
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('delete',1) != -1) {
			if (!confirm ('<?php echo $warning_vqmod_delete; ?>')) {
				return false;
			}
		}
	});

	// Confirm vqmod_opencart.xml Uninstall
	$('a').click(function(){
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('vqmod_opencart',1) != -1 && $(this).attr('href').indexOf('uninstall',1) != -1) {
			if (!confirm ('<?php echo $warning_required_uninstall; ?>')) {
				return false;
			}
		}
	});

	// Confirm vqmod_opencart.xml Delete
	$('a').click(function(){
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('vqmod_opencart',1) != -1 && $(this).attr('href').indexOf('delete',1) != -1) {
			if (!confirm ('<?php echo $warning_required_delete; ?>')) {
				return false;
			}
		}
	});
});
</script>
<?php echo $footer; ?>