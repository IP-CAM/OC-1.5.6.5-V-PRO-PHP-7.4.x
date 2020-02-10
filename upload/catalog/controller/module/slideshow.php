<?php  
class ControllerModuleSlideshow extends Controller {
	protected function index($setting) {
	static $module = 0;
	
	$this->load->model('design/banner');
	$this->load->model('tool/image');
	
	$this->document->addScript('catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js');
	$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');	
//	$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');	
	$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.transitions.css');

	$this->data['width'] = $setting['width'];
	$this->data['height'] = $setting['height'];
	
	$this->data['banners'] = array();
	
	if (isset($setting['banner_id'])) {
	$results = $this->model_design_banner->getBanner($setting['banner_id']);

	foreach ($results as $result) {
	if (file_exists(DIR_IMAGE . $result['image'])) {
	$this->data['banners'][] = array(
	'title' => $result['title'],
	'link'  => $result['link'],
	'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
	);
	}
	}
	}
	
	$this->data['module'] = $module++;
	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/slideshow.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/module/slideshow.tpl';
	} else {
	$this->template = 'default/template/module/slideshow.tpl';
	}
	
	$this->render();
	}
}
?>