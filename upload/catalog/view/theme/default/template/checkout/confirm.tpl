<?php if (!isset($redirect)) { ?>
<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
		<td class="text-center">PIC</td>
        <td class="text-left"><?php echo $column_name; ?> + <?php echo $column_model; ?> + Options</td>
        <td class="text-center"><?php echo $column_quantity; ?></td>
        <td class="text-center"><?php echo $column_price; ?></td>
        <td class="text-center"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
		<td class="text-center">
		<?php if ($product['thumb']) { ?>
        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
        <?php } ?>
		</td>

        <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
		<br/>
		 <small>Model: <?php echo $product['model']; ?>
		<?php foreach ($product['option'] as $option) { ?>
		<br/>
         Option:&nbsp;<?php echo $option['name']; ?>: <?php echo $option['value']; ?>
          <?php } ?>
		 </small>
		</td>
        <td class="text-center"><?php echo $product['quantity']; ?></td>
        <td class="text-right"><?php echo $product['price']; ?></td>
        <td class="text-right"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="text-left"><?php echo $voucher['description']; ?></td>
        <td class="text-right">1</td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="4" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
        <td class="text-right"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<?php echo $payment; ?>
<?php } else { ?>
<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script>
<?php } ?>
