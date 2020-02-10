<?php 
class ControllerModuleGixocrobots extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('module/gixocrobots');

		$this->document->setTitle($this->language->get('text_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(isset($this->request->post['robots'])){
				$file = str_replace("system/", "", DIR_SYSTEM) . 'robots.txt';

				$handles = fopen($file, 'w+'); 

				$robots = str_replace("&amp;", "&", $this->request->post['robots']);
                
				fwrite($handles, $robots);

				fclose($handles);

				$this->session->data['success'] = $this->language->get('text_success');

				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_edit'] = $this->language->get('text_edit');

		$this->data['entry_create'] = $this->language->get('entry_create');
		$this->data['entry_clean'] = $this->language->get('entry_clean');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

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
			'text'      => $this->language->get('text_title'),
			'href'      => $this->url->link('module/gixocrobots', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/gixocrobots', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$file = str_replace("system/", "", DIR_SYSTEM) . 'robots.txt';

		if (file_exists($file)) {
			$this->data['text'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['text'] = '';
		}

		$this->template = 'module/gixocrobots.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function getUrl($route){
		$url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
		if ($this->config->get('config_seo_url')) {
            require_once(DIR_CATALOG . 'controller/common/seo_url.php');
            $rewriter = new ControllerCommonSeoUrl($this->registry);
            $url->addRewrite($rewriter);
		}
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$domain = HTTPS_CATALOG;
		} else {
			$domain = HTTP_CATALOG;
		}
		
		return str_replace($domain, "", $url->link($route));
	}

	public function create_robots(){
		$text = "User-agent: *
Disallow: /" . $this->getUrl("account/account") . "
Disallow: /" . $this->getUrl("account/address") . "
Disallow: /" . $this->getUrl("account/download") . "
Disallow: /" . $this->getUrl("account/edit") . "
Disallow: /" . $this->getUrl("account/forgotten") . "
Disallow: /" . $this->getUrl("account/login") . "
Disallow: /" . $this->getUrl("account/logout") . "
Disallow: /" . $this->getUrl("account/newsletter") . "
Disallow: /" . $this->getUrl("account/order") . "
Disallow: /" . $this->getUrl("account/password") . "
Disallow: /" . $this->getUrl("account/recurring") . "
Disallow: /" . $this->getUrl("account/register") . "
Disallow: /" . $this->getUrl("account/return") . "
Disallow: /" . $this->getUrl("account/reward") . "
Disallow: /" . $this->getUrl("account/success") . "
Disallow: /" . $this->getUrl("account/transaction") . "
Disallow: /" . $this->getUrl("account/voucher") . "
Disallow: /" . $this->getUrl("account/wishlist") . "
Disallow: /" . $this->getUrl("affiliate/account") . "
Disallow: /" . $this->getUrl("affiliate/edit") . "
Disallow: /" . $this->getUrl("affiliate/forgotten") . "
Disallow: /" . $this->getUrl("affiliate/login") . "
Disallow: /" . $this->getUrl("affiliate/logout") . "
Disallow: /" . $this->getUrl("affiliate/password") . "
Disallow: /" . $this->getUrl("affiliate/payment") . "
Disallow: /" . $this->getUrl("affiliate/register") . "
Disallow: /" . $this->getUrl("affiliate/success") . "
Disallow: /" . $this->getUrl("affiliate/tracking") . "
Disallow: /" . $this->getUrl("affiliate/transaction") . "
Disallow: /" . $this->getUrl("checkout/cart") . "
Disallow: /" . $this->getUrl("checkout/checkout") . "
Disallow: /" . $this->getUrl("checkout/failure") . "
Disallow: /" . $this->getUrl("checkout/success") . "
Disallow: /" . $this->getUrl("product/compare") . "
Disallow: /" . $this->getUrl("product/search") . "
Disallow: /index.php?route=product/product*&manufacturer_id=
Disallow: /admin
Disallow: /catalog
Disallow: /download
Disallow: /system
Disallow: /*?sort=
Disallow: /*&sort=
Disallow: /*?order=
Disallow: /*&order=
Disallow: /*?limit=
Disallow: /*&limit=
Disallow: /*?filter=
Disallow: /*&filter=
Disallow: /*?filter_name=
Disallow: /*&filter_name=
Disallow: /*?filter_sub_category=
Disallow: /*&filter_sub_category=
Disallow: /*?filter_description=
Disallow: /*&filter_description=
Disallow: /*?tracking=
Disallow: /*&tracking=
Allow: /catalog/view/javascript/
Allow: /catalog/view/theme/*/

User-agent: Yandex
Disallow: /" . $this->getUrl("account/account") . "
Disallow: /" . $this->getUrl("account/address") . "
Disallow: /" . $this->getUrl("account/download") . "
Disallow: /" . $this->getUrl("account/edit") . "
Disallow: /" . $this->getUrl("account/forgotten") . "
Disallow: /" . $this->getUrl("account/login") . "
Disallow: /" . $this->getUrl("account/logout") . "
Disallow: /" . $this->getUrl("account/newsletter") . "
Disallow: /" . $this->getUrl("account/order") . "
Disallow: /" . $this->getUrl("account/password") . "
Disallow: /" . $this->getUrl("account/recurring") . "
Disallow: /" . $this->getUrl("account/register") . "
Disallow: /" . $this->getUrl("account/return") . "
Disallow: /" . $this->getUrl("account/reward") . "
Disallow: /" . $this->getUrl("account/success") . "
Disallow: /" . $this->getUrl("account/transaction") . "
Disallow: /" . $this->getUrl("account/voucher") . "
Disallow: /" . $this->getUrl("account/wishlist") . "
Disallow: /" . $this->getUrl("affiliate/account") . "
Disallow: /" . $this->getUrl("affiliate/edit") . "
Disallow: /" . $this->getUrl("affiliate/forgotten") . "
Disallow: /" . $this->getUrl("affiliate/login") . "
Disallow: /" . $this->getUrl("affiliate/logout") . "
Disallow: /" . $this->getUrl("affiliate/password") . "
Disallow: /" . $this->getUrl("affiliate/payment") . "
Disallow: /" . $this->getUrl("affiliate/register") . "
Disallow: /" . $this->getUrl("affiliate/success") . "
Disallow: /" . $this->getUrl("affiliate/tracking") . "
Disallow: /" . $this->getUrl("affiliate/transaction") . "
Disallow: /" . $this->getUrl("checkout/cart") . "
Disallow: /" . $this->getUrl("checkout/checkout") . "
Disallow: /" . $this->getUrl("checkout/failure") . "
Disallow: /" . $this->getUrl("checkout/success") . "
Disallow: /" . $this->getUrl("product/compare") . "
Disallow: /" . $this->getUrl("product/search") . "
Disallow: /index.php?route=product/product*&manufacturer_id=
Disallow: /admin
Disallow: /catalog
Disallow: /download
Disallow: /system
Disallow: /*?sort=
Disallow: /*&sort=
Disallow: /*?order=
Disallow: /*&order=
Disallow: /*?limit=
Disallow: /*&limit=
Disallow: /*?filter=
Disallow: /*&filter=
Disallow: /*?filter_name=
Disallow: /*&filter_name=
Disallow: /*?filter_sub_category=
Disallow: /*&filter_sub_category=
Disallow: /*?filter_description=
Disallow: /*&filter_description=
Disallow: /*?tracking=
Disallow: /*&tracking=
Allow: /catalog/view/javascript/
Allow: /catalog/view/theme/*/
Clean-param: tracking";

		$this->response->setOutput($text);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/gixocrobots')) {
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