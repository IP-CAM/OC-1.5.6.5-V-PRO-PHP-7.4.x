<?php
class ControllerModuleCsvcreator extends Controller{
	public $error = array();
	public function index(){
		
		$this->language->load('module/csvcreator');
		$this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting'); // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )
		$this->data['heading_title'] = $this->language->get('heading_title');
		 /* Making of Breadcrumbs to be displayed on site*/
	
        //Set up breadcrumb trail.
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
        'text'      => $this->language->get('heading_title'),
        'href'      => $this->url->link('module/helloworld', 'token=' . $this->session->data['token'], 'SSL'),
        'separator' => '  ::   '
    );
	
	  /*This Block returns the warning if any*/
    if (isset($this->error['warning'])) {
        $this->data['error_warning'] = $this->error['warning'];
    } else {
        $this->data['error_warning'] = '';
    }
    /*End Block*/
	$this->load->model('tool/image');
	
	
	$this->load->model('design/layout'); // Loading the Design Layout Models
 
    $this->data['layouts'] = $this->model_design_layout->getLayouts(); // Getting all the Layouts available on system
 
    $this->template = 'module/csvcreator.tpl'; // Loading the <span class="skimlinks-unlinked">helloworld.tpl</span> template
    $this->children = array(
        'common/header',
        'common/footer'
    );  // Adding children to our default template i.e., <span class="skimlinks-unlinked">helloworld.tpl</span> 
 	
	$this->response->setOutput($this->render()); // Rendering the Output
	}
	
	function file_csv()
	{
		$this->load->model('tool/image');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$results = $this->model_catalog_product->getProducts();
		
	   		$this->load->helper('csv_helper');
		 $fields = (
  		 $this->data['products'][] = array ("post_title","post_name","ID","post_excerpt","post_content","post_status","menu_order","post_date","post_parent","post_author","comment_status","sku","downloadable","virtual","visibility","stock","stock_status","backorders","manage_stock","regular_price","sale_price","weight","length","width","height","tax_status","tax_class","upsell_ids","crosssell_ids","featured","sale_price_dates_from","sale_price_dates_to","download_limit","download_expiry","product_url","button_text","meta:_yoast_wpseo_focuskw","meta:_yoast_wpseo_title","meta:_yoast_wpseo_metadesc","meta:_yoast_wpseo_metakeywords","images","downloadable_files","tax:product_type","tax:product_cat","tax:product_tag","tax:product_shipping_class","tax:vtwpr_rule_category","meta:total_sales")
                   );
				   
		foreach ($results as $result)
       {
		   if($result['image']){
			   $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
		   }
		   
		  $category = $this->model_catalog_product->getProductCategories($result['product_id']);
		
		if ($category){
  			$category_array = $this->model_catalog_category->getCategory($category[0]);
		
			$catname = htmlspecialchars_decode($category_array['name']);
		}
		if(isset($category[1])){ $category_array_sub =  $this->model_catalog_category->getCategory($category[1]);
		 $cat_name = $catname .'>'.  htmlspecialchars_decode($category_array_sub['name']); }
		   
		  $this->data['products'][] = array(
		  			'post_title'        => $result['name'],
					'post_name'         => $result['name'],
					'ID'				=> $result['product_id'],
					'post_excerpt'      => strip_tags(htmlspecialchars_decode($result['meta_description'])),
					'post_content'      => strip_tags(htmlspecialchars_decode($result['description'])),
					'post_status'       => 'publish',
					'menu_order'        => 0,
					'post_date'         => $result['date_added'],
					'post_parent'       => 0,
					'post_author'       => 'admin',
					'comment_status' 	=> 'open',
					'sku' 			    =>  $result['sku'],
					'downloadable'      => 'no',
					'virtual' 			=> 'no',
					'visibility' 		=> 'visible',
					'stock' 			=> '',
					'stock_status' 		=> 'instock',
					'backorders'      	=> 'no',
					'manage_stock'      => 'no',
					'regular_price'     => $result['price'],
					'sale_price' 		=> $result['price'],
					'weight' 			=> $result['weight'],
					'length'     		=> $result['length'],
					'width' 			=> $result['width'],
					'height'    		=> $result['height'],
					'tax_status' 		=> '',
					'tax_class' 		=> '',
					'upsell_ids'		=> '',
					'crosssell_ids'		=> '',
					'_featured'   		=> 'no',
					'sale_price_dates_from' 		=> '',
					'sale_price_dates_to_tmp' 		=> '',
					'download_limit' 	=> '',
					'download_expiry'	=> '',
					'product_url' 		=> '',
					'button_text'		=> '',
					'meta:_yoast_wpseo_focuskw' 	=> '',
					'meta:_yoast_wpseo_title'	    => '',
					'meta:_yoast_wpseo_metadesc' 	=> '',
					'meta:_yoast_wpseo_metakeywords'=> '',
					'images'            => $image,
					'downloadable_files'=> '',
					'tax:product_type'	=> '',
					'tax:product_cat' 	=> '',
					'tax:product_tag'	=> '',
					'tax:product_shipping_class'    => '',
					'tax:vtwpr_rule_category'  		=> '',
					'meta:total_sales'  => 0,
			    );
                  
       }
	   
	   $csv = new Csv_helper;
	   $csv->array_to_csv($this->data['products'],'products.csv');
	}
	
	
}