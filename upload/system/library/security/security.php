<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class SecurityBase {

    protected $config;
    protected $db;
    protected $request;
    protected $user;
    protected $language;
    protected $session;

    public function __construct($registry) {
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->user = $registry->get('user');
        $this->language = $registry->get('language');
        $this->session = $registry->get('session');
    }

}