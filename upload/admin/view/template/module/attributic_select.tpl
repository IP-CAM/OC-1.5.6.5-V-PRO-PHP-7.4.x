<div style="clear: both">
<div style="background: #003A88;border-radius: 3px;color: #FFFFFF;float: left;margin: 0 0 10px 0;padding: 0 10px;">
    <?php echo $text_select; ?>
	<select id="add_attribute_templates">
        <option value="0">----------</option>
		<?php foreach ($modules as $module) { ?>
        <option value="<?php echo $module['template_id']; ?>"><?php echo $module['title']; ?></option>
		<?php } ?>
    </select>
</div>
<a id="delete_all_attributes" class="button" style="background: #003A88;border-radius: 3px;color: #FFFFFF;float: left;margin: 0 0 10px 10px;padding: 0 10px;height: 21px;line-height: 21px;"><?php echo $text_delete_all; ?></a>
<a id="delete_empty_attributes" class="button" style="background: #003A88;border-radius: 3px;color: #FFFFFF;float: left;margin: 0 0 10px 10px;padding: 0 10px;height: 21px;line-height: 21px;"><?php echo $text_delete_empty; ?></a>
</div>