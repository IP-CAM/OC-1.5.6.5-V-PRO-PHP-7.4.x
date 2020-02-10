<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $this->url->link('module/toolbar/add','token='.$token,'SSL'); ?>" class="button"><?php echo $this->language->get('button_insert'); ?></a></div>
    </div>
    <div class="content">
        <table class="list">
          <thead>
            <tr>
            	<td class="left"><?php echo $this->language->get('entry_title');?> </td>
            	<td class="left"><?php echo $this->language->get('entry_route');?> </td>
            	<td class="left"><?php echo $this->language->get('entry_order');?> </td>
            	<td></td>
            </tr>
          </thead>
          <?php foreach ($items as $item) { ?>
          <tbody>
            <tr>
            	<td class="left"><?php echo $item['title']; ?></td>
            	<td class="left"><?php echo $item['route'];?></td>
            	<td class="left"><?php echo $item['order'];?></td>
              <td class="right">
              	<a href="<?php echo $this->url->link('module/toolbar/edit','itemid='.$item['id'].'&token='.$token,'SSL');?>" class="button"><?php echo $this->language->get('button_edit'); ?></a>
              	<a href="<?php echo $this->url->link('module/toolbar/del','itemid='.$item['id'].'&token='.$token,'SSL');?>" class="button"><?php echo $this->language->get('button_remove'); ?></a>
              </td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
    </div>
  </div>
</div>
<?php echo $footer; ?>