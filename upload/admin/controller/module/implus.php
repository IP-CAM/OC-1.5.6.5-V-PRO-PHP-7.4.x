<?php
class ControllerModuleImplus extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/implus');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('implus', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
	$language_info = array(
	'heading_title',					'button_save',				'button_cancel',				'tab_general',
	'tab_config',						'tab_watermark',			'tab_autoresize',				'text_enabled',
	'text_disabled',					'text_megabytes',			'text_kilobytes',				'entry_width',
	'entry_height',						'entry_language',			'entry_thumb_size',				'entry_copy_overwrite',
	'entry_upload_overwrite',			'entry_upload_max_size',	'entry_drag_upload_allow',		'entry_lazy_load',	
	'entry_lazy_load_treshold',			'entry_only_images',		'entry_status',		   'entry_watermark_margin_right',
	'entry_watermark_margin_bottom',	'entry_watermark_quality',	'info_watermark',	   'entry_watermark_transparency', 
	'entry_resize_max_width',			'entry_resize_max_height',	'entry_resize_quality',			'info_resize', 
	'entry_watermark',					'text_browse',				'text_clear',					'text_image_manager',
	'tab_design',						'entry_toolbar_image',		'text_toolbar_image',			
	'entry_theme_toolbar_bg_color', 	'info_extra',				'info_colors',					'entry_status_design',
	'entry_theme_toolbar_bg_color',		'entry_theme_left_panel',	'entry_theme_right_panel',		'entry_theme_hower',
	'entry_theme_icon_color',			'entry_theme_icon_border',	'entry_theme_hower',			'entry_theme_icon_round',
	'entry_theme_toolbar_round',		'entry_theme_icon_color_hover', 'entry_theme_icon_inactive','entry_theme_selected_item'
	);
		
		foreach ($language_info as $language) {
			$this->data[$language] = $this->language->get($language); 
		}

		$this->data['token'] = $this->session->data['token'];
    
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['folder'])) {
			$this->data['error_folder'] = $this->error['folder'];
		} else {
			$this->data['error_folder'] = '';
		}    
		
		$this->data['breadcrumbs'] = array();

 		$this->data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('text_home'),
     		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => false
 		);

 		$this->data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('text_module'),
     		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => ' :: '
 		);
	
 		$this->data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('heading_title'),
     		'href'      => $this->url->link('module/implus', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => ' :: '
 		);
		
		$this->data['action'] = $this->url->link('module/implus', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		// simple imput fields
		$imput_fields = array(
		'implus_only_images',			'implus_drag_upload_allow',			'implus_upload_overwrite',		
		'implus_copy_overwrite',		'implus_language',					'implus_status',						
		'implus_watermark_status',		'implus_resize_status',				'implus_toolbar_image',
		'implus_design_status',
		);
		
		foreach ($imput_fields as $imput_field) {
			if (isset($this->request->post[$imput_field])) {
			$this->data[$imput_field] = $this->request->post[$imput_field];
			} else {
				$this->data[$imput_field] = $this->config->get($imput_field);
			}		
		}

		// special imput fields
		$imput_fields_special = array(
		'implus_width' => 800, 						'implus_upload_max_size' => 99,				'implus_lazy_load' => 30,
		'implus_height' => 500, 					'implus_upload_type' => 'M',				'implus_lazy_load_treshold' => 50,
		'implus_watermark_margin_right' => 5,		'implus_watermark_quality' => 95,
		'implus_watermark_margin_bottom' => 5,		'implus_watermark_transparency' => 70,		'implus_resize_quality' => 95,
		'implus_resize_max_width' => 1024,			'implus_resize_max_height' => 1024,			
		'implus_watermark_image_con' => 'no_image.jpg',
		'implus_theme_toolbar_bg_color' => '#CCC',  'implus_theme_left_panel' => '#DDE4EB',	'implus_theme_right_panel' => '#FFF',
		'implus_theme_hower' => '#DADADA',		'implus_theme_icon_active' => '#E6E6E6',	'implus_theme_icon_hover' => '#DADADA',
		'implus_theme_icon_border' => '1px', 	'implus_theme_icon_round' => '4px', 		'implus_theme_toolbar_round' => '4px',
		'implus_theme_icon_inactive' => '#E6E6E6', 'implus_theme_selected' => '#CCC',

		);
		
		foreach ($imput_fields_special as $imput_fields_special => $value) {
			if (isset($this->request->post[$imput_fields_special])) {
			$this->data[$imput_fields_special] = $this->request->post[$imput_fields_special];
			} else if($this->config->get($imput_fields_special)){
			$this->data[$imput_fields_special] = $this->config->get($imput_fields_special);
			} else {
			$this->data[$imput_fields_special] = $value;	
			}	
		}

		// correcting imput values min 0 - max 100
		$corrections = array('implus_watermark_quality', 'implus_watermark_transparency', 'implus_resize_quality',);

		foreach ($corrections as $correction) {
			if ($this->data[$correction] > 100) {
			$this->data[$correction] = 100;
			} elseif ($this->data[$correction] < 0) {
				$this->data[$correction] = 0;
			}
		}

		//background

		$this->load->model('tool/image');

		if ($this->config->get('implus_watermark_image_con') && file_exists(DIR_IMAGE . $this->config->get('implus_watermark_image_con')) && is_file(DIR_IMAGE . $this->config->get('implus_watermark_image_con'))) {
			$this->data['implus_watermark_image'] = $this->model_tool_image->resize($this->config->get('implus_watermark_image_con'), 100, 100);		
		} else {
			$this->data['implus_watermark_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		// get the languages
		$this->data['languages'] = array();
		$ignore = array('LANG');
		$files = glob(DIR_APPLICATION . 'view/javascript/image_manager_plus/i18n/*.js');
		
		foreach ($files as $file) {		
			$lang_files = basename($file, '.js');
			$languages	= str_replace('elfinder.', '', $lang_files);
			if (!in_array($languages, $ignore)) { $this->data['languages'][] = $languages; }
		}	

		// get toolbars
		$this->data['toolbars'] = array();
		$ignore_toolbar = array('color');
		$toolbar_files = glob(DIR_APPLICATION . 'view/image/image_manager_pro/toolbars/*.png');
			
		foreach ($toolbar_files as $file) {		
			$toolbar_file = basename($file, '.png');
			$toolbar_refined = str_replace('toolbar-', '', $toolbar_file);
			if (!in_array($toolbar_refined, $ignore_toolbar)) { $this->data['toolbars'][] = $toolbar_refined; }		
		}



		// RENDER
		$this->template = 'module/implus.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/implus')) {
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