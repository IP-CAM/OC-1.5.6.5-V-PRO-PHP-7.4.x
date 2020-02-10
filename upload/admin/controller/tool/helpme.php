<?php 
class ControllerToolHelpMe extends Controller { 
	private $error = array();
	
	public function index() {		
		$this->load->language('tool/helpme');

        if (!$this->user->hasPermission('modify', 'tool/helpme')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

		$this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->get['cancel'])) {
            // Cancel Invitation
            // Delete fields
            $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'helpme_email'");
            $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'helpme_key'");
            $this->session->data['success'] = $this->language->get('text_cancel_success');
        }

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            // ------------ Write invite data -------------
            // Delete fields
            $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'helpme_email'");
            $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'helpme_key'");
            // Write new data
            $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET value = '" . $this->request->post['email'] . "', `key` = 'helpme_email'");
            $key=rand(10000000,99999999);
            $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET value = '" . $key . "', `key` = 'helpme_key'");


            // ------------ Send mail
            $message  = sprintf($this->language->get('mail_start'), $this->user->getUserName(), HTTP_CATALOG) . "\n\n";
            if ($this->request->post['task'])
            $message .= $this->language->get('mail_task') . "\n" . $this->request->post['task'] . "\n\n";
            $message .= $this->language->get('mail_info') . "\n";
            // Autologin URL
			$message .= HTTP_SERVER."index.php?route=common/login&hmail=".$this->request->post['email']."&hkey=".$key;
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $mail->setTo($this->request->post['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender(HTTP_CATALOG);
            $mail->setSubject(html_entity_decode(sprintf($this->language->get('mail_subject'), HTTP_CATALOG), ENT_QUOTES, 'UTF-8'));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();


				$this->session->data['success'] = $this->language->get('text_success'). ' <b>' . $this->request->post['email'] . '</b>';
		}

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['invite_to'] = $this->language->get('invite_to');
        $this->data['aware'] = $this->language->get('aware');
        $this->data['warning'] = $this->language->get('warning');
        $this->data['secure_admin'] = $this->language->get('secure_admin');
        $this->data['secure_admin_info'] = $this->language->get('secure_admin_info');
        // Check for invite
        $q = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'helpme_email'")->row;
        if ($q) { // Invite already sent
          $email=$q['value'];
          $q = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'helpme_key'")->row;
          $key=$q['value'];
          $this->data['email'] = $email;
          $this->data['active'] = $this->language->get('active');
          $this->data['invite_link'] = $this->language->get('invite_link');
          $this->data['link'] = HTTP_SERVER."index.php?route=common/login&hmail=".$email."&hkey=".$key;
          $this->data['invite_cancel'] = $this->language->get('invite_cancel');
          $this->data['cancel_link'] = $this->url->link('tool/helpme', 'token=' . $this->session->data['token'].'&cancel=1', 'SSL');
        } else {
        $this->data['intro'] = $this->language->get('intro');
        $this->data['instructions'] = $this->language->get('instructions');
        $this->data['inv_send'] = $this->language->get('inv_send');
        }
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/helpme', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['send_it'] = $this->url->link('tool/helpme', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'tool/helpme.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
}
?>