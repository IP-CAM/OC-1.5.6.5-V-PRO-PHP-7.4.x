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
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
          <a class="button" id="insert"><span><?php echo $button_insert; ?></span></a>
         <a onclick="location = '<?php echo $clear; ?>'" class="button"><span><?php echo $button_clear_cache; ?></span></a>
         <!-- <a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a> -->
         <a id="btn-delete" class="button"><span><?php echo $button_delete; ?></span></a>
      </div>
    </div>
    <div class="content">
	<div id="form-add" style="display:none;">
	<form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-insert">
	<table class="form">
	<tr><td>Query:</td><td><input type="text" name="query" size="40" /></td></tr>
	<tr><td>SEO Keyword:</td><td><input type="text" name="keyword" size="40" /></td></tr>
	<tr><td colspan="2" align="left">
	<a onclick="$('#form-insert').submit();" class="button"><span><?php echo $button_save; ?></span></a>
	<a onclick="fnCancel();" class="button"><span><?php echo $button_cancel; ?></span></a>
	<input type="hidden" name="url_alias_id" value="0">
	</td></tr>
	</table
	</form>
	</div>
	<!-- FORM -->
	<form action="delete" method="post" id="form"></form>
	<form action="<?php echo $delete ?>" method="post" enctype="multipart/form-data" id="formblablabla">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php if ($sort == 'ua.query') { ?>
                <a href="<?php echo $sort_query; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_query; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_query; ?>"><?php echo $column_query; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ua.keyword') { ?>
                <a href="<?php echo $sort_keyword; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_keyword; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_keyword; ?>"><?php echo $column_keyword; ?></a>
                <?php } ?></td>
                <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($url_aliases) { ?>
            <?php foreach ($url_aliases as $url_alias) { ?>
            <tr class="tr<?php echo $url_alias['url_alias_id']; ?>">
              <td style="text-align: center;"><?php if ($url_alias['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $url_alias['url_alias_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $url_alias['url_alias_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $url_alias['query']; ?></td>
              <td class="left"><?php echo $url_alias['keyword']; ?></td>
              <td class="right">[ <a onclick="itemEdit(<?php echo $url_alias['url_alias_id']; ?>)"><?php echo $url_alias['action_text']; ?></a> ]</td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function itemEdit(url_alias_id) {
	$('input[name="query"]').val($('.tr'+url_alias_id+' td:eq(1)').text());
	$('input[name="keyword"]').val($('.tr'+url_alias_id+' td:eq(2)').text());
	$('input[name="url_alias_id"]').val(url_alias_id);
	$('#form-add').show();
	$('input[name="query"]').focus();
	return false;
}
function fnCancel() {
	$('#form-add').hide();
	$('input[name="query"]').val('');
	$('input[name="keyword"]').val('');
	$('input[name="url_alias_id"]').val('0');
	return false;
}

$('#insert').click(function() {
	fnCancel();
	$('#form-add').show();
	return false;
});

$(document).ready(function() {
	$('#btn-delete').click(function() {
		if (!confirm('Удаление невозможно отменить! Вы уверены, что хотите это сделать?')) {
			return false;
		} else {
		    $('#formblablabla').submit();
		}
	});
});
//--></script>
<?php echo $footer; ?>