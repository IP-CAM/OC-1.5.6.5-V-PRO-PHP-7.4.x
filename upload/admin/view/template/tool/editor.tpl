<div id="loading-layer"><?php echo $text_loading; ?></div>
<?php echo $header; ?>
<div id="content">
  <div class="box">
    <div class="heading">
        <h1><img src="view/image/product.png" alt="OpenShop File Code Editor" /> <?php echo $heading_title; ?></h1>
        <div style="float: right; padding-top:5px;">
            <a id="file" class="button-file" style="background-image: url('view/image/filemanager/file.png'); height:13px;" title="<?php echo $button_file; ?>"></a>
            <a id="create" class="button-file" style="background-image: url('view/image/filemanager/folder.png'); height:13px;" title="<?php echo $button_folder; ?>"></a>
            <a id="delete" class="button-file" style="background-image: url('view/image/filemanager/edit-delete.png'); height:13px;" title="<?php echo $button_delete; ?>"></a>
            <a id="move" class="button-file" style="background-image: url('view/image/filemanager/edit-cut.png'); height:13px;" title="<?php echo $button_move; ?>"></a>
            <a id="copy" class="button-file" style="background-image: url('view/image/filemanager/edit-copy.png'); height:13px;" title="<?php echo $button_copy; ?>"></a>
            <a id="rename" class="button-file" style="background-image: url('view/image/filemanager/edit-rename.png'); height:13px;" title="<?php echo $button_rename; ?>"></a>
            <a id="upload" class="button-file" style="background-image: url('view/image/filemanager/upload.png'); height:13px;" title="<?php echo $button_upload; ?>"></a>
	        <a id="refresh" class="button-file" style="background-image: url('view/image/filemanager/refresh.png'); height:13px;" title="<?php echo $button_refresh; ?>"></a>
        </div>
    </div>
    <div class="content">
    <div id='path'><em><?php echo $text_path; ?></em> <span></span><br /></div>
    <div id="column-right"></div>
    <div id="column-left"> 
	<a id="save" class="button" title="<?php echo $button_save; ?>"><span><?php echo $button_save; ?></span></a>
	<p>
        <textarea id="code" wrap="off" name="code"></textarea>
	</p>
	<a id="save" class="button" title="<?php echo $button_save; ?>"><span><?php echo $button_save; ?></span></a>
    </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript"><!--
    var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
        autoCloseTags: true,   // auto creation of closing tags
        matchBrackets: true,   
        autoCloseBrackets: true,  // auto creation of closing brackets
    	lineNumbers: true, // showing line numbers
    	dragDrop: false,   // prohibition of dragging
        indentUnit: 4,
        indentWithTabs: false,
        mode: "text/html",  // default mode
        matchTags: {bothTags: true},
        extraKeys: {"Ctrl-J": "toMatchingTag"}
    });
    
    function ShowLoading()
    {	
    	var setX = ( $(window).width()  - $("#loading-layer").width()  ) / 2;
    	var setY = ( $(window).height() - $("#loading-layer").height() ) / 2;
    			
    	$("#loading-layer").css( {
    		left : setX + "px",
    		top : setY + "px",
    		position : 'fixed',
    		zIndex : '99'
    	});	
    	$("#loading-layer").fadeTo('slow', 1.0);
    
    };
    
    function HideLoading( message )
    {
    	$("#loading-layer").fadeOut('slow');
    };

//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
    $('#column-right').tree({
		plugins : {cookie : {}},
		data: { 
			type: 'json',
			async: true, 
			opts: { 
				method: 'post', 
				url: 'index.php?route=tool/editor/directory&token=<?php echo $token; ?>'
			} 
		},
		selected: 'top',
		ui: {		
			theme_name: 'apple',
			animation: 400
		},	
		types: { 
			'default': {
				clickable: true,
				creatable: true,
				renameable: true,
				deletable: true,
				draggable: true,
				max_children: -1,
				max_depth: -1,
				valid_children: 'all'
			}
		},
		callback: {
			beforedata: function(NODE, TREE_OBJ) { 
				if (NODE == false) {
					TREE_OBJ.settings.data.opts.static = [ 
						{
							data: '/',
							attributes: { 
								'id': 'top',
								'directory': ''
							}, 
							state: 'closed',
						}
					];
					
					return { 'directory': '' } 
				} else {
					TREE_OBJ.settings.data.opts.static = false;  
					
					return { 'directory': $(NODE).attr('directory') } 
				}
			},		
            onopen: function(TREE_OBJ) {
				var tr = $('#column-right li#top li[directory]');

				tr.each(function(index, domEle) {
					dd = $(domEle).attr('directory');
					dd = dd.replace(/\//g, "");
					dd = dd.replace(/\s/g, "");
					$(domEle).attr('id', dd);
                    if ($(domEle).attr('directory').indexOf('.php')!=-1){
                        $(domEle).attr('class', 'php');
                    }else 
                    if ($(domEle).attr('directory').indexOf('.txt')!=-1){
                        $(domEle).attr('class', 'txt');
                    }else
                    if ($(domEle).attr('directory').indexOf('.css')!=-1){
                        $(domEle).attr('class', 'css');
                    }else
                    if ($(domEle).attr('directory').indexOf('.js')!=-1){
                        $(domEle).attr('class', 'js');
                    }else
                    if ($(domEle).attr('directory').indexOf('.ini')!=-1){
                        $(domEle).attr('class', 'ini');
                    }else
					if ($(domEle).attr('directory').indexOf('.html')!=-1 || $(domEle).attr('directory').indexOf('.tpl')!=-1){
                        $(domEle).attr('class', 'html');
                    }else
                    if ($(domEle).attr('directory').indexOf('.')!=-1){
                        $(domEle).attr('class', 'no');
                    }
                   
				});
                
				var myTree = $.tree.reference('#column-right');
				var cc = $.cookie('selected');
				var bb = '#' + cc;
				/*myTree.select_branch(bb);*/
			}
		}
	});	

    // extract the contents of the selected file
    $('#column-right a').live('dblclick', function() {
		if ($(this).attr('class') != 'selected') {
		    var s=$(this).parent().attr('directory');
            if(s.indexOf('.')!=-1) {
			    $.ajax({
                url: 'index.php?route=tool/editor/read&token=<?php echo $token; ?>',
                type: 'post',
                data: 'path=' + s,
                dataType: 'json',
                beforeSend: function() { ShowLoading(); },	
        		complete: function() { HideLoading(); },	
                success: function(json) {
                    if (json['success']) {
                    	$('#path > span').html(s);
                        editor.setOption("mode",json['ext']);
                        editor.setValue(json['text']);
                    }
                    if (json.error) {
    					alert(json.error);
    		        }
                }
	           }); 
            }
			$(this).attr('class', 'clicked');
		}
	});
    
    // renaming
    $('#rename').bind('click', function() {
		$('#dialog').remove();
		var tree = $.tree.focused();
		html  = '<div id="dialog">';
		html += '<?php echo $entry_rename; ?> <input type="text" name="name" value="'+ encodeURIComponent($(tree.selected).children().html().substring($(tree.selected).children().html().indexOf('/ins>')+ 5)) +'" /> <input type="button" value="<?php echo $button_submit; ?>" />';
		html += '</div>';

		$('#column-right').prepend(html);
		
		$('#dialog').dialog({
			title: '<?php echo $button_rename; ?>',
			resizable: false
		});
		
		$('#dialog input[type=\'button\']').bind('click', function() {
			path = $('#column-right a.selected').attr('directory');
							 
			if (path) {		
				$.ajax({
					url: 'index.php?route=tool/editor/rename&token=<?php echo $token; ?>',
					type: 'post',
					data: 'path=' + encodeURIComponent(path) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							var tree = $.tree.focused();
					
							tree.select_branch(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});			
			} else {
				var tree = $.tree.focused();
				
				$.ajax({ 
					url: 'index.php?route=tool/editor/rename&token=<?php echo $token; ?>',
					type: 'post',
					data: 'path=' + encodeURIComponent($(tree.selected).attr('directory')) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
                    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
								
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		});		
	});
    
    // catalog creation
    $('#create').bind('click', function() {
		var tree = $.tree.focused();
		
		if (tree.selected) {
			$('#dialog').remove();
			
			html  = '<div id="dialog">';
			html += '<?php echo $entry_folder; ?> <input type="text" name="name" value="" /> <input type="button" value="<?php echo $button_submit; ?>" />';
			html += '</div>';
			
			$('#column-right').prepend(html);
			
			$('#dialog').dialog({
				title: '<?php echo $button_folder; ?>',
				resizable: false
			});	
			
			$('#dialog input[type=\'button\']').bind('click', function() {
				$.ajax({
					url: 'index.php?route=tool/editor/create&token=<?php echo $token; ?>',
					type: 'post',
					data: 'directory=' + encodeURIComponent($(tree.selected).attr('directory')) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							tree.refresh(tree.selected);
							
						} else {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			});
		} else {
			alert('<?php echo $error_directory; ?>');	
		}
	});
    
    // file creation
    $('#file').bind('click', function() {
		var tree = $.tree.focused();
		
		if (tree.selected) {
			$('#dialog').remove();
			
			html  = '<div id="dialog">';
			html += '<?php echo $entry_file; ?> <input type="text" name="name" value="" /> <input type="button" value="<?php echo $button_submit; ?>" />';
			html += '</div>';
			
			$('#column-right').prepend(html);
			
			$('#dialog').dialog({
				title: '<?php echo $button_file; ?>',
				resizable: false
			});	
			
			$('#dialog input[type=\'button\']').bind('click', function() {
				$.ajax({
					url: 'index.php?route=tool/editor/file&token=<?php echo $token; ?>',
					type: 'post',
					data: 'directory=' + encodeURIComponent($(tree.selected).attr('directory')) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							tree.refresh(tree.selected);
                            alert(json.success);
						} else {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			});
		} else {
			alert('<?php echo $error_select; ?>');	
		}
	});

    // deletion
    $('#delete').bind('click', function() {
        if (!confirm('<?=$confim_delete?>')) {
                return false;
            }
		path = $('#column-right a.selected').attr('value');
		if (path) {
			$.ajax({
				url: 'index.php?route=tool/editor/delete&token=<?php echo $token; ?>',
				type: 'post',
				data: 'path=' + encodeURIComponent(path),
				dataType: 'json',
                beforeSend: function() { ShowLoading(); },	
        		complete: function() { HideLoading(); },	
				success: function(json) {
					if (json.success) {
						var tree = $.tree.focused();
					
						tree.select_branch(tree.selected);
						editor.setValue('');
						
					}
					
					if (json.error) {
						alert(json.error);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});				
		} else {
			var tree = $.tree.focused();
			
			if (tree.selected) {
				$.ajax({
					url: 'index.php?route=tool/editor/delete&token=<?php echo $token; ?>',
					type: 'post',
					data: 'path=' + encodeURIComponent($(tree.selected).attr('directory')),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							tree.select_branch(tree.parent(tree.selected));
							editor.setValue('');
							tree.refresh(tree.selected);
							
						} 
						
						if (json.error) {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});			
			} else {
				alert('<?php echo $error_select; ?>');
			}			
		}
	});
    
    // moving
    $('#move').bind('click', function() {
		$('#dialog').remove();
		$('.ui-dialog').attr('width','680');
		html  = '<div id="dialog">';
		html += '<?php echo $entry_move; ?> <select name="to" ></select> <input type="button" value="<?php echo $button_submit; ?>" />';
		html += '</div>';

		$('#column-right').prepend(html);
		
		$('#dialog').dialog({
			title: '<?php echo $button_move; ?>',
			resizable: false,
            width: 700
		});

		$('#dialog select[name=\'to\']').load('index.php?route=tool/editor/folders&token=<?php echo $token; ?>');
		
		$('#dialog input[type=\'button\']').bind('click', function() {
			path = $('#column-right a.selected').find('input[name=\'image\']').attr('value');
							 
			if (path) {																
				$.ajax({
					url: 'index.php?route=tool/editor/move&token=<?php echo $token; ?>',
					type: 'post',
					data: 'from=' + encodeURIComponent(path) + '&to=' + encodeURIComponent($('#dialog select[name=\'to\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							var tree = $.tree.focused();
							
							tree.select_branch(tree.selected);
							
						}
						
						if (json.error) {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			} else {
				var tree = $.tree.focused();
				
				$.ajax({
					url: 'index.php?route=tool/editor/move&token=<?php echo $token; ?>',
					type: 'post',
					data: 'from=' + encodeURIComponent($(tree.selected).attr('directory')) + '&to=' + encodeURIComponent($('#dialog select[name=\'to\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							tree.select_branch('#top');
								
							tree.refresh(tree.selected);
							
						}						
						
						if (json.error) {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});				
			}
		});
	});

    // copying
	$('#copy').bind('click', function() {
		$('#dialog').remove();
		
		html  = '<div id="dialog">';
		html += '<?php echo $entry_copy; ?> <input type="text" name="name" value="" /> <input type="button" value="<?php echo $button_submit; ?>" />';
		html += '</div>';

		$('#column-right').prepend(html);
		
		$('#dialog').dialog({
			title: '<?php echo $button_copy; ?>',
			resizable: false
		});
		
		$('#dialog select[name=\'to\']').load('index.php?route=tool/editor/folders&token=<?php echo $token; ?>');
		
		$('#dialog input[type=\'button\']').bind('click', function() {
			path = $('#column-right a.selected').find('input[name=\'image\']').attr('value');
							 
			if (path) {																
				$.ajax({
					url: 'index.php?route=tool/editor/copy&token=<?php echo $token; ?>',
					type: 'post',
					data: 'path=' + encodeURIComponent(path) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							var tree = $.tree.focused();
							
							tree.select_branch(tree.selected);
							
							alert(json.success);
						}						
						
						if (json.error) {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			} else {
				var tree = $.tree.focused();
				
				$.ajax({
					url: 'index.php?route=tool/editor/copy&token=<?php echo $token; ?>',
					type: 'post',
					data: 'path=' + encodeURIComponent($(tree.selected).attr('directory')) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
                    beforeSend: function() { ShowLoading(); },	
        		    complete: function() { HideLoading(); },	
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 						
						
						if (json.error) {
							alert(json.error);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});				
			}
		});	
	});
    
    // save file
    $('#save').bind('click', function() {
		var tree = $.tree.focused();
		var text = editor.getValue();
		$.ajax({
			url: 'index.php?route=tool/editor/save&token=<?php echo $token; ?>',
			type: 'post',
			data: 'path=' + encodeURIComponent($(tree.selected).attr('directory')) + '&text=' + encodeURIComponent(text),
			dataType: 'json',
            beforeSend: function() { ShowLoading(); },	
		    complete: function() { HideLoading(); },	
			success: function(json) {
				if (json.success) {
					alert(json.success);
				} 						
				
				if (json.error) {
					alert(json.error);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});					
	});
    
    // directory update
    $('#refresh').bind('click', function() {
		var tree = $.tree.focused();
		tree.refresh(tree.selected);
	});
    new AjaxUpload('#upload', {
		action: 'index.php?route=tool/editor/upload&token=<?php echo $token; ?>',
        name: 'image',
		autoSubmit: false,
		responseType: 'json',
		onChange: function(file, extension) {
			var tree = $.tree.focused();
			
			if (tree.selected) {
				this.setData({'directory': $(tree.selected).attr('directory')});
			} else {
				this.setData({'directory': ''});
			}
			
			this.submit();
		},
		onSubmit: function(file, extension) {
			$('#upload').append('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		},
		onComplete: function(file, json) {
			if (json.success) {
				var tree = $.tree.focused();
			    tree.refresh(tree.selected);
                           
				alert(json.success);
			}
			
			if (json.error) {
				alert(json.error);
			}
			
			$('.loading').remove();	
		}
	});
});	
//--></script>