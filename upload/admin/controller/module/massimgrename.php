<?php
class ControllerModulemassimgrename extends Controller {
    public $error = array();
    public $limit = 200;
    public $debug = false;

    public function index() {
        $url = '';
         
        $this->document->addScript('view/javascript/massimgrename.js');
        $this->document->addStyle('view/stylesheet/massimgrename.css');

        $this->load->language('module/massimgrename');
        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_title'] = $this->language->get('text_title');
        $this->data['breadcrumbs'] = array();
        
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/massimgrename', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/massimgrename/updatesettings', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['cancel'] = $this->url->link('module/massimgrename', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['tab_general'] = $this->language->get('tab_general');

        $this->data['entry_last_run'] = $this->language->get('entry_last_run');
        $this->data['entry_type_select'] = $this->language->get('entry_type_select');
        $this->data['entry_missing'] = $this->language->get('entry_missing');
        $this->data['entry_massimgrename_max_product_req'] = $this->language->get('entry_massimgrename_max_product_req');
        $this->data['entry_duplicate'] = $this->language->get('entry_duplicate');
        $this->data['entry_remove_source_images'] = $this->language->get('entry_remove_source_images');

        $this->data['entry_last_run_title'] = $this->language->get('entry_last_run_title');
        $this->data['entry_type_select_title'] = $this->language->get('entry_type_select_title');
        $this->data['entry_missing_title'] = $this->language->get('entry_missing_title');
        $this->data['entry_duplicate_title'] = $this->language->get('entry_duplicate_title');
        $this->data['entry_remove_source_images_title'] = $this->language->get('entry_remove_source_images_title');

        $this->data['entry_last_run_description'] = $this->language->get('entry_last_run_description');
        $this->data['entry_type_select_description'] = $this->language->get('entry_type_select_description');
        $this->data['entry_missing_description'] = $this->language->get('entry_missing_description');
        $this->data['entry_duplicate_description'] = $this->language->get('entry_duplicate_description');
        $this->data['entry_remove_source_images_description'] = $this->language->get('entry_remove_source_images_description');

        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_isbn'] = $this->language->get('isbn');
        $this->data['text_ean'] = $this->language->get('ean');
        $this->data['text_jan'] = $this->language->get('jan');
        $this->data['text_sku'] = $this->language->get('sku');
        $this->data['text_name'] = $this->language->get('name');
        $this->data['text_mpn'] = $this->language->get('mpn');
        $this->data['text_upc'] = $this->language->get('upc');
        $this->data['text_model'] = $this->language->get('model');
        $this->data['text_find'] = $this->language->get('text_find');
        $this->data['text_overwrite'] = $this->language->get('text_overwrite');
        $this->data['text_ignore'] = $this->language->get('text_ignore');
        $this->data['text_increment'] = $this->language->get('text_increment');

        $this->data['last_run'] = $this->config->get('massimgrename_last_run');
        $this->data['massimgrename_max_product_req'] = $this->config->get('massimgrename_max_product_req');
        if (strlen($this->data['last_run']) < 1) {
            $this->data['last_run'] = '0000-00-00 00:00:00';
        }

        $this->data['mode'] = $this->config->get('massimgrename_mode');
        $this->data['action_duplicate'] = $this->config->get('massimgrename_action_duplicate');
        $this->data['action_missing'] = $this->config->get('massimgrename_action_missing');
        $this->data['remove_source_images'] = $this->config->get('massimgrename_remove_source_images');


        $this->template = 'module/massimgrename.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function getform() {
        $this->template = 'module/massimgrename.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
    }

    public function reset() {
        $settings["massimgrename_last_run"]="0000-00-00 00:00:00";
        $this->update($settings);
    }
    
    private function update($settings = null) {
        if ($settings == null) {
            $settings = $this->request->post;
        }
        unset($settings['token']);
        unset($settings['route']);
        unset($settings['path']);
//var_dump($settings);
        $this->load->model('setting/setting');
        $this->load->language('module/massimgrename');

        if (!isset($settings['massimgrename_last_run']) || empty($settings['massimgrename_last_run'])) {
            $settings['massimgrename_last_run'] = $this->config->get('massimgrename_last_run');
        }

        if (!isset($settings['massimgrename_mode']) || empty($settings['massimgrename_mode'])) {
            $settings['massimgrename_mode'] = $this->config->get('massimgrename_mode');
        }

        if (!isset($settings['massimgrename_action_duplicate']) || empty($settings['massimgrename_action_duplicate'])) {
            $settings['massimgrename_action_duplicate'] = $this->config->get('massimgrename_action_duplicate');
        }

        if (!isset($settings['massimgrename_action_missing']) || empty($settings['massimgrename_action_missing'])) {
            $settings['massimgrename_action_missing'] = $this->config->get('massimgrename_action_missing');
        }

        if (!isset($settings['massimgrename_remove_source_images']) || empty($settings['massimgrename_remove_source_images'])) {
            $settings['massimgrename_remove_source_images'] = $this->config->get('massimgrename_remove_source_images');
        }
        if (!isset($settings['massimgrename_max_product_req']) || empty($settings['massimgrename_max_product_req'])) {
            $settings['massimgrename_max_product_req'] = $this->config->get('massimgrename_max_product_req');
        }


        $this->model_setting_setting->editSetting('massimgrename', $settings);
        $this->session->data['success'] = $this->language->get('massimgrename_text_success');
    }

    public function updatesettings() {
        $this->update();
        $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function randomize() {
        $this->update();
        $this->load->model('setting/setting');
        $this->load->model('module/massimgrename');

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['type'])) {
            $type = $this->request->get['type'];
        } else {
            $type = "product";
        }

        $data = array(
            'start' => ($page - 1) * $this->limit,
            'limit' => $this->limit
        );

        if ($type == "thumbs") {
            $total = $this->model_module_massimgrename->getTotalthumbs();
            $images = $this->model_module_massimgrename->getimages($data);
        } else {
            $total = $this->model_module_massimgrename->getTotalproductimages();
            $images = $this->model_module_massimgrename->getproductimages($data);
        }

        $num_pages = ceil($total / $data['limit']);

//var_dump($images);
        //replace all imagenames that = image_name with random name 
        foreach ($images as $image) {
//	//generate random name
            $image['new_image'] = $this->model_module_massimgrename->randomfilename($image['image']);
            //  var_dump($image);
            if ($type == "thumbs") {
                $query = $this->model_module_massimgrename->update_image($image);
            } else {
                $query = $this->model_module_massimgrename->update_product_image($image);
            }
//	copy old file to new filename
            if (strlen($image['image']) > 1) {
                $this->model_module_massimgrename->copyimage($image);
            }

            //delete old filename
            $this->model_module_massimgrename->delete($image);
        }

        $results['page'] = $page;
        $results['num_pages'] = $num_pages;
        $this->response->setOutput(json_encode($results));
    }

    public function process() {
        $settings = null;
        if(isset($this->request->post)){
        $settings = $this->request->post;
        //cut 2 peices from array
        }
        $settings['massimgrename_last_run']=date('Y-m-d H:i:s');

        $this->load->model('setting/setting');
        $this->load->model('module/massimgrename');
        $this->load->model('catalog/product');

        $lastrun = $this->config->get('massimgrename_last_run');
        $mode = $this->config->get('massimgrename_mode');
        $this->limit = (int)$this->config->get('massimgrename_max_product_req');

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
            $this->update($settings);
        }


        $data = array(
            'start' => ($page - 1) * $this->limit,
            'limit' => $this->limit,
            'lastrun' => $lastrun
        );


        $total = $this->model_module_massimgrename->getTotalproductimages($data);
        $products = $this->model_module_massimgrename->getmodifiedproducts($data);
        // var_dump($products);
        $products['mode'] = $mode;
        
        $num_pages = ceil($total / $data['limit']);
       
        if($num_pages == 0){
            $num_pages =1;
        }
        
        if($this->debug == true)
        {
            echo 'we found ' . $total .' products <br> ' ;
            echo 'we will process '.$data['limit'].' products ea. split into batches of '.$num_pages .' <br>`(batches are seperated by the &page=pagenum var)<br>';
        }
        
        $this->processProducts($products);

        $results['page'] = $page;
        $results['num_pages'] = $num_pages;
        $results['last_run'] = $settings['massimgrename_last_run'];
         
if($this->debug == false){
   $this->response->setOutput(json_encode($results)); 
}
    }

    public function processProducts($data) {

        $mode = $data['mode'];
        
        foreach ($data as $product) {
            if(isset($product['product_id'])){
  $pd = $this->model_catalog_product->getProductDescriptions($product['product_id']);

                if (isset($pd[1])) {
                    $product['name'] = $this->model_module_massimgrename->slugify($pd[1]['name']);
                }
            }
            //is the product field not empty ie is product['sku'] != ''
            if (isset($product[$mode]) && strlen($product[$mode]) > 1 && strlen($product['image']) > 1) {
              
                if ($this->debug == true) {
                    echo '<hr>';
                    echo 'Retrieving product :' . $product['product_id'];
                    echo '<br>';
                    echo 'The products original image is : ' . $product['image'];
                    echo '<br>';
                    echo '<br>';
                    //give the image a random name
                    echo 'Step 1: Give the file a random name to avoid collisions';
                    echo '<br>';
                }
                //       $this->model_module_massimgrename->copytofolder($product);
                $product['new_image'] = $this->model_module_massimgrename->randomfilename($product['image']);
                if($this->debug == true)
                    {
                echo 'The products new image filename will be : ' . $product['new_image'];
                echo '<br>';
                //var_dump($product);
                //copy old image filename to new filename
                      echo 'Creating a new file based on the old image in the filesystem';
                    echo '<br>';
                    }
                $this->model_module_massimgrename->copyimage($product);
                //update db with new filename
                if($this->debug == true)
                    {
                   echo 'updating product image in db to: '.$product['new_image'];
                   echo '<br>';
                    }
                $this->model_module_massimgrename->update_product_image_by_product_id($product);
                //delete
                $this->model_module_massimgrename->delete($product);
                if($this->debug == true)
                    {
echo 'product image :' . $product['image'] . ' was deleted <br>';
                // var_dump($product);
echo '<br>';
                echo 'Step 2: Give the file its final name <br>';
                echo 'Creating a new filename based on ' . $mode;
                echo '<br>';
                echo 'The products current image is ' . $product['image'];
                echo '<br>';
                    }
                 //make product image reflect new image 
                $product['image'] = $product['new_image'];
                $product['new_image'] = $this->model_module_massimgrename->makefilename($mode, $product);
                if($this->debug == true)
                    {
                echo 'The products new image will be  ' . $product['new_image'];
                echo '<br>';
                    }
                    
                $this->model_module_massimgrename->processproductimage($mode, $product);
                //var_dump($pimages);
         
                $this->model_module_massimgrename->copyimage($product);
                $this->model_module_massimgrename->update_product_image_by_product_id($product);
//                $this->model_module_massimgrename->update_openbay_image_links($product);
                $this->model_module_massimgrename->delete($product);
//get related images
                if($this->debug == true)
                    {
                echo '<p>';
                echo 'Step 3: Lets process the thumbnails:';
                echo '<br>';
                    }
                //change all product thumbs to random name
                $images = $this->model_catalog_product->getProductImages($product['product_id']);

                foreach ($images as $image) {
                    $image['new_image'] = $this->model_module_massimgrename->randomfilename($image['image']);
                    if($this->debug == true)
                    {
                    echo 'Thumbnail Image id: ' . $image['product_image_id'];
                    echo '<br>';
                    echo 'give thumb a random name: '. $image['new_image'];
                    echo '<br>';
                    
//                    //copy old image filename to new filename
                    echo 'copy new thumb  to fs';
                    echo '<br>';
                    }
                    $this->model_module_massimgrename->copyimage($image);
                    //update db with new filename
                    if($this->debug == true)
                    {
                    echo 'updating product thumb in db to: ' .$image['new_image'];
                    echo '<br>';
                    }
                    
                    $this->model_module_massimgrename->update_thumb_image($image);
                if($this->debug == true)
                    {
                    echo 'deleting image: ' .$image['image'];
                    echo '<br>';
                    }
                    $this->model_module_massimgrename->delete($image);

                    //make a thumb with mode
                    $image['image'] = $image['new_image'];
                    $image[$mode] = $product[$mode];
                    if($this->debug == true)
                    {
                    echo '<br>make a new thumb  based on  ' . $mode;
                    echo '<br>';
                    echo 'Image id: ' . $image['product_image_id'];
                    echo '<br>';
                    echo 'the product original thumb image is ' . $image['image'];
                    echo '<br>';
                    }
                    $image['new_image'] = $this->model_module_massimgrename->makefilename($mode, $image);
                    if($this->debug == true)
                    {
                    echo 'new image will be  ' . $image['new_image'];
                    echo '<br>';
                    }
                    $image = $this->model_module_massimgrename->processproductimage($mode, $image);
                    if($this->debug == true)
                    {
                    //var_dump($pimages);
                    echo 'copy new thumb  to fs';
                    echo '<br>';
                    }

                    $this->model_module_massimgrename->copyimage($image);
if($this->debug == true)
                    {
                    echo 'updating product thumb in db to: '.$image['new_image'];
                    echo '<br>';
                    }
                    $this->model_module_massimgrename->update_thumb_image($image);
                    $this->model_module_massimgrename->update_product_image_by_product_id($product);
                    //$this->model_module_massimgrename->update_openbay_image_links($image);
                    $this->model_module_massimgrename->delete($image);
                }
                if($this->debug == true)
                    {
                echo '</p>';
                    }
            } else {
                if($this->debug == true)
                    {
                 
                echo '<hr>';
                   if(! isset($product['product_id'])){
                         echo 'No New Products were found';
                    }else{
                         echo 'the product ' . $product['product_id'] . ' has no ' . $mode;
                    }
               
                echo '<br>';
                    }
            }

        }
    }

    public function install() {
        $sql = "INSERT INTO " . DB_PREFIX . "setting (
	`setting_id` ,
	`store_id` ,
	`group` ,
	`key` ,
	`value` ,
	`serialized`
	)
	VALUES (
	NULL , '0', 'massimgrename', 'massimgrename_last_run', '2019-05-14 11:11:37', '0'
	),
	(
	NULL , '0', 'massimgrename', 'massimgrename_mode', 'model', '0'
	),
	(
	NULL , '0', 'massimgrename', 'massimgrename_max_product_req', '200', '0'
	)
	;";
       
        $this->load->model('module/massimgrename');
        $this->db->query($sql);

       
    }

    public function uninstall() {
        $this->db->query("
	DELETE FROM " . DB_PREFIX . "setting 
	WHERE `group` = 'massimgrename' 
	");
 
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/massimgrename ')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>