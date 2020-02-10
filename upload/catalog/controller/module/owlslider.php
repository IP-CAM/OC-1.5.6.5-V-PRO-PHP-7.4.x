<?php  
class ControllermoduleOwlSlider extends Controller {
	protected function index( $setting ) {
	
	static $module = 0;
	
	$this->load->model('design/banner');
	$this->load->model('tool/image');	
	if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/owl-carousel/owl.carousel.css')) {
	$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/owl-carousel/owl.carousel.css');
	} else {
	$this->document->addStyle('catalog/view/theme/default/stylesheet/owl-carousel/owl.carousel.css');
	}
	
	if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/owl-carousel/owl.theme.css')) {
	$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/owl-carousel/owl.theme.css');
	} else {
	$this->document->addStyle('catalog/view/theme/default/stylesheet/owl-carousel/owl.theme.css');
	}
	
	if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/owl-carousel/owl.transitions.css')) {
	$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/owl-carousel/owl.transitions.css');
	} else {
	$this->document->addStyle('catalog/view/theme/default/stylesheet/owl-carousel/owl.transitions.css');
	}
	
	$this->data['banners'] = array();
	$this->data['setting'] = $setting;
	
	/* Variables */
	$this->data['responsive'] = $setting['responsive'];
	$this->data['autoheight'] = $setting['autoheight'];
	$this->data['autoplay'] = $setting['autoplay'];
	$this->data['stoponhover'] = $setting['stoponhover'];
	$this->data['transition'] = $setting['transition'];
	$this->data['pagination'] = $setting['pagination'];
	$this->data['pagination_no'] = $setting['pagination_no'];
	$this->data['navigation'] = $setting['navigation'];
	$this->data['navigation_text'] = $setting['navigation_text'];
	$this->data['rewindnav'] = $setting['rewindnav'];
	$this->data['rewind_speed'] = $setting['rewind_speed'];
	$this->data['slide_speed'] = $setting['slide_speed'];
	$this->data['pagination_speed'] = $setting['pagination_speed'];
	$this->data['lazyload'] = $setting['lazyload'];
	
	if( isset($setting['banner_image'])){
	foreach( $setting['banner_image'] as $banner ){
	$banner['thumb'] = $this->model_tool_image->resize($banner['image'], $setting['width'], $setting['height']);
	$title = isset( $banner['title'][$this->config->get('config_language_id')] ) ? $banner['title'][$this->config->get('config_language_id')]:"";
	$description = isset( $banner['description'][$this->config->get('config_language_id')] ) ? $banner['description'][$this->config->get('config_language_id')]:"";
	$banner['title'] =  html_entity_decode( $title, ENT_QUOTES, 'UTF-8');
	$this->data['banners'][] = $banner;
	}
	}
	$this->data['module'] = $module++;
	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/owlslider.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/module/owlslider.tpl';
	} else {
	$this->template = 'default/template/module/owlslider.tpl';
	}
	
	$this->render();
	}
}
?>