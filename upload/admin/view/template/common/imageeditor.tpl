<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/imageeditor/imageeditor.css" />
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/imageeditor/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/imageeditor/jquery.tipTip.min.js"></script>
<script type="text/javascript"><!--
$(document).ready(function () {
	$(".tip").tipTip();
	var image_array = new Array('<?php echo $imagename;?>');
	var image_index = 0;
	var obj_jcrop;
	$('#target').Jcrop({
		trueSize:[<?php echo $truewidth;?>, <?php echo $trueheight;?>],//trueSize: [parseInt($('#tw').val()),parseInt($('#th').val())],
		onChange: showCoords,
		onSelect: showCoords
	}, function(){
		obj_jcrop = this;
	});
	
	function showCoords(c)
	{
		$('#x1').val(c.x);
		$('#y1').val(c.y);
		$('#x2').val(c.x2);
		$('#y2').val(c.y2);
	};
	
	$('#sw').blur(function(){
		var tw = Math.round($('#tw').val());
		var th = Math.round($('#th').val());
		var sw = Math.round($('#sw').val());
		if (sw > 0){
			$('#sh').val(Math.round(sw*th/tw));
			$('#scale').removeClass('disabled');
		}else{
			$('#scale').addClass('disabled');
		}
	});
	$('#sh').blur(function(){
		var tw = Math.round($('#tw').val());
		var th = Math.round($('#th').val());
		var sh = Math.round($('#sh').val());
		if (sh > 0){
			$('#sw').val(Math.round(sh*tw/th));
			$('#scale').removeClass('disabled');
		}else{
			$('#scale').addClass('disabled');
		}
	});
	
	function refresh(json){
		$('#tw').val(json.width);
		$('#th').val(json.height);
		$('#target').attr('src', json.src);
		$('#target').attr('title', json.newname);
		$('#target').attr('width', json.fixwidth);
		$('#target').attr('height', json.fixheight);
		$('#originalsize').html(json.width + 'x' + json.height);
		obj_jcrop.destroy();
		$('#target').Jcrop({
			trueSize: [json.width, json.height],
			onChange: showCoords,
			onSelect: showCoords
		}, function(){
			obj_jcrop = this;
		});
		
		if (json.undo || json.redo){
			if (image_array.length > 1 && image_index > 0){
				$('#undo').removeClass('disabled');
			}else{
				$('#undo').addClass('disabled');
			}
			if (image_index + 1 < image_array.length){
				$('#redo').removeClass('disabled');
			}else{
				$('#redo').addClass('disabled');
			}
		}else{
			if (image_index + 1 == image_array.length){
				image_array.push(json.newname);
				image_index++;
			}else{
				image_array.splice(image_index, image_array.length - image_index + 1, json.newname);
				image_index = image_array.length - 1;
			}
			$('#undo').removeClass('disabled');
			$('#redo').addClass('disabled');
		}
	};
	
	function showMaskLayer(){
		$('#loading').css({left: parseInt(($('.masklayer').width() - 31)/2) + 'px', top:parseInt(($('.masklayer').height() - 31)/2) + 'px', position:'absolute'});
		$('.masklayer').show();
	}
	function hideMaskLayer(){
		$('.masklayer').hide();
	}
	
	$('#buttons > a').bind('click',function(event){
		var ajax_url, ajax_data;
		var s_image = $('#target').attr('title');
		switch($(this).attr('id')){
			case 'scale':
				if ($('#sw').val() <= 0 || $('#sw').val() == 'NaN' || $('#sh').val() <= 0 || $('#sh').val() == 'NaN'){
					alert('<?php echo $select_size_error;?>');
					event.preventDefault();
					return;
				}
				ajax_url = 'index.php?route=common/imageeditor/scaleimage&token=<?php echo $token; ?>';
				ajax_data = 'width=' + Math.round($('#sw').val()) + '&height=' + Math.round($('#sh').val()) + '&image=' + s_image;
				break;
			case 'crop':
				if ($('#x1').val() == $('#x2').val() || $('#y1').val() == $('#y2').val()){
					alert('<?php echo $select_size_error;?>');
					event.preventDefault();
					return;
				}
				ajax_url = 'index.php?route=common/imageeditor/cropimage&token=<?php echo $token; ?>';
				ajax_data = 'x1=' + $('#x1').val() + '&y1=' + $('#y1').val() + '&x2=' + $('#x2').val() + '&y2=' + $('#y2').val() + '&image=' + s_image;
				break;
			case 'rotate_counter':
				ajax_url = 'index.php?route=common/imageeditor/rotateimage&token=<?php echo $token; ?>';
				ajax_data = 'd=-90&image=' + s_image;
				break;
			case 'rotate_clockwise':
				ajax_url = 'index.php?route=common/imageeditor/rotateimage&token=<?php echo $token; ?>';
				ajax_data = 'd=90&image=' + s_image;
				break;
			case 'flipv':
				ajax_url = 'index.php?route=common/imageeditor/flipimage&token=<?php echo $token; ?>';
				ajax_data = 'f=1&image=' + s_image;
				break;
			case 'fliph':
				ajax_url = 'index.php?route=common/imageeditor/flipimage&token=<?php echo $token; ?>';
				ajax_data = 'f=2&image=' + s_image;
				break;
			case 'undo':
				if (image_array.length > 0 && image_index > 0){
					image_index--;
					s_image = image_array[image_index];
					ajax_url = 'index.php?route=common/imageeditor/redoundo&token=<?php echo $token; ?>';
					ajax_data = 'd=u&image=' + s_image;
				}else{
					event.preventDefault();
					return;
				}
				break;
			case 'redo':
				if (image_index + 1 < image_array.length){
					image_index++;
					s_image = image_array[image_index];
					ajax_url = 'index.php?route=common/imageeditor/redoundo&token=<?php echo $token; ?>';
					ajax_data = 'd=r&image=' + s_image;
				}else{
					event.preventDefault();
					return;
				}
				break;
			default:
				event.preventDefault();
				return;
		}
		$.ajax({ 
			url: ajax_url,
			type: 'POST',
			data: ajax_data,
			dataType: 'json',
			beforeSend:function(XMLHttpRequest){
				showMaskLayer();
            },
			complete:function(XMLHttpRequest,textStatus){
				hideMaskLayer();
			},
			success: function(json) {
				if (json.error) {
					alert(json.error);
				}else{
					refresh(json);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){  
				alert(XMLHttpRequest.readyState + XMLHttpRequest.status + XMLHttpRequest.responseText); 
			}
		});
		event.preventDefault();
	});
	
	
	$('#cancel').click(function(event){
		$('#editorwindow', parent.document.body).hide();
		$('#editorwindow', parent.document.body).contents().find('#container').html('');
		event.preventDefault();
	});
	
	$('#submit').click(function(event){
		var s_image = $('#target').attr('title');
		var o_image = $('#oi').val();
		$.ajax({ 
			url: 'index.php?route=common/imageeditor/saveimage&token=<?php echo $token; ?>',
			type: 'POST',
			data: 'image=' + s_image + '&oi=' + o_image,
			dataType: 'json',
			beforeSend:function(XMLHttpRequest){
				showMaskLayer();
            },
			complete:function(XMLHttpRequest,textStatus){
				hideMaskLayer();
			},
			success: function(json) {
				if (json.error) {
					alert(json.error);
				}else{
					window.parent.filemanager_refresh();
					$('#editorwindow', parent.document.body).hide(); $('#editorwindow', parent.document.body).contents().find('#container').html('');
				}
			}
		});
		event.preventDefault();
	});
});


//-->
</script>
</head>
<body>
<div id="container">
<?php if (isset($error)){?>
	<div class="error"><?php echo $error;?></div>
<?php }else{?>
	<div style="float:left; margin:10px;">
		<img id="target" title="<?php echo $imagename;?>" src="<?php echo $targetimage;?>" width="<?php echo $fixwidth; ?>" height="<?php echo $fixheight;?>"/>
	</div>
	<div style="float:right; margin:10px 10px;">
		<div id="buttons" class="buttons">
			<a id="scale" href="#" class="tip button scale left disabled" title="<?php echo $scale_image;?>">&nbsp;&nbsp;&nbsp;</a><a id="crop" href="#" class="tip button crop middle" title="<?php echo $crop_image;?>">&nbsp;&nbsp;&nbsp;</a><a id="rotate_counter" href="#" class="tip button rotate-left middle" title="<?php echo $rotate_counter;?>">&nbsp;&nbsp;&nbsp;</a><a id="rotate_clockwise" href="#" class="tip button rotate-right middle" title="<?php echo $rotate_clockwise;?>">&nbsp;&nbsp;&nbsp;</a><a id="flipv" href="#" class="tip button flipv middle" title="<?php echo $flip_vertically;?>">&nbsp;&nbsp;&nbsp;</a><a id="fliph" href="#" class="tip button fliph middle" title="<?php echo $flip_horizontally;?>">&nbsp;&nbsp;&nbsp;</a><a id="undo" href="#" class="tip button undo middle disabled" title="<?php echo $undo;?>">&nbsp;&nbsp;&nbsp;</a><a id="redo" href="#" class="tip button redo right disabled" title="<?php echo $redo;?>">&nbsp;&nbsp;&nbsp;</a>
		</div>
		<div id="priview-container" style="overflow:hidden; display:none;">
			<img src="<?php if (isset($image)){echo $image;}?>" width="0" height="0" id="preview" alt="Preview">
		</div>
		<br/>
		<div id="image_info" style="display:none;">
			<input type="hidden" id="x1"/>
			<input type="hidden" id="y1"/>
			<input type="hidden" id="x2"/>
			<input type="hidden" id="y2"/>
			<input type="hidden" id="fw" value="<?php echo $fixwidth;?>" />
			<input type="hidden" id="fh" value="<?php echo $fixheight;?>" />
			<input type="hidden" id="tw" value="<?php echo $truewidth;?>" />
			<input type="hidden" id="th" value="<?php echo $trueheight;?>" />
			<input type="hidden" id="oi" value="<?php echo $originalimage;?>" />
		</div>
		<div class="buttons">
			<div class="original-size">Original Dimensions: <span id="originalsize"><?php echo $truewidth . 'x' . $trueheight;?></span><p class="scale-desc"><?php echo $scale_description;?></p></div>
			<div id="scale_size">Scale Size: <input type="text" size="2" id="sw" />x<input type="text" size="2" id="sh" /></div>
		</div>
	</div>
	<div class="bottombuttons">
		<a id="submit" href="#" class="button big">Save</a><a id="cancel" href="#" class="button big">Cancel</a>
	</div>
	<div class="masklayer"><img id="loading" src="view/javascript/jquery/imageeditor/images/loading.gif" /></div>
<?php }?>
</div>
</body>
</html>