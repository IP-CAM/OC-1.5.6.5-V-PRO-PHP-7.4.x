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
      <h1><img src="view/image/redirect.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
		<?php echo $text_tracking; ?>
		<select name="module_tracking">
               <?php if ($tracking == 1) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="2"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="2" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
		</select>
	    <a id="save-button" class="button"><?php echo $save_redirects; ?></a><a href="<?php echo $exceptions; ?>" class="button"><?php echo $button_exceptions; ?></a><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a>
	  </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" id="form">
        <table id="mask" class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"> 
               <?php echo $column_old_url; ?>
              </td>
			  <td class="left"> 
               <?php echo $column_new_url; ?>
              </td>
			  <td class="left"> 
               <?php echo $column_referer; ?>
              </td>
              <td class="left"><?php if ($sort == 'status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>
            </tr>
          </thead>
		  <?php $row = 1; ?>
          <tbody>
            <?php if ($redirects) { ?>
            <?php foreach ($redirects as $redirect) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($redirect['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $redirect['url_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $redirect['url_id']; ?>" />
                <?php } ?></td>
              <td class="left"><a href="<?php echo $redirect['old_valid_url']; ?>" target="_blank"><?php echo implode('<br/>', str_split_unicode($redirect['old_url'], 62)); ?></a></td>
			  <td class="left">
				<input type="text" class="post necessary" name="url[<?php echo $row; ?>][link]" size="60" value="<?php echo $redirect['new_url']; ?>" />
				<input type="hidden" class="post" name="url[<?php echo $row; ?>][id]" value="<?php echo $redirect['url_id']; ?>" />
			  </td>
			  <td class="left"><a href="<?php echo $redirect['referer']; ?>" target="_blank"><?php echo implode('<br/>', str_split_unicode($redirect['referer'], 36)); ?></a></td>
              <td class="left">
			  	<select class="post" name="url[<?php echo $row; ?>][status]">
				<?php if ($redirect['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
				</select>
			  </td>
              <td class="left"><?php echo $redirect['date_added']; ?></td>
            </tr>
            <?php $row++; } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
prepareSave();
function saveInit() {	
	
	var html = '<div class="customBlockContent">';
	html += 		'<div id="box-message"><span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span></div>';
	html +=    '</div>';
	
	$('#mask').block({
		title: '<?php echo $text_save; ?>',
        message: html,
		css: {
			border: '1px solid #ddd',
			top: '40px'
		},
		centerY:false
	});
}

function showMessage(selector, message) {	
	if (message) {
		$(selector).html(message);
	}
	setTimeout(function() {
		$('#mask').unblock();
	}, 2000);
	prepareSave();
}

function prepareSave() {
	$('#save-button').one('click', function() {
		$('#form').trigger('saveData');
	});
}

$('#form').on('saveData', function(event) {

	event.preventDefault();
	
	$.ajax({
		url: 'index.php?route=module/redirect/save&token=<?php echo $token; ?>',
		type: 'post',
		data: $('.post').serialize(),
		dataType: 'json',			
		beforeSend: function() {
			saveInit();
		},			
		success: function(json) {
			
			if (json['success']) {
				showMessage('#box-message', json['success']);
				
			} else {
				showMessage('#box-message', json['error']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.error(thrownError);
		}
	});
});


$('select[name=\'module_tracking\']').change(function() {

	$.ajax({
		url: 'index.php?route=module/redirect/tracking&status=' + this.value + '&token=<?php echo $token; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'module_tracking\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			
			var html = '';
			
			if (json['tracking'] == '1') {
				html += '<option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
				html += '<option value="2"><?php echo $text_disabled; ?></option>';		
			} else {
				html += '<option value="1"><?php echo $text_enabled; ?></option>';
				html += '<option value="2" selected="selected"><?php echo $text_disabled; ?></option>';
			}
			
			$('select[name=\'module_tracking\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.error(thrownError);
		}
	});
});
</script>
<?php echo $footer; ?>
<?php
function str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, 'UTF-8');
        }
        return $ret;
    }
    return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
}
?>