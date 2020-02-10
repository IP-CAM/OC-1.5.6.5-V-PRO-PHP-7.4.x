<?php echo $header; ?>
<div id="content">

  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } if($success != '') {  ?>
	<div class="success"><?=$success?></div>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
      	<input class="button" name="button_innodb" type="submit" value="<?=$button_myisam?>" /> 
      	<input class="button" name="button_myisam" type="submit" value="<?=$button_innodb?>" />
      </div>
    </div>
    <div class="content">
      		<div class="engine">
      		<h3>Engine : Myisam</h3>
      		<div class="myisam">
      		<?php foreach ($myisam as $key => $value) { ?>
      			
      			<div class="even"><label><input type="checkbox" name="myisam[]" value="<?=$value?>" >
      			<?=$value?></label></div>

      		<?php } ?>

      		</div>
      		<div class="check_all">
       			<label><input id="check_all_myisam" type="checkbox" name="check_all_myisam" ><a>Check ALL</a></label>
       		</div>
      		</div>
      		<div class="engine">
      		<h3>Engine : InnoDB</h3>
      		<div class="innodb">
      		<?php foreach ($innodb as $value) { ?>
 				<div class="even"><label><input type="checkbox" name="innodb[]" value="<?=$value?>" >
      			<?=$value?></label></div>

      		<?php } ?>


      		</div>
       		<div class="check_all">
       			<label><input id="check_all_innodb" type="checkbox" name="check_all_innodb" ><a>Check ALL</a></label>
       		</div>
			</div>
  	</div>
  </div>
  </form>
</div>
<script type="text/javascript">
	$('#check_all_myisam').click (function () {
     	var checkedStatus = this.checked;
	    $('.myisam .even').find(':checkbox').each(function () {
	        $(this).prop('checked', checkedStatus);
	     });
	});
	$('#check_all_innodb').click (function () {
     	var checkedStatus = this.checked;
	    $('.innodb .even').find(':checkbox').each(function () {
	        $(this).prop('checked', checkedStatus);
	     });
	});
</script>

<style>
.engine{
  width: 350px;
  float: left;
  margin: 20px;
}
.myisam ,.innodb{
  border: 1px solid #CCCCCC;
  width: 350px;
  height: 250px;
  background: #FFFFFF;
  overflow-y: scroll;
}
.even:nth-child(2n){
  background:#E4EEF4;
}
.check_all{padding: 5px 0px;}
.engine input{vertical-align: -11%;}
.engine label{line-height: 2}

a.button,input.button,a.button:visited,input.button:visited{position:relative;z-index:1;overflow:visible;display:inline-block;padding:.3em .6em .375em;border:1px solid #999;border-bottom-color:#888;margin:0;text-decoration:none;text-align:center;font:bold 11px/normal 'lucida grande',tahoma,verdana,arial,sans-serif;white-space:nowrap;cursor:pointer;color:#333;background-repeat:no-repeat;background-position:auto;background-color:#eee;background-image:-webkit-gradient(linear,0 0,0 100%,from(#f5f6f6),to(#e4e4e3));background-image:-moz-linear-gradient(#f5f6f6,#e4e4e3); background-image:-o-linear-gradient(#f5f6f6,#e4e4e3); background-image:linear-gradient(#f5f6f6,#e4e4e3); filter:progid:DXImageTransform.Microsoft.gradient(startColorStr='#f5f6f6',EndColorStr='#e4e4e3'); -webkit-box-shadow:0 1px 0 rgba(0,0,0,0.1),inset 0 1px 0 #fff; -moz-box-shadow:0 1px 0 rgba(0,0,0,0.1),inset 0 1px 0 #fff; box-shadow:0 1px 0 rgba(0,0,0,0.1),inset 0 1px 0 #fff; zoom:1; *display:inline; -webkit-border-radius:0; -moz-border-radius:0; -khtml-border-radius:0;border-radius:0;} .button:hover,.button:focus,.button:active{border-color:#777 #777 #666;} .button:active{ border-color:#aaa; background:#ddd; filter:none; -webkit-box-shadow:none; -moz-box-shadow:none; box-shadow:none;} .button::-moz-focus-inner{ padding:0; border:0;} .fb_box{height:30px;line-height:30px} .fb_button{position:fixed;top:0;left:0;right:0;z-index:9999;background:#fff5cc;border-bottom:1px solid #f2dd8c;color:#555} .fb_button .button{float:right;margin-top:4px}

.butt{
  text-decoration: none;
  color: #FFF;
  display: inline-block;
  padding: 5px 15px;
  background: #003A88;
  border-radius: 10px 10px 10px 10px;
  outline: none;
  border:none;
}
</style>
<?php echo $footer; ?>
