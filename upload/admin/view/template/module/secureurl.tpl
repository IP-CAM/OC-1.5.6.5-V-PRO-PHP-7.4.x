<?php echo $header;

$secKey = ((isset($modules['secure_key'])) ? $modules['secure_key'] : '' );
$secVal = ((isset($modules['secure_value'])) ? $modules['secure_value'] : '' );
?>

<script type="text/javascript">

function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 10;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}

	return randomstring;
	
}


function ChangeUrl() {
var url = document.URL.substring(0, document.URL.indexOf("index"))
url += "?" + $('[name="secure_key"]').val()
url += "=" + $('[name="secure_value"]').val()
$('#finalURL').html(url);
}


function GenerateKey(){
document.getElementById("secure_key").value=randomString();
ChangeUrl();
}

function GenerateVal(){
document.getElementById("secure_value").value=randomString();
ChangeUrl();
}

</script>


<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
	
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/logo_secure.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a  class="button" id="submit"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
         <h3>Administrator Key</h3>
            <tr>
          
              <td class="left">Status</td>
		<td>
		 <select name="secure_status">
                  <?php if ($modules['secure_status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
	
              </tr>
           <tr>
              <td class="left">Secure Key</td><td>
               <input type="text" name="secure_key" id="secure_key" onchange="ChangeUrl();" value="<?php  echo $secKey;   ?>"  />
		<button type="button" style="margin-left:10px;" onclick="GenerateKey()">Generate Me!</button></td>
		
		
              </tr>
           <tr>
              <td class="left">Secure Value</td><td>
               <input type="text" name="secure_value" id="secure_value" onchange="ChangeUrl();" value="<?php  echo $secVal;  ?>"  />
		<button type="button" style="margin-left:10px;" onclick="GenerateVal()">Generate Me!</button>
		</td>
		
              </tr>
			   
        </table>
		
	  <h4>Your Secure URL Link</h4>	
		<h3 id="finalURL" style="color: blue;"></h3>
		<br/>
		<h3>**Please Record down your secure URL Link before saving.</h3>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

$(function(){
	$('#submit').click(function(){
		if(confirm("Have you saved the secure url yet?")) {
   		  $('#form').submit();
  		}
	});
});


$(document).ready(function() { ChangeUrl() });

</script>
<?php echo $footer; ?>