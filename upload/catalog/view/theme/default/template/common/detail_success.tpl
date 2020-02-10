<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
 <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>

	<?php if (isset($order)): ?>
	<div class="ds ds-container">
    <div class="left">
        <h2><?php echo $text_title; ?></h2>
        <?php foreach ($products as $product): ?>
            <div class="product row">
                <div class="left">
                    <?php echo !empty($product['image']) ? '<img src="image/' . $product['image'] .'">' : ''; ?>
                </div>
                <div class="right">
                    <div class="row">
                        <span><strong><?php echo $text_product; ?></strong></span>
                    </div>
                    <div class="row">
                        <a class="link" href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a>
                    </div>
                    <div class="row">
                        <span><?php echo $text_price; ?>: </span>
                        <b><?php echo isset($product['special']) ? $product['special'] : $product['price']; ?></b>
                    </div>
                    <div class="row">
                        <span><?php echo $text_qty; ?>: </span>
                        <b><?php echo $product['quantity']; ?></b>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <h2><?php echo $text_total . ' ' . $order['total'] ?></h2>
    </div>
    <div class="right">
        <div class="row">
            <h2><?php echo $text_details; ?></h2>
        </div>
        <?php if (!empty($order['firstname'])): ?>
            <div class="row">
                <b><?php echo $text_name; ?></b> <?php echo $order['firstname'] . " " . $order['lastname']; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($order['email'])): ?>
            <div class="row">
                <b><?php echo $text_email; ?></b> <?php echo $order['email']; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($order['shipping_company'])): ?>
            <div class="row">
                <b><?php echo $text_company; ?></b> <?php echo $order['shipping_company']; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($order['telephone'])): ?>
            <div class="row">
                <b><?php echo $text_phone; ?></b> <?php echo $order['telephone']; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($order['shipping_method'])): ?>
            <div class="row">
                <b><?php echo $text_delivery; ?></b> <?php echo $order['shipping_method']; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($order['payment_method'])): ?>
            <div class="row">
                <b><?php echo $text_payment; ?></b> <?php echo $order['payment_method'] ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <b><?php echo $text_address; ?></b><br />
			<?php echo !empty($order['text_company']) ? $order['text_company'].',<br /> ' : ''; ?>
            <?php echo $order['firstname'] . " " . $order['lastname']; ?><br />
			<?php echo !empty($order['shipping_address_1']) ? $order['shipping_address_1'].', ' : ''; ?><br />
            <?php echo !empty($order['shipping_address_2']) ? $order['shipping_address_2'].',<br /> ' : ''; ?>
            <?php echo !empty($order['shipping_postcode']) ? $order['shipping_postcode'].', ' : ''; ?>
            <?php echo !empty($order['shipping_city']) ? $order['shipping_city'].', ' : ''; ?><br />
            <?php echo !empty($order['shipping_country']) ? $order['shipping_country'].'' : ''; ?>
         </div>
    </div>
</div>
<?php echo $text_message; ?>
<style>
.ds > .left > h2 {
    margin:8px 0;
}
.ds .left, .ds .right {
    position: relative;
    min-height: 1px;
    padding-right: 4px;
    padding-left: 4px;
}
.ds .row, .ds-container {
    margin: 0 4px 0 4px;
    clear: both;
    padding: 3px 0;
}

.ds .row:before,
.ds-container:before,
.ds .row:after,
.ds-container:after
 {
    display: table;
    content: " ";
    clear: both;
}
.ds {margin: 20px 0 50px 0;}
.ds > .left {
    float: left;
    width: 60%;
}
.ds > .right {
    float:left;
    width: 40%;
}
.ds .product {border-bottom: 1px solid #F0F0F0;padding:10px;margin: 0;}
.ds .product img {max-width: 100%;max-height: 150px;margin: 0 auto;display: block;}
.ds .product span {color:#808080;}
.ds .product a {font-size: 1.2em}
.ds .product .left {
    float: left;
    width: 40%;
}
.ds .product .right {
    float: left;
    width: 60%;
}
</style>
<?php else:?>
<span class="text"><?php echo $text_message; ?></span>
<?php endif;?>

<div class="buttons">
<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
</div>
<?php echo $content_bottom; ?></div>
<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>