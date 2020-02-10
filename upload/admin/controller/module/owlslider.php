<?php
class ControllerModuleOwlSlider extends Controller {
	private $error = array(); 
	 
	public function index() {   
		$this->language->load('module/owlslider');
		$this->load->model('tool/image');
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			
			$this->request->post['owlslider_module'][0]['banner_image'] = 	$this->request->post['banner_image'];
			unset($this->request->post['banner_image']);
			
	
			$this->model_setting_setting->editSetting('owlslider', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
 		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');			
		$this->data['text_yes'] = $this->language->get('text_yes');			
		$this->data['text_no'] = $this->language->get('text_no');			
				
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_width'] = $this->language->get('entry_width');
		$this->data['entry_height'] = $this->language->get('entry_height');
		
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_responsive'] = $this->language->get('entry_responsive');
		$this->data['entry_autoheight'] = $this->language->get('entry_autoheight');
		$this->data['entry_autoplay'] = $this->language->get('entry_autoplay');
		$this->data['entry_stoponhover'] = $this->language->get('entry_stoponhover');
		$this->data['entry_transition'] = $this->language->get('entry_transition');
		$this->data['entry_pagination'] = $this->language->get('entry_pagination');
		$this->data['entry_pagination_no'] = $this->language->get('entry_pagination_no');
		$this->data['entry_navigation'] = $this->language->get('entry_navigation');
		$this->data['entry_navigation_text'] = $this->language->get('entry_navigation_text');
		$this->data['entry_rewindnav'] = $this->language->get('entry_rewindnav');
		$this->data['entry_rewind_speed'] = $this->language->get('entry_rewind_speed');
		$this->data['entry_slide_speed'] = $this->language->get('entry_slide_speed');
		$this->data['entry_pagination_speed'] = $this->language->get('entry_pagination_speed');
		$this->data['entry_lazyload'] = $this->language->get('entry_lazyload');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);		
		$this->data['entry_show_image'] = $this->language->get( 'entry_show_image' );
		$this->data['entry_module_title'] = $this->language->get( 'entry_module_title' );
		$this->data['tab_module'] = $this->language->get('tab_module');
		
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
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/owlslider', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/owlslider', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];

		$this->data['modules'] = array();
		$this->data['positions'] = array( 'content_top',
										  'column_left',
										  'column_right',
										  'content_bottom'
		);
		
		$this->data['transitions'] = array('fade','backSlide','goDown','fadeUp');
		
		$d = array('layout_id'=>'','position'=>'','status'=>'','sort_order'=>'1',
		'banner_image'=>array(),'width'=>940,'height'=>350,
		'responsive' => 1,
		'autoheight' => 0,
		'autoplay' => 0,
		'stoponhover' => 0,
		'transition' => 'fade',
		'pagination' => 1,
		'pagination_no' => 0,
		'navigation' => 1,
		'navigation_text' => '',
		'rewindnav' => 1,
		'rewind_speed' => 1000,
		'slide_speed' => 200,
		'pagination_speed' => 800,
		'lazyload' => 0,
		
		);

		if (isset($this->request->post['owlslider_module'])) {
			$this->data['modules'] = $this->request->post['owlslider_module'];
		} elseif ($this->config->get('owlslider_module')) { 
			$this->data['modules'] = $this->config->get('owlslider_module');
		}	
		if( !empty($this->data['modules']) ){
			 $d = array_merge($d,$this->data['modules'][0]);			
		}
		$this->data['module'] = $d;
		if( $d['banner_image'] ){
			$tmp = array();$i=1;
			foreach( $d['banner_image'] as $key => $banner ){
				$banner['link'] = isset($banner['link'])?trim($banner['link']):"";
				$banner['thumb'] = $this->model_tool_image->resize($banner['image'], 100, 100);
				$tmp[$i++] = $banner;
			}
			 $d['banner_image'] = $tmp;
		}

		$this->data['banner_image'] = $d['banner_image'];
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->template = 'module/owlslider.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/owlslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if( !isset($this->request->post['banner_image']) ){
			$this->error['warning'] = $this->language->get('error_missing_banner');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>