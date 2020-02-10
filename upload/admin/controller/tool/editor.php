<?php
class ControllerToolEditor extends Controller {
	//файлы, которым запрещен доступ на чтение
    private $files = array(
            "editor.php",
            "editor.tpl",
    );
    private $error = array(); 

    private function searchPath(){
	    $dir = explode('/',DIR_APPLICATION);
        $dir_length = count($dir)-2;
        unset($dir[$dir_length]);
        return implode("/", $dir);
	}
	
    private function searchCloseFile($path){
        $dir = explode('/',$path);
        return in_array($dir[count($dir)-1],$this->files);
	}
    
    public function index() {

	    $this->language->load('tool/editor');
	    $this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/editor', 'token=' . $this->session->data['token'] . '&path=', 'SSL'),
      		'separator' => ' :: '
   		);
		//Файлы для дерева
        $this->document->addScript('view/javascript/jquery/ui/external/jquery.bgiframe-2.1.2.js');
        $this->document->addScript('view/javascript/jquery/jstree/jquery.tree.min.js');
        $this->document->addScript('view/javascript/jquery/ajaxupload.js');
        $this->document->addScript('view/javascript/jquery/jstree/lib/jquery.cookie.js');
        $this->document->addScript('view/javascript/jquery/jstree/plugins/jquery.tree.cookie.js');
  
        //Файлы для подсветки кода
        $this->document->addStyle('view/javascript/jquery/codemirror/lib/codemirror.css');
        $this->document->addStyle('view/javascript/jquery/codemirror/theme/neo.css');
        $this->document->addScript('view/javascript/jquery/codemirror/lib/codemirror.js');
        
        $this->document->addScript('view/javascript/jquery/codemirror/addon/fold/xml-fold.js');
        $this->document->addScript('view/javascript/jquery/codemirror/addon/edit/matchtags.js');
        $this->document->addScript('view/javascript/jquery/codemirror/addon/edit/matchbrackets.js');
        $this->document->addScript('view/javascript/jquery/codemirror/addon/edit/closebrackets.js');
        $this->document->addScript('view/javascript/jquery/codemirror/addon/edit/closetag.js');
        
        $this->document->addScript('view/javascript/jquery/codemirror/mode/xml/xml.js');
        $this->document->addScript('view/javascript/jquery/codemirror/mode/clike/clike.js');
        $this->document->addScript('view/javascript/jquery/codemirror/mode/javascript/javascript.js');
        $this->document->addScript('view/javascript/jquery/codemirror/mode/css/css.js');
        $this->document->addScript('view/javascript/jquery/codemirror/mode/php/php.js');

       
        $this->data['entry_folder'] = $this->language->get('entry_folder');
        $this->data['entry_file'] = $this->language->get('entry_file');
		$this->data['entry_move'] = $this->language->get('entry_move');
		$this->data['entry_copy'] = $this->language->get('entry_copy');
		$this->data['entry_rename'] = $this->language->get('entry_rename');
		
        $this->data['button_file'] = $this->language->get('button_file');
		$this->data['button_folder'] = $this->language->get('button_folder');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_move'] = $this->language->get('button_move');
		$this->data['button_copy'] = $this->language->get('button_copy');
		$this->data['button_rename'] = $this->language->get('button_rename');
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_submit'] = $this->language->get('button_submit'); 
        $this->data['button_save'] = $this->language->get('button_save'); 
        
        $this->data['error_select'] = $this->language->get('error_select');
		$this->data['error_directory'] = $this->language->get('error_directory');
        
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_path'] = $this->language->get('text_path');
        $this->data['text_loading'] = $this->language->get('text_loading');
        $this->data['confim_delete'] = $this->language->get('confim_delete');
        
        $this->data['token'] = $this->session->data['token'];
		$this->data['directory'] = $this->searchPath();  
        
        
        $this->template = 'tool/editor.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
    
    //просмотр папок
    public function directory() {	
		$json = array();
		
        $dir_file = $this->searchPath();
        
		if (isset($this->request->post['directory'])) {
			$directories = glob(rtrim($dir_file . str_replace('../', '', $this->request->post['directory']), '/') . '/*', GLOB_NOSORT); 
			
			if ($directories) {
				$i = 0;
                $j = 0;
                sort($directories);
                reset($directories);
				foreach ($directories as $directory) {
				    if(strpos(basename($directory),"."))
				    {
				        $file[$j]['data'] = basename($directory);
                        $file[$j]['attributes']['directory'] = utf8_substr($directory, strlen($dir_file));
					
    					$children2 = glob(rtrim($directory, '/') . '/*', GLOB_NOSORT);
    					
    					if ($children2)  {
    						$file[$j]['children'] = ' ';
    					}
    					
    					$j++;
				    }
                    else
                    {
                        $json[$i]['data'] = basename($directory);
                        $json[$i]['attributes']['directory'] = utf8_substr($directory, strlen($dir_file));
					
    					$children = glob(rtrim($directory, '/') . '/*', GLOB_NOSORT);
    					
    					if ($children)  {
    						$json[$i]['children'] = ' ';
    					}
    					
    					$i++;
                    }
				}
                for($k=0;$k<$j;$k++)
                {
                    
                    $json[$i]['data'] = $file[$k]['data'];
                    $json[$i]['attributes']['directory'] = $file[$k]['attributes']['directory'];
                    $i++;
                }
			}	
		}
		
		$this->response->setOutput(json_encode($json));		
	}
    
    //переименование файлов
    public function rename() {
		$this->language->load('tool/editor');
		$dir_file = $this->searchPath();
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim($dir_file . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == $dir_file) {
				$json['error'] = $this->language->get('error_rename');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}			
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			rename($old_name, $new_name);
			
			$json['success'] = $this->language->get('text_rename');
		}
		
		$this->response->setOutput(json_encode($json));
	}
    
    //просмотр файлов
    public function read() {
		$json = array();
        $this->language->load('tool/editor');
        $dir_file = $this->searchPath();
        
        if (isset($this->request->post['path'])) {
			$path = rtrim($dir_file . str_replace('../', '', $this->request->post['path']), '/');
		} else {
		    $path = $dir_file;
		}
	
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        switch($extension){
            case "php": $json['ext'] = "php"; break;
            case "js": $json['ext'] = "javascript"; break;
            case "html": $json['ext'] = "xml"; break;
            case "tpl": $json['ext'] = "xml"; break;
            case "ini": $json['ext'] = "php"; break;
            case "css": $json['ext'] = "css"; break;
            case "xml": $json['ext'] = "xml"; break;
            case "xml_": $json['ext'] = "xml"; break;
            case "txt": $json['ext'] = "xml"; break;
            default: $json['ext'] = "error";
        }

        if($this->searchCloseFile($path)){
            $json['ext'] = "error";
        }
        
        if($json['ext'] != "error")
        {
             $json['text']= file_get_contents($path);
             if(mb_detect_encoding($json['text'], array('UTF-8','Windows-1251'), TRUE)){
                if(!$json['text'])
                    $json['error'] = $this->language->get('error_read_file');
                else 
                    $json['success']= 1;
            }
            else 
            {
                $json['text']=iconv("Windows-1251", "UTF-8", $json['text']); 
                $json['success']= 1;
            }
        }
        else
            $json['error'] = $this->language->get('error_file_type');
    	$this->response->setOutput(json_encode($json));
    }
  
    //создание папки
    public function create() {
		$this->language->load('tool/editor');
		$dir_file = $this->searchPath();		
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if (isset($this->request->post['name']) || $this->request->post['name']) {
				$directory = rtrim($dir_file . str_replace('../', '', $this->request->post['directory']), '/');							   
				
				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}
				
				if (file_exists($directory . '/' . str_replace('../', '', $this->request->post['name']))) {
					$json['error'] = $this->language->get('error_exists');
				}
			} else {
				$json['error'] = $this->language->get('error_name');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {	
			mkdir($directory . '/' . str_replace('../', '', $this->request->post['name']), 0777);
			
			$json['success'] = $this->language->get('text_create');
		}	
		
		$this->response->setOutput(json_encode($json));
	}
    
    //создание файла
    public function file() {
        $dir_file = $this->searchPath();
		$this->language->load('tool/editor');
				
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if (isset($this->request->post['name']) || $this->request->post['name']) {
				$directory = rtrim($dir_file . str_replace('../', '', $this->request->post['directory']), '/');							   
				
				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}
				
				if (file_exists($directory . '/' . str_replace('../', '', $this->request->post['name']))) {
					$json['error'] = $this->language->get('error_exists');
				}
			} else {
				$json['error'] = $this->language->get('error_name');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
		    file_put_contents($directory .'/'. $this->request->post['name'],' ');

			$json['success'] = $this->language->get('text_success');
		}	
		
		$this->response->setOutput(json_encode($json));
	}
    
    //удаление файлов и папок
    public function delete() {
        $dir_file = $this->searchPath();
		$this->language->load('tool/editor');
		
		$json = array();
		
		if (isset($this->request->post['path'])) {
			$path = rtrim($dir_file . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			 
			if (!file_exists($path)) {
				$json['error'] = $this->language->get('error_select');
			}
			
			if ($path == rtrim($dir_file , '/')) {
				$json['error'] = $this->language->get('error_delete');
			}
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			if (is_file($path)) {
				unlink($path);
			} elseif (is_dir($path)) {
				$files = array();
				
				$path = array($path . '*');
				
				while(count($path) != 0) {
					$next = array_shift($path);
                    if(glob($next))
                    {
    					foreach(glob($next) as $file) {
    						if (is_dir($file)) {
    							$path[] = $file . '/*';
    						}
    						
    						$files[] = $file;
    					}
                    }
				}
				
				rsort($files);
				
				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					} elseif(is_dir($file)) {
						rmdir($file);	
					} 
				}				
			}
			
			$json['success'] = $this->language->get('text_delete');
		}				
		
		$this->response->setOutput(json_encode($json));
	}
    
    //перемещение файлов и папок
    public function move() {
        $dir_file = $this->searchPath();
		$this->language->load('tool/editor');
		
		$json = array();
		
		if (isset($this->request->post['from']) && isset($this->request->post['to'])) {
			$from = rtrim($dir_file . str_replace('../', '', html_entity_decode($this->request->post['from'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($from)) {
				$json['error'] = $this->language->get('error_missing');
			}
			
			if ($from == $dir_file) {
				$json['error'] = $this->language->get('error_default');
			}
			
			$to = rtrim($dir_file . str_replace('../', '', html_entity_decode($this->request->post['to'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($to)) {
				$json['error'] = $this->language->get('error_move');
			}	
			
			if (file_exists($to . '/' . basename($from))) {
				$json['error'] = $this->language->get('error_exists');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			rename($from, $to . '/' . basename($from));
			
			$json['success'] = $this->language->get('text_move');
		}
		
		$this->response->setOutput(json_encode($json));
	}	
	
    //копирование файлов и папок
	public function copy() {
	   $dir_file = $this->searchPath();
		$this->language->load('tool/editor');
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim($dir_file . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == $dir_file) {
				$json['error'] = $this->language->get('error_copy');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}			
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}	
		
		if (!isset($json['error'])) {
			if (is_file($old_name)) {
				copy($old_name, $new_name);
			} else {
				$this->recursiveCopy($old_name, $new_name);
			}
			
			$json['success'] = $this->language->get('text_copy');
		}
		
		$this->response->setOutput(json_encode($json));	
	}
    
    private function recursiveCopy($source, $destination) { 
		$directory = opendir($source); 
		
		@mkdir($destination); 
		
		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) { 
				if (is_dir($source . '/' . $file)) { 
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file); 
				} else { 
					copy($source . '/' . $file, $destination . '/' . $file); 
				} 
			} 
		} 
		
		closedir($directory); 
	} 
    
    public function folders() {
        $dir_file = $this->searchPath();
		$this->response->setOutput($this->recursiveFolders($dir_file));	
	}
    
    private function recursiveFolders($directory) {
        $dir_file = $this->searchPath();
		$output = '';
		
		$output .= '<option value="' . utf8_substr($directory, strlen($dir_file)) . '">' . utf8_substr($directory, strlen($dir_file)) . '</option>';
		
		$directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);
		
		foreach ($directories  as $directory) {
			$output .= $this->recursiveFolders($directory);
		}
		
		return $output;
	}
    
    //сохранение файла
    public function save() {
        $dir_file = $this->searchPath();
		$this->language->load('tool/editor');
		
		$json = array();
		
		if (isset($this->request->post['path'])) {
			$path = $this->request->post['path'];
			 
			if (!isset($this->request->post['text'])) {
				$json['error'] = $this->language->get('error_text');
			}
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
        
		
		if (!isset($json['error'])) {
   
            $text = file_put_contents($dir_file . $path,html_entity_decode($this->request->post['text'], ENT_QUOTES, 'UTF-8')); //fwrite($file, html_entity_decode($this->request->post['text'], ENT_QUOTES, 'UTF-8')); // Запись в файл
            
            if ($text) 
                $json['success']= $this->language->get('text_success');
            else 
                $json['error']= $this->language->get('error_uploaded');
            
            
		}
        $this->response->setOutput(json_encode($json));

	}
    
    //загрузка файлов
    public function upload() {
		$this->language->load('common/filemanager');
		$dir_file = $this->searchPath();
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if ($this->request->files['image']['tmp_name']) {
				$filename = basename(html_entity_decode($this->request->files['image']['name'], ENT_QUOTES, 'UTF-8'));
				
				if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
					$json['error'] = $this->language->get('error_filename');
				}
					
				$directory = rtrim($dir_file . str_replace('../', '', $this->request->post['directory']), '/');
				
				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}

                /*
				$allowed = array(
					'.jpg',
					'.jpeg',
					'.gif',
					'.png',
					'.flv'
				);
						
				if (!in_array(strtolower(strrchr($filename, '.')), $allowed)) {
					$json['error'] = $this->language->get('error_file_type');
				}*/


				if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'error_upload_' . $this->request->files['image']['error'];
				}			
			} else {
				$json['error'] = $this->language->get('error_file');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
		if (!$this->user->hasPermission('modify', 'tool/editor')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {	
			if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . '/' . $filename)) {		
				$json['success'] = $this->language->get('text_uploaded');
			} else {
				$json['error'] = $this->language->get('error_uploaded');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
}
?>