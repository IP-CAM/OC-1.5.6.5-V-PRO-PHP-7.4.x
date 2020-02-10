<?php echo $header; ?>

<div id="content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>

<div id="success"></div>

<div class="box">
  
    <div class="box-heading">
          <h1><i class="icon-comment"></i> <?php echo $heading_title; ?></h1>
    </div>
    
    <div class="buttons">
        <a onClick="ajax();" class="btn btn-info"><i class="icon-ok"></i><?php echo $button_stay; ?></a>
        <a onClick="$('#form').submit();" class="btn btn-success"><i class="icon-save"></i><?php echo $button_save; ?></a>
        <a href="<?php echo $cancel;?>" class="btn btn-danger"><font color="#FFFFFF"><i class="icon-back"></i><?php echo $button_cancel; ?></font></a>
    </div>
    
    <div class="box-content">     
    <form class="form-horizontal" role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

<!-- Invoice logo -->
    <div class="row-fluid">
        <div class="span12">
            <div class="control-group">
                <label class="control-label span2"><?php echo $entry_logo; ?></label>
                <div class="span2">
                    <div class="image" style="border:2px solid #CCC;border-radius: 05px; padding:10px;" align="center">
                        <img src="<?php echo $logo; ?>" alt="" id="thumb-logo" />
                        <input type="hidden" name="invoice_logo" value="<?php echo $invoice_logo; ?>" id="logo" />
                        <br />
                        <a onClick="image_upload('logo', 'thumb-logo');"><?php echo $text_upload; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                        <a onClick="$('#thumb-logo').attr('src', '<?php echo $no_image; ?>'); $('#logo').attr('value', '');"><?php echo $text_remove; ?></a>
                    </div>
                </div>
                <div class="span5">
                	<span style="color:#999"><?php echo $ins_logo; ?></span>
                </div>
            </div>
    	</div>
    </div>
   
 <!-- Address1,2, contact, store time-->
    <div class="row-fluid">
        <div class="span7" style="border-right:1px solid #CCC;">
            <div class="control-group ">
                <label class="control-label span3" for="module_address_1"><?php echo $entry_add1; ?></label>
                <div class="span9">
                    <input type="text" class="span12" id="module_address_1" name="module_address_1" value="<?php echo $module_address_1;?>" />
                </div>
            </div>
            
            <div class="control-group ">
                <label class="control-label span3" for="module_address_2"><?php echo $entry_add2; ?></label>
                <div class="span9">
                    <input type="text" class="span12" id="module_address_2" name="module_address_2" value="<?php echo $module_address_2;?>" />
                </div>
            </div>
            
            <div class="control-group ">
                <label class="control-label span3" for="module_contact_no"><?php echo $entry_contact; ?></label>
                <div class="span9">
                    <input type="text" class="controls span12" id="module_contact_no" name="module_contact_no" value="<?php echo $module_contact_no;?>" />
                    <div class="error" id="error_contact" style="display:none"></div>
                    <?php if ($error_contact) { ?>
                    <span class="error"><?php echo $error_contact; ?></span>
                    <?php } ?>
                </div>
            </div>
            
            <div class="control-group ">
                <label class="control-label span3" for="module_store_time"><?php echo $entry_store_time; ?></label>
                <div class="span9">
                    <input type="text" class="span12" id="module_store_time" name="module_store_time" value="<?php echo $module_store_time;?>" />
                </div>
            </div>
        </div>
        
        <div class="span5">
            <div class="control-group">
            	<label class="checkbox span7"><?php echo $entry_add_req; ?></label>
                <div class="span2">
                    <input type="checkbox" id="module_address_req" name="module_address_req" value="<?php echo $module_address_req;?>" data-toggle="toggle" <?php if($module_address_req == 1){echo "checked";}?> />
                </div>
            </div>
            <span style="color:#999"><?php echo $ins_add;?></span>     
        </div>
    </div>
<!-- End -->    
 
 <hr />
    
 <!-- Heading and Body font size $ color -->   
    <div class="row-fluid">
            <div class="span7" style="border-right:1px solid #CCC;">
                <div class="control-group">
                    <div class="span5"></div>
                    <div class="span7" align="center"><label class="control-label" for="module_title_fontsize"><?php echo $text_title; ?></label></div>
                </div>
                
                <div class="control-group">
            		<label class="control-label span3" for="module_title_fontsize"><?php echo $entry_font; ?></label>
                    <div class="span9">
            			<input type="text" class="controls span12" id="module_title_fontsize" name="module_title_fontsize" value="<?php echo $module_title_fontsize; ?>" />
                        <div class="error" id="error_tfont_size" style="display:none"></div>
                        <?php if ($error_tfont_size) { ?>
                        <span class="error"><?php echo $error_tfont_size; ?></span>
                        <?php } ?>
                    </div>
                 </div>
                 
                 <div class="control-group">
            		<label class="control-label span3" for="module_title_fontcolor"><?php echo $entry_color; ?></label>
                    <div class="span9">
            			<input type="text" class="controls span12" id="module_title_fontcolor" name="module_title_fontcolor" value="<?php echo $module_title_fontcolor; ?>" />
                        <div class="error" id="error_tfont_colour" style="display:none"></div>
                        <?php if ($error_tfont_colour) { ?>
                        <span class="error"><?php echo $error_tfont_colour; ?></span>
                        <?php } ?>
                    </div>
                 </div>
                 
                 <div class="control-group">
            		<div class="span3"></div>
                    <div class="span9"><span style="color:#999"><?php echo $ins_font;?></span></div>
                 </div>  
            </div>
            
            <div class="span5">
                <div class="control-group">
                	<div class="span3"></div>
                    <div class="span9"><label class="control-label" for="module_body_fontsize"><?php echo $text_body; ?></label></div>
                </div>
                
                <div class="control-group">
                    <div class="span12">
                    	<input type="text" class="controls span12" id="module_body_fontsize" name="module_body_fontsize" value="<?php echo $module_body_fontsize; ?>" />
                        <div class="error" id="error_bfont_size" style="display:none;"></div>
                        <?php if ($error_bfont_size) { ?>
                        <span class="error"><?php echo $error_bfont_size; ?></span>
                        <?php } ?>
                    </div>
                 </div>
                 
                 <div class="control-group">
                    <div class="span12">
            			<input type="text" class="span12" id="module_body_fontcolor" name="module_body_fontcolor" value="<?php echo $module_body_fontcolor; ?>" />
                        <div class="error" id="error_bfont_colour" style="display:none"></div>
                        <?php if ($error_bfont_colour) { ?>
                        <span class="error"><?php echo $error_bfont_colour; ?></span>
                        <?php } ?>
                    </div>
                 </div>
            </div>
     </div>
<!--End-->

 <hr /> 
    <div class="row-fluid">
        <div class="span7" style="border-right:1px solid #CCC;">
            <div class="control-group">
                <label class="control-label span3" for="module_title_bg"><?php echo $text_background; ?></label>
                <div class="span9">
                	<input type="text" class="span12 " id="module_title_bg" name="module_title_bg" value="<?php echo $module_title_bg; ?>" />
                    <div class="error" id="error_background" style="display:none"></div>
                    <?php if ($error_background) { ?>
                    <span class="error"><?php echo $error_background; ?></span>
                    <?php } ?>
                </div>
            </div>
            
            <div class="control-group">
                <div class="span3"></div>
                <div class="span9"><span style="color:#999"><?php echo $ins_bg; ?></span></div>
            </div>  
        </div>
        
        <div class="span5">
            <div class="control-group">
                <label class="checkbox span5"><?php echo $entry_title_bold; ?></label>
                <div class="span1">
                	<input type="checkbox" id="module_title_bold" name="module_title_bold" value="<?php echo $module_title_bold;?>" data-toggle="toggle" <?php if($module_title_bold == 1){echo "checked";}?> />
                </div>
            </div>
            <div class="control-group">
                <div class="span9"><span style="color:#999"><?php echo $ins_bold; ?></span></div>
            </div>  
        </div>
    </div>
  <hr /> 
  	<div class="row-fluid">
    	<div class="alert alert-info" role="alert"><?php echo $more_help; ?></div>
    </div>
</form>
    </div>
</div>
</div>

<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){
    //Title font color
    $('#module_title_fontcolor').colpick({
	layout:'hex',
	submit:0,
	onChange:function(hsb,hex,rgb,el,bySetColor) {
		$(el).css('border-color','#'+hex);
		// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
		if(!bySetColor) $(el).val(hex);
	}
	}).keyup(function(){
		$(this).colpickSetColor(this.value);
	});
	
	//Body font color
	$('#module_body_fontcolor').colpick({
	layout:'hex',
	submit:0,
	onChange:function(hsb,hex,rgb,el,bySetColor) {
		$(el).css('border-color','#'+hex);
		// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
		if(!bySetColor) $(el).val(hex);
	}
	}).keyup(function(){
		$(this).colpickSetColor(this.value);
	});
	
	//Title background color
	$('#module_title_bg').colpick({
	layout:'hex',
	submit:0,
	onChange:function(hsb,hex,rgb,el,bySetColor) {
		$(el).css('border-color','#'+hex);
		// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
		if(!bySetColor) $(el).val(hex);
	}
	}).keyup(function(){
		$(this).colpickSetColor(this.value);
	});
	
$('#module_address_req').change(function(){
	var val = $('#module_address_req').val();
	
	if(val == 1){
			$('#module_address_req').val('0');
		} 
	else if(val == 0) {
		$('#module_address_req').val('1');			
	} 
	else {
		}
	});

$('#module_title_bold').change(function(){
	var val = $('#module_title_bold').val();
	
	if(val == 1){
			$('#module_title_bold').val('0');
		} 
	else if(val == 0) {
		$('#module_title_bold').val('1');			
	} 
	else {
		}
	});

  });
  
function ajax(){
	$.ajax({
		url: 'index.php?route=module/invoice_modifier/modify&token=<?php echo $token;?>',
		method: 'POST',
		data:{
			'invoice_logo'			:$('#logo').val(),
			'module_address_1'		:$('#module_address_1').val(),
			'module_address_req'	:$('#module_address_req').val(),
			'module_address_2'		:$('#module_address_2').val(),
			'module_contact_no'		:$('#module_contact_no').val(),
			'module_store_time'		:$('#module_store_time').val(),
			'module_title_fontsize'	:$('#module_title_fontsize').val(),
			'module_title_fontcolor':$('#module_title_fontcolor').val(),
			'module_body_fontsize'	:$('#module_body_fontsize').val(),
			'module_body_fontcolor'	:$('#module_body_fontcolor').val(),
			'module_title_bg'		:$('#module_title_bg').val(),
			'module_title_bold'		:$('#module_title_bold').val(),
			},
			
		 beforeSend:function(){
			 $('span.error').hide();
			 var letters = /^[0-9a-fA-F]+$/;
			 var n = 0;
			 if($('#module_contact_no').val() == ''){ $('#module_contact_no').val('1234567890');}
			 if($('#module_title_fontsize').val() == ''){ $('#module_title_fontsize').val('12');}
			 if($('#module_body_fontsize').val() == ''){ $('#module_body_fontsize').val('12');}
			 if($('#module_title_fontcolor').val() == ''){ $('#module_title_fontcolor').val('000000');}
			 if($('#module_body_fontcolor').val() == ''){ $('#module_body_fontcolor').val('000000');}
			 if($('#module_title_bg').val() == ''){ $('#module_title_bg').val('e7efef');}
			
			if($('#module_contact_no').val() !== '' && $('#module_contact_no').val().length !== 10)
				{	
					$('#error_contact').parent().addClass('has-error');
					$('#error_contact').show().text('Please enter valid Mob. No. in 10 digit only!');
					n++;
				}
				
			else if(isNaN($('#module_contact_no').val())){
				$('#error_contact').parent().addClass('has-error');
				$('#error_contact').show().text('Alphabatic is  not allowed!');
				n++;
			}
			else{
				$('#error_contact').hide();
				$('#error_contact').parent().removeClass('has-error');
				}
			
			//font size
			if($('#module_title_fontsize').val() !== '' && $('#module_title_fontsize').val().length !== 2 ){
				$('#error_tfont_size').parent().addClass('has-error');	
				$('#error_tfont_size').show().text('Please enter only two digit and character is not allowed!');
				n++;
				}
				
			else if(isNaN($('#module_title_fontsize').val())){
				$('#error_tfont_size').parent().addClass('has-error');					
				$('#error_tfont_size').show().text('Alphabatic character is not allowed!');
				n++;
			}
			else{
					$('#error_tfont_size').hide();
					$('#error_tfont_size').parent().removeClass('has-error');
				}
			
			if($('#module_body_fontsize').val() !== '' && $('#module_body_fontsize').val().length !== 2 ){
				$('#error_bfont_size').parent().addClass('has-error');
				$('#error_bfont_size').show().text('Please enter only two digit and character is not allowed!');
				n++;
			}
			
			else if(isNaN($('#module_body_fontsize').val())){
				$('#error_bfont_size').parent().addClass('has-error');
				$('#error_bfont_size').show().text('Alphabatic character is not allowed!');
				n++;
			}
			else{
				$('#error_bfont_size').hide();
				$('#error_bfont_size').parent().removeClass('has-error');
				}			
								
			//font color
	
			if($('#module_title_fontcolor').val() !== '' && $('#module_title_fontcolor').val().length !== 6 ){
				$('#error_tfont_colour').parent().addClass('has-error');
				$('#error_tfont_colour').show().text('Atleast 6 character is required');
				n++;
				}
				
			else if($('#module_title_fontcolor').val() !== '' && !$('#module_title_fontcolor').val().match(letters)) {
					$('#error_tfont_colour').parent().addClass('has-error');
					$('#error_tfont_colour').show().text('Only 0-9 or/and a-f is allowed!');
					n++;
				}
			
			else{
				$('#error_tfont_colour').hide();
				$('#error_tfont_colour').parent().removeClass('has-error');
				} 
			
			if($('#module_body_fontcolor').val() !== '' && $('#module_body_fontcolor').val().length !== 6 ){
					$('#error_bfont_colour').parent().addClass('has-error');
					$('#error_bfont_colour').show().text('Atleast 6 character is required!');
					n++;
				}
				
			else if($('#module_body_fontcolor').val() !== '' && !$('#module_body_fontcolor').val().match(letters)) {
					$('#error_bfont_colour').parent().addClass('has-error');
					$('#error_bfont_colour').show().text('Only 0-9 or/and a-f is allowed!');
					n++;
				}
			else{
				$('#error_bfont_colour').hide();
				$('#error_bfont_colour').parent().removeClass('has-error');
				}  
			
			//title background color
			if($('#module_title_bg').val() !== '' && $('#module_title_bg').val().length !== 6 ){
				$('#error_background').parent().addClass('has-error');
				$('#error_background').show().text('Atleast 6 character is required');
				n++;
			}
			else if($('#module_title_bg').val() !== '' && !$('#module_title_bg').val().match(letters)) {
					$('#error_background').parent().addClass('has-error');
					$('#error_background').show().text('Only any combination of 0-9 or/and a-f is allowed!');
					n++;
				}
				
			else{
					$('#error_background').hide();
					$('#error_background').parent().removeClass('has-error');
				}
				
			if(n > 0){
					return false;
				}
		 },
			
		success:function(data){
			if(data){
				$('#success').addClass('alert alert-success').show().text(data).delay(5000).fadeOut(50);
			}
		},
		
		error: function() {
      		$('#success').addClass('alert alert-warning').text('Warning:Your data is not saved!').delay(5000).fadeOut(50);
   		}
		
		});	
}
</script>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					/*beforeSend:function(){
							var ext =$('#' + field).val();
							var ext = ext.substring(ext.lastIndexOf('.') + 1);
							
							if(ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG")
							{	
								$('#error_logo').hide();
								return true;
							}
							else{
								$('#error_logo').show().text('Only jpg and jpeg file are allowed!');
								return false;
								} 
						},*/
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<?php echo $footer; ?>
