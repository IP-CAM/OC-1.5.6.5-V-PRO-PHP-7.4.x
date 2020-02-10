<?php

class ControllerOpenshopInfo extends Controller{ 
    public function index(){
                // VARS
        $template="openshop/info.tpl"; 			// .tpl location and file
        $this->load->model('openshop/info');	// model class file
		$this->load->language('openshop/info'); //language class file
        $this->template = ''.$template.'';
        $this->children = array(
            'common/header',
            'common/footer'
        );      
        $this->response->setOutput($this->render());
    }
}
?>