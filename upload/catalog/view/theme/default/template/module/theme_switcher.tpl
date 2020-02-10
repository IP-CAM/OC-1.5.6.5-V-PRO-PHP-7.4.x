<?php if ($themes) { ?>
<div class="panel panel-default">
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="module_theme_switcher"> 
      <div align="center"  id="tab_general" class="page;" style="padding:6px;">
      <select name="product" onchange="location=this.value" style="width:170px">
            <?php foreach ($themes as $theme) { ?>
            <?php if (isset($this->session->data['theme'])) { ?>
            <option value="<?php echo $theme['href']; ?>" <?php echo (ucwords($this->session->data['theme']) == $theme['name']) ? 'selected="selected"' : ''?>><?php echo $theme['name']; ?> Theme</option>
            <?php } else { ?>
			      <option value="<?php echo $theme['href']; ?>" <?php echo (ucwords($this->config->get('config_template'))) == $theme['name'] ? 'selected="selected"' : ''?>><?php echo $theme['name']; ?> Theme</option>            
            <?php } ?>
            <?php } ?>
          </select>
      </div>
    </form>
  </div>
<?php } ?>
