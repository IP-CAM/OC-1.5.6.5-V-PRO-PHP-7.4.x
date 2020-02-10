<?php
class ControllerModuleDisplaySettings extends Controller
{
    private $error = array();

    public function index()
    {

        //Load the language file for this module
        $this->load->language('module/displaySettings');


        //Set the title from the language file $_['heading_title'] string
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

        //Load the settings model. You can also add any other models you want to load here.
        $this->load->model('setting/setting');

        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {


            $this->model_setting_setting->editSetting('displaySettings', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');


            $this->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->
                session->data['token']);
        }

        //This is how the language gets pulled through from the language file.
        //
        // If you want to use any extra language items - ie extra text on your admin page for any reason,
        // then just add an extra line to the $text_strings array with the name you want to call the extra text,
        // then add the same named item to the $_[] array in the language file.
        //
        // 'my_module_example' is added here as an example of how to add - see admin/language/english/module/my_module.php for the
        // other required part.

        $text_strings = array('heading_title', 'text_enabled', 'text_disabled', 'text_all', 'text_none',
            'text_left', 'text_right', 'text_home', 'entry_position', 'entry_status',
            'entry_sort_order', 'button_save', 'button_cancel', 'text_ds_list', 'text_ds_grid', 'text_ds_product', 'text_ds_column', 'text_ds_line', 'text_ds_settings1', 'text_ds_settings2', 'text_ds_settings3', 'text_ds_settings4', 'text_ds_settings5', 'text_ds_settings6', 'text_ds_settings7','text_ds_brands', 'text_ds_model', 'text_ds_sku', 'text_ds_upc', 'text_ds_ean', 'text_ds_jan', 'text_ds_isbn', 'text_ds_mpn', 'text_ds_quantity', 'text_ds_sales', 'text_ds_views', 'text_ds_stockstatus', 'text_ds_requires_shipping', 'text_ds_date_available', 'text_ds_dimensions', 'text_ds_weight', 'text_ds_categories', 'text_ds_attribute', 'text_ds_options', 'text_ds_description', 'text_ds_save', 'text_ds_save_percent', 'text_ds_special_date', 'text_ds_special_time', 'text_ds_reward','text_ds_points', 'text_ds_all_prices', 'text_ds_rating', 'text_ds_requires_shipping', 'text_ds_reviews'
            //this is an example extra field added
            );

			
			
			
        foreach ($text_strings as $text) {
            $this->data[$text] = $this->language->get($text);
        }

        //END LANGUAGE


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }


        //SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
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
			'href'      => $this->url->link('module/displaySettings', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/displaySettings', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];


        // This array allows your module to appear in one of three positions: The home page, or the left or right column.
        // If yours is just a home page or just a left or just a right column, then remove the unwanted blocks of code here
        // to remove other choices
  


        //The following code pulls in the required data from either config files or user
        //submitted data (when the user presses save in admin). Add any extra config data
        // you want to store.
        //
        // NOTE: These must have the same names as the form data in your my_module.tpl file
        //
        $config_data = array(
'config_list_brands',
'config_list_model',
'config_list_sku',
'config_list_upc',
'config_list_ean',
'config_list_jan',
'config_list_isbn',
'config_list_mpn',
'config_list_quantity',
'config_list_sales',
'config_list_views',
'config_list_stockstatus',
'config_list_requires_shipping',
'config_list_date_available',
'config_list_dimensions',
'config_list_weight',
'config_list_categories',
'config_list_attribute',
'config_list_options',
'config_list_description',
'config_list_save',
'config_list_save_percent',
'config_list_special_date',
'config_list_special_time',
'config_list_points',
'config_list_reward',
'config_list_all_prices',
'config_list_rating',
'config_list_requires_shipping',
'config_list_reviews',
'config_grid_brands',
'config_grid_model',
'config_grid_sku',
'config_grid_upc',
'config_grid_ean',
'config_grid_jan',
'config_grid_isbn',
'config_grid_mpn',
'config_grid_quantity',
'config_grid_sales',
'config_grid_views',
'config_grid_stockstatus',
'config_grid_requires_shipping',
'config_grid_date_available',
'config_grid_dimensions',
'config_grid_weight',
'config_grid_categories',
'config_grid_attribute',
'config_grid_options',
'config_grid_description',
'config_grid_save',
'config_grid_save_percent',
'config_grid_special_date',
'config_grid_special_time',
'config_grid_points',
'config_grid_reward',
'config_grid_all_prices',
'config_grid_rating',
'config_grid_requires_shipping',
'config_grid_reviews',
'config_product_brands',
'config_product_model',
'config_product_sku',
'config_product_upc',
'config_product_ean',
'config_product_jan',
'config_product_isbn',
'config_product_mpn',
'config_product_quantity',
'config_product_sales',
'config_product_views',
'config_product_stockstatus',
'config_product_requires_shipping',
'config_product_date_available',
'config_product_dimensions',
'config_product_weight',
'config_product_categories',
'config_product_attribute',
'config_product_options',
'config_product_description',
'config_product_save',
'config_product_save_percent',
'config_product_special_date',
'config_product_special_time',
'config_product_reward',
'config_product_points',
'config_product_all_prices',
'config_product_rating',
'config_product_requires_shipping',
'config_product_reviews'
        					);

        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $this->data[$conf] = $this->request->post[$conf];
            } else {
                $this->data[$conf] = $this->config->get($conf);
            }
        }

        //Choose which template file will be used to display this request, and send the output.
        $this->template = 'module/displaySettings.tpl';
        $this->children = array('common/header', 'common/footer');

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }


    /*
    * 
    * This function is called to ensure that the settings chosen by the admin user are allowed/valid.
    * You can add checks in here of your own.
    * 
    */
    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/displaySettings')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        //Example validation check: makes sure the user has selected a position.
        //NOTE: You shouldn't use a string like I have for the warning, you should set this string in the language file
        // and call it from there.

        //		elseif (!isset($this->request->post('latest_position'))) {
        //			$this->error['warning'] = "You haven't set a position";
        //		}

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
?>