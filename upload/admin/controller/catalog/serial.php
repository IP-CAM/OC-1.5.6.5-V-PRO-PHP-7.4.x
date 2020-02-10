<?php

class ControllerCatalogSerial extends Controller {
	private $error = array();
	
	private function init() {
		$this->load->language('catalog/serial');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/serial');
	}

	public function index() {
		$this->init();
		
		$this->model_catalog_serial->tableCheck();
		
		$this->getList();
	}

	public function edit() {
		$this->init();
		$this->getEditList();
	}

	public function delete() {
		$this->init();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormDelete()) {
			if (isset($this->request->post['selected']) && count($this->request->post['selected'])) {
				$this->model_catalog_serial->deleteSerials($this->request->post['selected']);
				$this->session->data['success'] = $this->language->get('text_success_delete');
			} else {
				$this->error['warning'] = $this->language->get('error_selection');
			}
		}
		$this->getList();
	}

	public function deleteKeys() {
		$this->init();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormDelete()) {
			if (isset($this->request->post['selected']) && count($this->request->post['selected'])) {
				$this->model_catalog_serial->deleteSerialsByID($this->request->post['selected']);
				$this->session->data['success'] = $this->language->get('text_success_delete');
			} else {
				$this->error['warning'] = $this->language->get('error_selection');
			}
		}
		$this->getEditList();
	}

	public function insert() {
		$this->init();
		
		$this->load->model('catalog/product');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			// Check product id is set and greater than 0
			if ($this->request->post['product_id']) {
				// Make sure product exists
				$prod = $this->model_catalog_product->getProductDescriptions($this->request->post['product_id']);
				if (count($prod)) {

					$serials = explode(',', $this->request->post['serials']);

					if (count($serials))
						$serials = array_map('trim', $serials);

					foreach ($serials as $k => $serial) {
						if (empty($serial)) {
							unset($serials[$k]);
						}
					}

					$duplicates = $this->model_catalog_serial->duplicateSerials($serials, $this->request->post['product_id']);

					if ($duplicates) {
						$serials = array_diff($serials, $duplicates);
					}

					if (count($serials)) {
						$this->model_catalog_serial->addSerials($serials, $this->request->post['product_id']);

						if (!$duplicates) {
							$this->session->data['success'] = $this->language->get('text_success');
							$this->redirect($this->url->link('catalog/serial', 'token=' . $this->session->
								data['token'], 'SSL'));
						} else {
							$this->error['warning'] = $this->language->get('error_dupes');
							$this->request->post['serials'] = implode(',', $duplicates);
						}
					} else {
						if (!$duplicates) {
							$this->error['warning'] = $this->language->get('error_keys');
						} else {
							$this->error['warning'] = $this->language->get('error_dupes');
							$this->request->post['serials'] = implode(',', $duplicates);
						}
					}
				} else {
					$this->error['warning'] = $this->language->get('error_product');
				}
			} else {
				$this->error['warning'] = $this->language->get('error_product');
			}
		}
		$this->getForm();

	}

	private function getList() {
		// Set error and warning messages
		$this->data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';
		$this->data['success'] = (isset($this->session->data['success'])) ? $this->session->data['success'] : '';
		unset($this->session->data['success']);

		// Load text values for page
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_keys'] = $this->language->get('column_keys');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_add'] = $this->language->get('button_add');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_quickfind'] = $this->language->get('button_quickfind');

		$this->data['text_no_keys'] = $this->language->get('text_no_keys');
		$this->data['text_action'] = $this->language->get('text_action');

		// Set breadcrumbs
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link(
				'common/home',
				'token=' . $this->session->data['token'],
				'SSL'
			),
			'text' => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link(
				'catalog/serial',
				'token=' . $this->session->data['token'],
				'SSL'
			),
			'text' => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		// Create insert/delete url's
		$this->data['insert'] = $this->url->link('catalog/serial/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('catalog/serial/delete', 'token=' . $this->session->data['token'], 'SSL');

		$serials = $this->model_catalog_serial->getSerialList();
		$used = $this->model_catalog_serial->getOrderSerialsTotal();

		foreach ($serials as &$serial) {
			$serial['text'] = sprintf($this->language->get('text_available'), $serial['count']);
			if (!empty($used[$serial['id']])) {
				$serial['text'] .= sprintf($this->language->get('text_used'), $used[$serial['id']]);
			}
		}

		$this->data['serials'] = $serials;

		$this->template = 'catalog/serial_list.tpl';
		$this->children = array('common/header', 'common/footer');
		$this->response->setOutput($this->render());
	}

	private function getEditList() {
		$this->document->addScript('view/javascript/jquery/jquery.jeditable.mini.js');
		// Set error and warning messages
		$this->data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] :
			'';
		$this->data['success'] = (isset($this->session->data['success'])) ? $this->session->data['success'] : '';
		unset($this->session->data['success']);

		// Load text values for page
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['column_serial'] = $this->language->get('column_serials');

		$this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['text_no_keys'] = $this->language->get('text_no_keys');
		$this->data['text_action'] = $this->language->get('text_action');

		// Set breadcrumbs
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link(
				'common/home',
				'token=' . $this->session->data['token'],
				'SSL'
			),
			'text' => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link(
				'catalog/serial',
				'token=' . $this->session->data['token'],
				'SSL'
			),
			'text' => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		// Create delete url
		$this->data['delete'] = $this->url->link(
			'catalog/serial/deleteKeys',
			'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'],
			'SSL'
		);

		$this->data['serials'] = $this->model_catalog_serial->getSerials((int)$this->request->get['id']);

		$this->template = 'catalog/serial_edit.tpl';
		$this->children = array('common/header', 'common/footer');
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		// Set error and warning messages
		$this->data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] :
			'';
		$this->data['success'] = (isset($this->session->data['success'])) ? $this->session->data['success'] : '';
		unset($this->session->data['success']);

		// Load text values for page
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_keys'] = $this->language->get('entry_keys');
		$this->data['entry_file'] = $this->language->get('entry_file');

		$this->data['error_product'] = empty($this->error['product']) ? '' : $this->error['product'];
		$this->data['error_keys'] = empty($this->error['serials']) ? '' : $this->error['serials'];

		$this->data['token'] = $this->session->data['token'];

		// Set breadcrumbs
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link(
				'common/home',
				'token=' . $this->session->data['token'],
				'SSL'
			),
			'text' => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link(
			'catalog/serial',
			'token=' . $this->session->data['token'],
				'SSL'
			),
			'text' => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		// Create insert/delete url's
		$this->data['cancel'] = $this->url->link('catalog/serial', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['products'] = $this->model_catalog_serial->getProducts();
		$this->data['text'] = isset($this->request->post['serials']) ? $this->request->post['serials'] : '';
		$this->data['selected'] = isset($this->request->post['product_id']) ? $this->request->post['product_id'] : 0;
		$this->data['action'] = $this->data['action'] = $this->url->link('catalog/serial/insert', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'catalog/serial_form.tpl';
		$this->children = array('common/header', 'common/footer');

		$this->response->setOutput($this->render());
	}

	public function removeOrderSerial() {
		$return = array(
			'error' => true
		);
		
		$serial_id = empty($this->request->get['serial_id']) ? false : (int)$this->request->get['serial_id'];
		$order_id = empty($this->request->get['order_id']) ? false : (int)$this->request->get['order_id'];

		$return['serial_id'] = $serial_id;
		if ($serial_id) {
			$this->load->model('catalog/serial');
			$result = $this->model_catalog_serial->removeOrderSerial($serial_id, $order_id);
			if ($result) {
				$return['error'] = false;
			}
		}

		$this->outputJSON($return);
	}

	public function addOrderSerial() {
		$return = array(
			'error' => true
		);
		
		$serial = empty($this->request->get['serial']) ? false : $this->request->get['serial'];
		$order_id = empty($this->request->get['order_id']) ? false : (int)$this->request->get['order_id'];
		$product_id = empty($this->request->get['product_id']) ? false : (int)$this->request->get['product_id'];

		$return['product_id'] = $product_id;
		if ($serial && $product_id && $order_id) {
			$this->load->model('catalog/serial');
			$result = $this->model_catalog_serial->addOrderSerial($serial, $order_id, $product_id);
			if ($result) {
				$return['error'] = false;
				$return['serial_key_id'] = $this->db->getLastId();
				$return['serial'] = $serial;
			}
		}

		$this->outputJSON($return);
	}

	public function updateOrderSerial() {
		$return = array(
			'error' => true
		);
		
		$serial = empty($this->request->get['serial']) ? false : $this->request->get['serial'];
		$serial_id = empty($this->request->get['serial_id']) ? false : (int)$this->request->get['serial_id'];

		if ($serial_id) {
			$this->load->model('catalog/serial');
			$result = $this->model_catalog_serial->updateOrderSerial($serial_id, $serial);
			if ($result) {
				$return['error'] = false;
			}
		}

		$this->outputJSON($return);
	}

	public function updateSerial() {
		$return = array(
			'error' => true
		);
		
		$serial = empty($this->request->get['serial']) ? false : $this->request->get['serial'];
		$serial_id = empty($this->request->get['serial_id']) ? false : (int)$this->request->get['serial_id'];

		if ($serial_id) {
			$this->load->model('catalog/serial');
			$result = $this->model_catalog_serial->updateSerial($serial_id, $serial);
			if ($result) {
				$return['error'] = false;
			}
		}

		$this->outputJSON($return);
	}

	public function find() {
		$this->load->language('catalog/serial');
		$serial = empty($this->request->get['serial']) ? '' : trim($this->request->get['serial']);

		$result = array(
			'message'	=> $this->language->get('find_default'),
			'redirect'	=> ''
		);

		if ($serial) {
			$this->load->model('catalog/serial');
			$order_id = $this->model_catalog_serial->findOrderSerials($serial);

			$result['message'] = $this->language->get('find_none');

			if ($order_id) {
				$result['message'] = '';
				$result['redirect'] = $this->url->link('sale/order/info', 'order_id=' . $order_id . '&token=' . $this->session->data['token'], 'SSL');
			}
		}
		
		$this->outputJSON($result);
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/serial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!empty($this->request->files['csv']['tmp_name']) && is_uploaded_file($this->request->files['csv']['tmp_name'])) {
			$this->request->post['serials'] = file_get_contents($this->request->files['csv']['tmp_name']);
		}

		if (empty($this->request->post['product_id'])) {
			$this->error['product'] = $this->language->get('error_product');
		}

		if (empty($this->request->post['serials'])) {
			$this->error['serials'] = $this->language->get('error_keys');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateFormDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/serial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function outputJSON($data) {
		if (file_exists(DIR_SYSTEM . 'library/json.php')) {
			$this->load->library('json');
			die(JSON::encode($data));
		} else {
			die(json_encode($data));
		}

	}
}

?>