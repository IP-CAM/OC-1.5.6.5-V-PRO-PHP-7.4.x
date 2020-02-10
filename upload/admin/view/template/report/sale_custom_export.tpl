<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>

      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_date_start; ?></td>
            <td class="left"><?php echo $column_date_end; ?></td>
            <td class="right"><?php echo $column_orders; ?></td>
            <td class="right"><?php echo $column_products; ?></td>
            <td class="right"><?php echo $column_tax; ?></td>
            <td class="right"><?php echo $column_reward; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) { ?>
          <tr>
            <td class="left"><?php echo $order['date_start']; ?></td>
            <td class="left"><?php echo $order['date_end']; ?></td>
            <td class="right"><?php echo $order['orders']; ?></td>
            <td class="right"><?php echo $order['products']; ?></td>
            <td class="right" style="mso-number-format:0\.00"><?php echo $order['tax']; ?></td>
            <td class="right" style="mso-number-format:0\.00"><?php echo $order['reward']; ?></td>
            <td class="right" style="mso-number-format:0\.00"><?php echo $order['total']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
</body></html>
