<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */
?>
<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/log.png" alt=""/> <?php echo $heading_title; ?></h1>

            <div class="buttons"><a href="<?php echo $clear; ?>" class="button"><span><?php echo $button_clear; ?></span></a></div>
        </div>
        <div class="content">
            <textarea wrap="off" style="width: 98%; height: 300px; padding: 5px; border: 1px solid #CCCCCC; background: #FFFFFF; overflow: scroll;"><?php echo $log; ?></textarea>
        </div>
        <p style="text-align:center; color:#222;">Security OpenCart Module v<?php echo $version; ?> - <a href="http://exife.com" target="_blank">exife.com</a></p>
    </div>
</div>
<?php echo $footer; ?>