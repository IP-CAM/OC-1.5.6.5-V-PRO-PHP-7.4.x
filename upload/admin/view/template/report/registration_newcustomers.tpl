<?php echo $header; ?>

<style type="text/css">
  .reg0 {
    border: 1px #dddddd solid;
    margin: 0 auto;
    position: relative;
    height: 500px;          
    width:  100%;          
  }
  .reg2 {
    float: left;
    height: 500px;  
    width: 1%;        
  }
  .reg1 {
    background: #000000; /* color for new reg */
    position: relative;
  }
  .reg2 a {          
    border-top: 1px #666666 solid;
    display: block;
    position: relative;
    width: 100%;
  }
  .odd {
    background: #cccccc; /* liche */
  }        
  .even {
    background: #dddddd; /* sude */
  }
  /* diagonal */
  .bottom-right-triangle {
    border: solid 1000px transparent;          
    border-right:  none;
    border-top:    none;
    border-bottom: solid 500px #fdd;          
    height: 0;
    width:  0;
    position: absolute; top: 0px; left: 0px;
  }
</style>

<script type="text/javascript">
  function reDraw() {
    var 
      box_width = $(".reg0").width(),
      t_br = $(".bottom-right-triangle").css('border-right'),
      t_bt = $(".bottom-right-triangle").css('border-top'),
      t_bb = $(".bottom-right-triangle").css('border-bottom');
    $('.bottom-right-triangle')
      .css('border', 'solid ' + box_width + 'px transparent')
      .css('border-right' , t_br)
      .css('border-top'   , t_bt)
      .css('border-bottom', t_bb);
  } // reDraw
  // reload
  $(window)
    .ready (function() {reDraw();})  
    .resize(function() {reDraw();});
</script>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /><?php echo $heading_title; ?></h1>  
    </div>
    <div class="content">

      <div style="background: #E7EFEF; border: 1px solid #C6D7D7; padding: 3px; margin-bottom: 15px;">
      <table width="100%">
        <tr>
          <td>
            <?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" />
          </td>
          <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
        </tr>
      </table>
      </div>
      
      <div class="reg0">
      
        <div class="bottom-right-triangle"></div>
  
        <?php 
    
        $pro100 = 500; // = px = 100%
        $min    = reset($registers);
        $max    = $registers[$filter_date_end] - $min;
        $pocet  = count($registers);  
        
        $temp = array(
          'height' => 0,
          'top'    => $pro100,
          'value'  => $min
        );
      
        $n = 0;
        foreach ($registers as $key => $value) {
          
          $length = $value - $min;
          $height = number_format($length * ( $pro100 / $max ), 2);
          $top    = number_format($pro100 - $height, 2);
  
          $new_reg = $value - $temp['value']; 
          
          echo "
            <div class='reg2'>
              <div class='reg1' style='height: " . $height . "px; top: " . $top . "px;'>
                <a class='" . ( (int)($n/2) == ($n/2) ? 'even' : 'odd' ) . "' style='height:" . $temp['height'] . "px; top:" . ($height - $temp['height']) . "px' title='" . $key . " = " . $value . " (+" . $new_reg . ")'></a>
              </div>
            </div>
          ";
          
          $temp = array(
            'height' => $height,
            'top'    => $top,
            'value'  => $value  
          );
  
          $n++;
        } // foreach 
    
        ?>
      
      </div>
      
      <div style="clear: both;"></div>

    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/registration_newcustomers&token=<?php echo $token; ?>';

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	location = url;
}
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php echo $footer; ?>