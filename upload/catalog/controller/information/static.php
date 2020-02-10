<?php
class ControllerInformationStatic extends Controller {
	private $error = array();
	public function index() {
	$this->language->load('information/static'); //Optional. This calls for your language file
	$this->document->setTitle($this->language->get('heading_title')); //Optional. Set the title of your web page.
	$this->data['breadcrumbs'] = array();
	$this->data['breadcrumbs'][] = array(
	'text'	=> $this->language->get('text_home'),
	'href'	=> $this->url->link('common/home'),	
	'separator' => false
	);

	$this->data['breadcrumbs'][] = array(
	'text'	=> $this->language->get('heading_title'),
	'href'	=> $this->url->link('information/static'),
	'separator' => $this->language->get('text_separator')
	);	
	
	$this->data['heading_title'] = $this->language->get('heading_title'); //Get "heading title" from language file.

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/static.tpl')) { //if file exists in your current template folder
	$this->template = $this->config->get('config_template') . '/template/information/static.tpl'; //get it
	} else {
	$this->template = 'default/template/information/static.tpl'; //or get the file from the default folder
	}
	
	$this->children = array( //Required. The children files for the page.
	'common/column_left',
	'common/column_right',
	'common/content_top',
	'common/content_bottom',
	'common/footer',
	'common/header'
	);
	
	$this->response->setOutput($this->render());	
	}
}
?>