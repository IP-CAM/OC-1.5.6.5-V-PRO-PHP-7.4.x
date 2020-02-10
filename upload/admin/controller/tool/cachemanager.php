<?php
class ControllerToolCachemanager extends Controller {
	private $error = array();

	public function __construct($registry) {
		parent::__construct($registry);

		// Paths and Files
		$this->base_dir = substr_replace(DIR_SYSTEM, '/', -8);
		$this->vqcache_dir = substr_replace(DIR_SYSTEM, '/vqmod/vqcache/', -8);
		$this->vqcache_files = substr_replace(DIR_SYSTEM, '/vqmod/vqcache/vq*', -8);
		$this->vqmod_modcache = substr_replace(DIR_SYSTEM, '/vqmod/mods.cache', -8); // VQMod 2.2.0

		clearstatcache();
	}
	
	public function index() {   

		$this->load->language('tool/cachemanager');
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cachemanager', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success_setting');
			
			$this->clearsystemcache();

			$this->redirect($this->url->link('tool/cachemanager', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
				
		$this->data['heading_title'] = strip_tags($this->language->get('heading_title'));

		$this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['image_description'] = $this->language->get('image_description');
		$this->data['system_description'] = $this->language->get('system_description');
		$this->data['vqmod_description'] = $this->language->get('vqmod_description');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_clearcache'] = $this->language->get('button_clearcache');
		$this->data['button_clearsystemcache'] = $this->language->get('button_clearsystemcache');
		$this->data['button_clearvqmodcache'] = $this->language->get('button_clearvqmodcache');
		$this->data['button_clear'] = $this->language->get('button_clear');
		
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_clean'] = $this->language->get('tab_clean');
		$this->data['tab_filelist'] = $this->language->get('tab_filelist');
		
		$this->data['entry_menu'] = $this->language->get('entry_menu');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_bestseller'] = $this->language->get('entry_bestseller');
		$this->data['entry_special'] = $this->language->get('entry_special');
		$this->data['entry_latest'] = $this->language->get('entry_latest');
		$this->data['entry_featured'] = $this->language->get('entry_featured');
		
		$this->data['entry_productcategory'] = $this->language->get('entry_productcategory');
		$this->data['entry_productmanufacturer'] = $this->language->get('entry_productmanufacturer');
		
		$this->data['entry_gzip'] = $this->language->get('entry_gzip');
		
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_type'] = $this->language->get('text_type');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_lifetime'] = $this->language->get('text_lifetime');
		$this->data['text_flush'] = $this->language->get('text_flush');
		$this->data['text_size'] = $this->language->get('text_size');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_filename'] = $this->language->get('text_filename');
		

		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => (strip_tags($this->language->get('heading_title'))),
			'href'      => $this->url->link('tool/cachemanager', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('tool/cachemanager', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['clearcache'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clearcache&token=' . $this->session->data['token']);
		$this->data['clearsystemcache'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clearsystemcache&token=' . $this->session->data['token']);
		$this->data['clearvqmodcache'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clearvqmodcache&token=' . $this->session->data['token']);
		
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cache'] = array();
		
		if (isset($this->request->post['cache'])) {
			$this->data['cache'] = $this->request->post['cache'];
		} else {
			$this->data['cache'] = $this->config->get('cache');
		}
		
	
		if  ($this->config->get('cache')) {
			  $this->data['cache'] = $this->config->get('cache');
			} else {
				$this->data['cache']['menu']['status'] = 1;
				$this->data['cache']['menu']['lifetime'] = 3600*24;
				$this->data['cache']['categorymodule']['status'] = 1;
				$this->data['cache']['categorymodule']['lifetime'] = 3600*24;				
				$this->data['cache']['bestsellermodule']['status'] = 0;
				$this->data['cache']['bestsellermodule']['lifetime'] = 3600;		
				$this->data['cache']['latestmodule']['status'] = 0;
				$this->data['cache']['latestmodule']['lifetime'] = 3600;	
				$this->data['cache']['specialmodule']['status'] = 0;
				$this->data['cache']['specialmodule']['lifetime'] = 3600;
				$this->data['cache']['featuredmodule']['status'] = 0;
				$this->data['cache']['featuredmodule']['lifetime'] = 3600;
				
				$this->data['cache']['productcategory']['status'] = 0;
				$this->data['cache']['productcategory']['lifetime'] = 3600;
				
				$this->data['cache']['productmanufacturer']['status'] = 0;
				$this->data['cache']['productmanufacturer']['lifetime'] = 3600;
		}	
		
		
		$this->data['clear_menu'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=menu.&token=' . $this->session->data['token']);
		$this->data['clear_categorymodule'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=module.categorymodule.&token=' . $this->session->data['token']);
		$this->data['clear_featuredmodule'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=module.featuredmodule.&token=' . $this->session->data['token']);
		$this->data['clear_bestsellermodule'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=module.bestsellermodule.&token=' . $this->session->data['token']);
		$this->data['clear_latestmodule'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=module.latestmodule.&token=' . $this->session->data['token']);
		$this->data['clear_specialmodule'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=module.specialmodule.&token=' . $this->session->data['token']);
		$this->data['clear_productcategory'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=product.category.&token=' . $this->session->data['token']);
		$this->data['clear_productmanufacturer'] = (HTTPS_SERVER . 'index.php?route=tool/cachemanager/clear&pattern=product.manufacturer.&token=' . $this->session->data['token']);
		
		
	    if  ($this->config->get('gzip')) {
			  $this->data['gzip'] = $this->config->get('gzip');
			} else {
				$this->data['gzip'] = 0;
			}
		
		$this->data['cache']['menu']['size'] = $this->getSize('menu.');
		$this->data['cache']['categorymodule']['size'] = $this->getSize('module.categorymodule.');
		$this->data['cache']['featuredmodule']['size'] = $this->getSize('module.featuredmodule.');
		$this->data['cache']['bestsellermodule']['size'] = $this->getSize('module.bestsellermodule.');
		$this->data['cache']['latestmodule']['size'] = $this->getSize('module.latestmodule.');
		$this->data['cache']['specialmodule']['size'] = $this->getSize('module.specialmodule.');
		
		$this->data['cache']['productcategory']['size'] = $this->getSize('product.category.');
		$this->data['cache']['productmanufacturer']['size'] = $this->getSize('product.manufacturer.');
		

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}		

		
		$this->data['files'] = array();
		$total = 0;
		
		foreach (glob(DIR_CACHE . 'cache.*') as $filename) {
		   	$this->data['files'][] =  array(
				'filename'      => $filename,
				'size' =>  round((filesize($filename) / 1024), 2) . 'kb'
			);
			
			$total += filesize($filename);
		}
		
		$this->data['total'] =  round($total / 1024 , 2) . 'kb';
		
		$this->template = 'tool/cachemanager.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function getSize($pattern) {
	
		$size = 0;
		$files = array ();
		$files = glob(DIR_CACHE . 'cache.'. $pattern .'*');
		if ($files) {
			foreach ($files as $filename) {
			
				$size += round((filesize($filename) / 1024), 2);
						
			};
		}
		$size .= 'kb';
		
		return $size;
	
	}
	
	
	public function clear() {
				
		if (isset($this->request->get['pattern'])){
		
			$this->load->language('tool/cachemanager');
		
			$pattern = $this->request->get['pattern'];
			
			$files = glob(DIR_CACHE . 'cache.'. $pattern .'*');
			
			if ($files) {
				foreach($files as $file){
					@unlink($file);
				}
			}		
			
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->redirect(HTTPS_SERVER . 'index.php?route=tool/cachemanager&token=' . $this->session->data['token']);		
	}
	
	
	public function clearsystemcache() {
	
		$this->load->language('tool/cachemanager');
		
		$files = glob(DIR_CACHE . 'cache.*');
		
		if ($files) {
			foreach($files as $file){
				$this->deldir($file);
			};
        }
        
		$this->session->data['success'] = $this->language->get('text_success');
		
        $this->redirect(HTTPS_SERVER . 'index.php?route=tool/cachemanager&token=' . $this->session->data['token']);		
	}
	
	public function clearvqmodcache($return = false) {
		$this->load->language('tool/cachemanager');
		
			$files = glob($this->vqcache_files);

			if ($files) {
				foreach ($files as $file) {
					if (is_file($file)) {
						@unlink($file);
					}
				}
			}

			if (is_file($this->vqmod_modcache)) {
				@unlink($this->vqmod_modcache);
			}

			if ($return) {
				return;
			}

			$this->session->data['success'] = $this->language->get('text_success');
		

		$this->redirect(HTTPS_SERVER . 'index.php?route=tool/cachemanager&token=' . $this->session->data['token']);	
	}
        
	public function clearcache() {
	
		$this->load->language('tool/cachemanager');
		
        $imgfiles = glob(DIR_IMAGE . 'cache/*');
              foreach($imgfiles as $imgfile){
                     $this->deldir($imgfile);
		}
		$this->session->data['success'] = $this->language->get('text_success');
		
        $this->redirect(HTTPS_SERVER . 'index.php?route=tool/cachemanager&token=' . $this->session->data['token']);		
		}
		
    public function deldir($dirname){   
	
		if(file_exists($dirname)) {
		
			if(is_dir($dirname)){
			
                            $dir=opendir($dirname);
							
                            while($filename=readdir($dir)){
                                    if($filename!="." && $filename!=".."){
                                        $file=$dirname."/".$filename;
					$this->deldir($file); 
                                    }
                                }
                            closedir($dir);  
                            rmdir($dirname);
                        }
			else {@unlink($dirname);}			
		}
	}
	
	
	protected function validate() {
	
		if (!$this->user->hasPermission('modify', 'tool/cachemanager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>