<?php
class ControllerToolSystemInfo extends Controller {
   public function index() {
      $this->data = $this->load->language('tool/system_info');
      
      $this->document->setTitle($this->data['heading_title']);
      $this->document->addStyle('view/stylesheet/systeminfo.css');
      
      $this->data['breadcrumbs'] = array();
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('text_home'),
         'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
         'separator' => false
      );
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('heading_title'),
         'href'      => $this->url->link('tool/system_info', 'token=' . $this->session->data['token'], 'SSL'),
         'separator' => ' <span class="separator">&#187;</span> '
      );
      
      $this->data['link_author']          = sprintf($this->data['text_link'], $this->data['dev_url'], $this->data['dev_name'], $this->data['dev_name']);
      $this->data['link_author2']         = sprintf($this->data['text_link'], $this->data['dev_url'], $this->data['dev_name'], $this->data['dev_url']);
      $this->data['link_documentation']   = sprintf($this->data['text_link_secure'], $this->data['dev_url_docs'], '', $this->data['heading_title'] . ' ' . $this->data['text_documentation']);
      $this->data['link_support']         = sprintf($this->data['text_link'], $this->data['dev_url_support'], '', $this->data['text_support']);
      $this->data['link_copyright']       = sprintf($this->data['dev_copyright'], $this->data['heading_title'], '2011 - ' . date('Y'), $this->data['link_author']);
      $this->data['oc_footer']            = sprintf($this->language->get('oc_footer'), VERSION);
      
      $this->data['token']                = $this->session->data['token'];
      
      $this->template = 'tool/system_info.tpl';
      $this->children = array(
         'common/header',   
         'common/footer'   
      );
      
      $this->response->setOutput($this->render());
   }
   
   public function phpInfo() {
      $this->data = $this->load->language('tool/system_info');
      
      $this->document->setTitle($this->data['heading_title']);
      $this->document->addStyle('view/stylesheet/systeminfo.css');
      
      $this->data['phpinfo'] = phpinfo();
      
      $this->template = 'tool/system_php_info.tpl';
      $this->children = array(
         'common/header',   
         'common/footer'   
      );
      
      $this->response->setOutput($this->render());
   }
   
   public function version() {
      $this->data = $this->load->language('tool/system_info');
      $currentVersion = $this->language->get('product_version');
      
      if (isset($this->request->get['product'])) { $prodName = $this->request->get['product']; } else { $prodName = 'SystemInformation'; }
      $checkVersion = 'http://www.echothemes.com/assets/version/' . $prodName . '.xml';
      
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $checkVersion);
      curl_setopt($curl, CURLOPT_HEADER, 0);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $returnData = curl_exec($curl);
      $returnCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      
      if ($returnCode == 200) { // Succeeded
         $data = simplexml_load_string($returnData);
         if ($data->version == $currentVersion || $data->version <= $currentVersion) {
            $statusClass   = 'green';
            $statusText    = $this->language->get('text_noupdate');
            $changelogDesc = '';
         } elseif ($data->version >= $currentVersion) {
            $statusClass   = 'orange';
            $statusText    = $this->language->get('text_update');
            $changelogDesc = $data->changelog;
         } else {
            $statusClass   = 'red';
            $statusText      = $this->language->get('text_missupdate');
            $changelogDesc = '';
         }
      } else { 
         $statusClass   = 'red';
         $statusText    = $this->language->get('text_failconnect');
         $changelogDesc = '';
      }

      $output = '<span class="version ' . $statusClass . '">' . $statusText . '</span>';
      if ($changelogDesc) {
         $output .= '<div id="updateChangelog">' . $changelogDesc . '</div>';
      }

      $this->response->setOutput(json_encode($output));
   }
}
?>