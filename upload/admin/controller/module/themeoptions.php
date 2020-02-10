<?php

class ControllerModuleThemeOptions extends Controller {
    
    private $error = array(); 
    
    public function index() {   
        //Load the language file for this module
        $language = $this->load->language('module/themeoptions');
        $this->data = array_merge($this->data, $language);

        //Set the title from the language file $_['heading_title'] string
        $this->document->setTitle($this->language->get('heading_title'));
        
        //Load the settings model. You can also add any other models you want to load here.
        $this->load->model('setting/setting');
        
        $this->load->model('tool/image');    
        
        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('themeoptions', $this->request->post);    
            
			$this->session->data['success'] = $this->language->get('text_success');
			if(empty($this->request->get['continue'])) {
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
        }
        
            $this->data['text_image_manager'] = 'Image manager';
                    $this->data['token'] = $this->session->data['token'];       

            $this->data['themeoptions_footer_info_text'] = $this->language->get('themeoptions_footer_info_text');
        
        $text_strings = array(
                'heading_title',
                'text_enabled',
                'text_disabled',
                'text_content_top',
                'text_content_bottom',
                'text_column_left',
                'text_column_right',
                'entry_status',
                'entry_sort_order',
                'button_save',
                'button_cancel',
        );
        
        foreach ($text_strings as $text) {
            $this->data[$text] = $this->language->get($text);
        }
        

        // Theme Options config data array
        
        $config_data = array(

        'themeoptions_status',
		
		'themeoptions_topbar',
		'themeoptions_topbarscroll',
		'themeoptions_currency',
		'themeoptions_main_nav',
		'themeoptions_breadcrumb',
		'themeoptions_search',
		'themeoptions_center_logo',
		'themeoptions_cart',

        'themeoptions_custom_colours',
        'themeoptions_menu_colour',
		'themeoptions_menu_hover_background',
        'themeoptions_menu_hover',
		'themeoptions_menu_background',
        'themeoptions_dropdown_colour',
        'themeoptions_dropdown_hover',
		'themeoptions_dropdown_hover_bg',
		'themeoptions_dropdown_background',
		'themeoptions_topmenu_colour',
		'themeoptions_topmenu_hover_colour',
		'themeoptions_topmenu_background',
		'themeoptions_currency_colour',
		'themeoptions_currency_hover_colour',
		'themeoptions_currency_background',
		'themeoptions_currency_hover_background',
		'themeoptions_checkout_colour',
		'themeoptions_checkout_hover',
		'themeoptions_checkout_link',
		'themeoptions_checkoutlink_hover',
		'themeoptions_cart_border',
		'themeoptions_menu_border',
		
		'themeoptions_background_colour',
        'themeoptions_h1_title_colour',
		'themeoptions_h2_title_colour',
		'themeoptions_h3_title_colour',
		'themeoptions_h4_title_colour',
		'themeoptions_h5_title_colour',
		'themeoptions_h6_title_colour',
        'themeoptions_bodytext_colour',
		'themeoptions_content_links_colour',
		'themeoptions_content_links_hover_colour',
		'themeoptions_breadcrumb_links_colour',
		'themeoptions_breadcrumb_links_hover_colour',
		'themeoptions_breadcrumb_background',
        'themeoptions_lighttext_colour',

		'themeoptions_footer_header_colour',
        'themeoptions_footer_text_colour',
        'themeoptions_footer_links_colour',
		'themeoptions_footer_links_hover_colour',

        'themeoptions_button_background_colour',
        'themeoptions_button_text_colour',
		'themeoptions_button_border',

        'themeoptions_product_name_colour',
		'themeoptions_product_name_hover_colour',
        'themeoptions_normal_price_colour',
        'themeoptions_old_price_colour',
        'themeoptions_new_price_colour',
		
		'themeoptions_container_bg',
		'themeoptions_footer_bg',
		'themeoptions_module_bg',

        'themeoptions_categories_menu_colour',
		'themeoptions_categories_menu_hover_colour',
        'themeoptions_categories_sub_colour',
		'themeoptions_categories_sub_hover_colour',
        'themeoptions_categories_active_colour',
		
		'themeoptions_no_bg',
        'themeoptions_pattern_overlay',
        'themeoptions_custom_image',
        'themeoptions_custom_pattern',
        'themeoptions_image_preview',
        'themeoptions_pattern_preview',
        
        'themeoptions_title_font',
        'themeoptions_title_font_size',
        'themeoptions_body_font',
        'themeoptions_body_font_size',
        'themeoptions_small_font',
        'themeoptions_small_font_size',
		'themeoptions_center_heading',

        'themeoptions_copyright',
		'themeoptions_creds',
		
		'themeoptions_social_fb',
		'themeoptions_social_fb_icon',
		'themeoptions_social_twit',
		'themeoptions_social_gplus',
		'themeoptions_social_utube',
		'themeoptions_social_tumblr',
		'themeoptions_social_skype',
		'themeoptions_social_pinterest',
		'themeoptions_social_instagram',
		
		'themeoptions_cc_2co',
		'themeoptions_cc_alipay',
		'themeoptions_cc_amazon',
		'themeoptions_cc_americanexpress',
		'themeoptions_cc_asiapay',
		'themeoptions_cc_cashu',
		'themeoptions_cc_cirrus',
		'themeoptions_cc_dinersclub',
		'themeoptions_cc_discover',
		'themeoptions_cc_easycash',
		'themeoptions_cc_echeck',
		'themeoptions_cc_egold',
		'themeoptions_cc_eps',
		'themeoptions_cc_giropay',
		'themeoptions_cc_googlecheckout',
		'themeoptions_cc_jcb',
		'themeoptions_cc_laser',
		'themeoptions_cc_maestro',
		'themeoptions_cc_mastercard',
		'themeoptions_cc_moneybookers',
		'themeoptions_cc_obopay',
		'themeoptions_cc_paypal',
		'themeoptions_cc_pppay',
		'themeoptions_cc_sagepay',
		'themeoptions_cc_solo',
		'themeoptions_cc_switch',
		'themeoptions_cc_ukash',
		'themeoptions_cc_unionpay',
		'themeoptions_cc_visadebit',
		'themeoptions_cc_visacredit',
		'themeoptions_cc_visaelectron',
		'themeoptions_cc_westernunion',
		'themeoptions_cc_worldpay',
		'themeoptions_cc_xoom',

        'themeoptions_custom_css',
        'themeoptions_custom_js',

        );
        
        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $this->data[$conf] = $this->request->post[$conf];
            } else {
                $this->data[$conf] = $this->config->get($conf);
            }
        }
    
        //Create error and success messages
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
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
            'href'      => $this->url->link('module/themeoptions', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['action'] = $this->url->link('module/themeoptions', 'token=' . $this->session->data['token'], 'SSL');
        
        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
                
        $this->load->model('design/layout');
        
        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->load->model('localisation/language');
        
        $this->data['languages'] = $this->model_localisation_language->getLanguages();
        
        if (isset($this->request->post['themeoptions_module'])) {
            $this->data['themeoptions_module'] = $this->request->post['themeoptions_module'];
        } else {
            $this->data['themeoptions_module'] = $this->config->get('themeoptions_module');
        }

        //Choose which template file will be used to display this request.
        $this->template = 'module/themeoptions.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        if (isset($this->data['themeoptions_custom_pattern']) && $this->data['themeoptions_custom_pattern'] != "" && file_exists(DIR_IMAGE . $this->data['themeoptions_custom_pattern'])) {
            $this->data['themeoptions_pattern_preview'] = $this->model_tool_image->resize($this->data['themeoptions_custom_pattern'], 70, 70);
        } else {
            $this->data['themeoptions_pattern_preview'] = $this->model_tool_image->resize('no_image.jpg', 70, 70);
        }
        
        if (isset($this->data['themeoptions_custom_image']) && $this->data['themeoptions_custom_image'] != "" && file_exists(DIR_IMAGE . $this->data['themeoptions_custom_image'])) {
            $this->data['themeoptions_image_preview'] = $this->model_tool_image->resize($this->data['themeoptions_custom_image'], 70, 70);
        } else {
            $this->data['themeoptions_image_preview'] = $this->model_tool_image->resize('no_image.jpg', 70, 70);
        }

        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 70, 70);

        //Send the output.
        $this->response->setOutput($this->render());
    }
    
    /*
     * 
     * This function is called to ensure that the settings chosen by the admin user are allowed/valid.
     * You can add checks in here of your own.
     * 
     */
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/themeoptions')) {
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