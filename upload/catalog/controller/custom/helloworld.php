<?php
class ControllerCustomHelloWorld extends Controller
{
public function index(){
	// VARS
	$this->language->load('custom/helloworld');
	$this->data['breadcrumbs'] = array();
	$this->data['breadcrumbs'][] = array(
	'text'      => $this->language->get('text_home'),
	'href'      => $this->url->link('common/home'),
	'separator' => false
	);

	$this->data['heading_title'] = $this->language->get('heading_title');
	$this->data['button_continue'] = $this->language->get('button_continue');
	$this->data['description'] = '';
	$this->data['continue'] = $this->url->link('common/home');
	$template=$this->config->get('config_template') ."/template/custom/hello.tpl"; // .tpl location and file
	$this->load->model('custom/hello');
	$this->template = ''.$template.'';
	$this->children = array(
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