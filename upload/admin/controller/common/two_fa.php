<?php
class ControllerCommonTwoFA extends Controller {
	protected $error = array();
	public function index() {
	$this->load->language('common/two_fa');

	if (isset($this->session->data['two_fa'])) {
	$this->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
	}
	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
	$this->session->data['two_fa'] = true;
	unset($this->session->data['two_fa_time']);
	unset($this->session->data['two_fa_code']);
	$this->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
	} elseif ($this->request->server['REQUEST_METHOD'] != 'POST') {
	$this->sendCode();
	}
	$this->document->setTitle($this->language->get('heading_title'));
	$this->data['heading_title'] = $this->language->get('heading_title');
	$this->data['entry_code'] = $this->language->get('entry_code');
	$this->data['button_authenticate'] = $this->language->get('button_authenticate');
	$this->data['button_resend'] = $this->language->get('button_resend');
	$this->data['resend'] = $this->url->link('common/two_fa/resend', 'token=' . $this->session->data['token'], 'SSL');
	if (isset($this->error['warning'])) {
	$this->data['error_warning'] = $this->error['warning'];
	} else {
	$this->data['error_warning'] = '';
	}

	if (isset($this->session->data['success'])) {
	$this->data['success'] = $this->session->data['success'];

	unset($this->session->data['success']);
	} else {
	$this->data['success'] = false;
	}
	$this->data['action'] = $this->url->link('common/two_fa', 'token=' . $this->session->data['token'], 'SSL');
	$this->template = 'common/two_fa.tpl';
	$this->children = array(
	'common/header',
	'common/footer'
	);
	$this->response->setOutput($this->render());
	}

	public function resend() {
	$this->load->language('common/two_fa');
	$email = $this->sendCode();
	$this->session->data['success'] = sprintf($this->language->get('text_resent'), $email);
	$this->redirect($this->url->link('common/two_fa', 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function sendCode() {
	$this->session->data['two_fa_time'] = time();
	$this->session->data['two_fa_code'] = mt_rand(100000, 999999);
	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$this->user->getId() . "'");
	if (!empty($query->row['email'])) {
	$email = $query->row['email'];
	$subject  = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
	$message  = sprintf($this->language->get('text_message'), $this->session->data['two_fa_code'], html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
	$mail = new Mail();
	$mail->protocol = $this->config->get('config_mail_protocol');
	$mail->parameter = $this->config->get('config_mail_parameter');
	$mail->hostname = $this->config->get('config_smtp_host');
	$mail->username = $this->config->get('config_smtp_username');
	$mail->password = $this->config->get('config_smtp_password');
	$mail->port = $this->config->get('config_smtp_port');
	$mail->timeout = $this->config->get('config_smtp_timeout');	
	$mail->setTo($email);
	$mail->setFrom($this->config->get('config_email'));
	$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
	$mail->setSubject($subject);
	$mail->setText($message);
	$mail->send();
	} else {
	// User does not have email, authenticate user
	$this->session->data['two_fa'] = true;
	unset($this->session->data['two_fa_time']);
	unset($this->session->data['two_fa_code']);

	$this->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
	}
	return $email;
	}
	protected function validate() {
	if (!isset($this->request->post['code']) || $this->request->post['code'] != $this->session->data['two_fa_code'] || ($this->session->data['two_fa_time'] + 300) < time()) {
	$this->error['warning'] = $this->language->get('error_code');
	}
	return !$this->error;
	}
}
?>