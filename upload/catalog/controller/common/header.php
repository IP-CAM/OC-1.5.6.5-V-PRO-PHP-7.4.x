<?php
class ControllerCommonHeader extends Controller {
	protected function index() {
	$this->data['title'] = $this->document->getTitle();

	if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
	$server = $this->config->get('config_ssl');
	} else {
	$server = $this->config->get('config_url');
	}

	if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
	$this->data['error'] = $this->session->data['error'];

	unset($this->session->data['error']);
	} else {
	$this->data['error'] = '';
	}

	$this->data['base'] = $server;
	$this->data['description'] = $this->document->getDescription();
	$this->data['keywords'] = $this->document->getKeywords();
	$this->data['links'] = $this->document->getLinks();
	$this->data['styles'] = $this->document->getStyles();
	$this->data['scripts'] = $this->document->getScripts();
	$this->data['lang'] = $this->language->get('code');
	$this->data['direction'] = $this->language->get('direction');
	$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
	$this->data['name'] = $this->config->get('config_name');

	if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
	$this->data['icon'] = HTTP_IMAGE . $this->config->get('config_icon');
	} else {
	$this->data['icon'] = '';
	}

	if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
	$this->data['logo'] = HTTP_IMAGE . $this->config->get('config_logo');
	} else {
	$this->data['logo'] = '';
	}

	$this->language->load('common/header');

	$this->data['text_home'] = $this->language->get('text_home');
	$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
	$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
	$this->data['text_search'] = $this->language->get('text_search');
	$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
	$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
	$this->data['text_account'] = $this->language->get('text_account');
	$this->data['text_checkout'] = $this->language->get('text_checkout');
	$this->data['text_logout'] = $this->language->get('text_logout');
	$this->data['text_category'] = $this->language->get('text_category');
	$this->data['text_all'] = $this->language->get('text_all');

	$this->data['text_order'] = $this->language->get('text_order');
	$this->data['text_transaction'] = $this->language->get('text_transaction');
	$this->data['text_download'] = $this->language->get('text_download');

	$this->data['home'] = $this->url->link('common/home');
	$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
	$this->data['logged'] = $this->customer->isLogged();
	$this->data['text_register'] = $this->language->get('text_register');
	$this->data['text_login'] = $this->language->get('text_login');
	$this->data['account'] = $this->url->link('account/account', '', 'SSL');
	$this->data['shopping_cart'] = $this->url->link('checkout/cart');
	$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
	$this->data['telephone'] = $this->config->get('config_telephone');
	$this->data['contact'] = $this->url->link('information/contact');
	$this->data['register'] = $this->url->link('account/register', '', 'SSL');
	$this->data['login'] = $this->url->link('account/login', '', 'SSL');
	$this->data['logout'] = $this->url->link('account/logout', '', 'SSL');
	$this->data['order'] = $this->url->link('account/order', '', 'SSL');
	$this->data['download'] = $this->url->link('account/download', '', 'SSL');
	$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');

	// Daniel's robot detector
	$status = true;

	if (isset($this->request->server['HTTP_USER_AGENT'])) {
	$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

	foreach ($robots as $robot) {
	if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
	$status = false;

	break;
	}
	}
	}

	// A dirty hack to try to set a cookie for the multi-store feature
	$this->load->model('setting/store');

	$this->data['stores'] = array();

	if ($this->config->get('config_shared') && $status) {
	$this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();

	$stores = $this->model_setting_store->getStores();

	foreach ($stores as $store) {
	$this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
	}
	}

	// Search
	if (isset($this->request->get['search'])) {
	$this->data['search'] = $this->request->get['search'];
	} else {
	$this->data['search'] = '';
	}

	// Menu
	$this->load->model('catalog/category');

	$this->load->model('catalog/product');

	$this->data['categories'] = array();

	$categories = $this->model_catalog_category->getCategories(0);

	foreach ($categories as $category) {
	if ($category['top']) {
	// Level 2
	$children_data = array();

	$children = $this->model_catalog_category->getCategories($category['category_id']);

	foreach ($children as $child) {
	$data = array(
	'filter_category_id'  => $child['category_id'],
	'filter_sub_category' => true
	);

	$children_data[] = array(
	'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($data) . ')' : ''),
	'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
	);
	}

	// Level 1
	$this->data['categories'][] = array(
	'name'     => $category['name'],
	'children' => $children_data,
	'column'   => $category['column'] ? $category['column'] : 1,
	'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
	);
	}
	}

	if (isset($this->request->get['route'])) {
	if (isset($this->request->get['product_id'])) {
	$class = '-' . $this->request->get['product_id'];
	} elseif (isset($this->request->get['path'])) {
	$class = '-' . $this->request->get['path'];
	} elseif (isset($this->request->get['manufacturer_id'])) {
	$class = '-' . $this->request->get['manufacturer_id'];
	} else {
	$class = '';
	}
	$this->data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
	} else {
	$this->data['class'] = 'common-home';
	}
	$this->children = array(
	'common/language',
	'common/currency',
	'common/search',
	'common/cart'
	);

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
	} else {
	$this->template = 'default/template/common/header.tpl';
	}

	$this->render();
	}
}
?>