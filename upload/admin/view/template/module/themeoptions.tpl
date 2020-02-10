<?php echo $header; ?>

<?php // Normal and Google fonts array
	$fonts = array(
		'Arial'                 => 'Arial',
		'Verdana'               => 'Verdana',
		'Helvetica'             => 'Helvetica',
        'Helvetica+Neue'        => 'Helvetica Neue',
		'Lucida+Grande'         => 'Lucida Grande',
		'Trebuchet+MS'          => 'Trebuchet MS',
		'Times+New+Roman'       => 'Times New Roman',
		'Tahoma'                => 'Tahoma',
		'Georgia'               => 'Georgia',
        ''                      => '-- GOOGLE FONTS --',
		'Abel'                  => 'Abel',
		'Abril+Fatface'         => 'Abril Fatface',
		'Acme'                  => 'Acme',
		'Adamina'               => 'Adamina',
		'Advent+Pro'            => 'Advent Pro',
		'Alfa+Slab+One'         => 'Alfa Slab One',
		'Alice'                 => 'Alice',
		'Allan'                 => 'Allan',
		'Amaranth'              => 'Amaranth',
		'Amatic+SC'             => 'Amatic SC',
		'Andika'                => 'Andika',
		'Anonymous+Pro'         => 'Anonymous Pro',
		'Anton'                 => 'Anton',
		'Arimo'                 => 'Arimo',
		'Bangers'               => 'Bangers',
		'Basic'                 => 'Basic',
		'Baumans'               => 'Baumans',
		'Belgrano'              => 'Belgrano',
		'Berkshire+Swash'       => 'Berkshire Swash',
		'Bitter'                => 'Bitter',
		'Boogaloo'              => 'Boogaloo',
		'Brawler'               => 'Brawler',
		'Bree+Serif'            => 'Bree Serif',
		'Bubblegum+Sans'        => 'Bubblegum Sans',
		'Buda'                  => 'Buda',
		'Cabin+Condensed'       => 'Cabin Condensed',
		'Cabin+Sketch'          => 'Cabin Sketch',
		'Caudex'                => 'Caudex',
		'Contrail+One'          => 'Contrail One',
		'Courgette'             => 'Courgette',
		'Coustard'              => 'Coustard',
		'Crushed'               => 'Crushed',
		'Cuprum'                => 'Cuprum',
		'Damion'                => 'Damion',
		'Days+One'              => 'Days One',
		'Dorsa'                 => 'Dorsa',
		'Droid+Sans'            => 'Droid Sans',
		'Droid+Serif'           => 'Droid Serif',
		'Duru+Sans'             => 'Duru Sans',
		'Enriqueta'             => 'Enriqueta',
		'Federo'                => 'Federo',
		'Francois+One'          => 'Francois One',
		'Fredericka+the+Great'  => 'Fredericka the Great',
		'Fredoka+One'           => 'Fredoka One',
		'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911',
		'Gruppo'                => 'Gruppo',
		'Homenaje'              => 'Homenaje',
		'Imprima'               => 'Imprima',
		'Inder'                 => 'Inder',
		'Istok+Web'             => 'Istok Web',
		'Jockey+One'            => 'Jockey One',
		'Josefin+Slab'          => 'Josefin Slab',
		'Just+Another+Hand'     => 'Just Another Hand',
		'Kaushan+Script'        => 'Kaushan Script',
		'Kotta+One'             => 'Kotta One',
		'Lemon'                 => 'Lemon',
		'Lobster+Two'           => 'Lobster Two',
		'Lobster'               => 'Lobster',
		'Maiden+Orange'         => 'Maiden Orange',
		'Marvel'                => 'Marvel',
		'Merienda+One'          => 'Merienda One',
		'Molengo'               => 'Molengo',
		'Montserrat'            => 'Montserrat',
		'News+Cycle'            => 'News Cycle',
		'Niconne'               => 'Niconne',
		'Nixie+One'             => 'Nixie One',
		'Nobile'                => 'Nobile',
		'Oleo+Script'           => 'Oleo Script',
		'Open+Sans'             => 'Open Sans',
		'Overlock'              => 'Overlock',
		'Ovo'                   => 'Ovo',
		'PT+Sans'               => 'PT Sans',
		'Philosopher'           => 'Philosopher',
		'Playball'              => 'Playball',
		'Poiret+One'            => 'Poiret One',
		'Quando'                => 'Quando',
		'Quattrocento+Sans'     => 'Quattrocento Sans',
		'Quicksand'             => 'Quicksand',
		'Raleway'               => 'Raleway',
		'Righteous'             => 'Righteous',
		'Rokkitt'               => 'Rokkitt',
		'Ropa+Sans'             => 'Ropa Sans',
		'Sansita+One'           => 'Sansita One',
		'Sofia'                 => 'Sofia',
		'Source+Sans+Pro'       => 'Source Sans Pro',
		'Stoke'                 => 'Stoke',
		'Ubuntu'                => 'Ubuntu',
		'Wire+One'              => 'Wire One',
		'Yanone+Kaffeesatz'     => 'Yanone Kaffeesatz',
		'Yellowtail'            => 'Yellowtail'
		); 
	

// Default values
if(empty($themeoptions_title_font)) $themeoptions_title_font                         ="Helvetica Neue";
if(empty($themeoptions_body_font)) $themeoptions_body_font                           ="Helvetica Neue";
if(empty($themeoptions_small_font)) $themeoptions_small_font                         ="Helvetica Neue";
if(empty($themeoptions_title_font_size)) $themeoptions_title_font_size               ="32";
if(empty($themeoptions_body_font_size)) $themeoptions_body_font_size                 ="14";
if(empty($themeoptions_small_font_size)) $themeoptions_small_font_size               ="10";
if(empty($themeoptions_pattern_overlay)) $themeoptions_pattern_overlay               ="default";
if(empty($themeoptions_container_bg)) $themeoptions_container_bg           		     ="";
if(empty($themeoptions_footer_bg)) $themeoptions_footer_bg           			     ="";
if(empty($themeoptions_module_bg)) $themeoptions_module_bg           		     	 ="";

// Header
if(empty($themeoptions_menu_colour)) $themeoptions_menu_colour                    ="";
if(empty($themeoptions_menu_hover_background)) $themeoptions_menu_hover_background  ="";
if(empty($themeoptions_menu_hover)) $themeoptions_menu_hover                      ="";
if(empty($themeoptions_menu_background)) $themeoptions_menu_background            ="";
if(empty($themeoptions_dropdown_colour)) $themeoptions_dropdown_colour            ="";
if(empty($themeoptions_dropdown_hover)) $themeoptions_dropdown_hover              ="";
if(empty($themeoptions_dropdown_hover_bg)) $themeoptions_dropdown_hover_bg        ="";
if(empty($themeoptions_dropdown_background)) $themeoptions_dropdown_background    ="";
if(empty($themeoptions_topmenu_colour)) $themeoptions_topmenu_colour              ="";
if(empty($themeoptions_topmenu_hover_colour)) $themeoptions_topmenu_hover_colour  ="";
if(empty($themeoptions_topmenu_background)) $themeoptions_topmenu_background      ="";
if(empty($themeoptions_currency_colour)) $themeoptions_currency_colour              ="";
if(empty($themeoptions_currency_hover_colour)) $themeoptions_currency_hover_colour  ="";
if(empty($themeoptions_currency_background)) $themeoptions_currency_background      ="";
if(empty($themeoptions_currency_hover_background)) $themeoptions_currency_hover_background      ="";
if(empty($themeoptions_checkout_colour)) $themeoptions_checkout_colour     		  ="";
if(empty($themeoptions_checkout_hover)) $themeoptions_checkout_hover     		  ="";
if(empty($themeoptions_checkout_link)) $themeoptions_checkout_link    		  	  ="";
if(empty($themeoptions_checkoutlink_hover)) $themeoptions_checkoutlink_hover      ="";
if(empty($themeoptions_cart_border)) $themeoptions_cart_border    			      ="";
if(empty($themeoptions_menu_border)) $themeoptions_menu_border    			      ="";

// Body
if(empty($themeoptions_background_colour)) $themeoptions_background_colour                         ="";
if(empty($themeoptions_h1_title_colour)) $themeoptions_h1_title_colour                             ="";
if(empty($themeoptions_h2_title_colour)) $themeoptions_h2_title_colour                             ="";
if(empty($themeoptions_h3_title_colour)) $themeoptions_h3_title_colour                             ="";
if(empty($themeoptions_h4_title_colour)) $themeoptions_h4_title_colour                             ="";
if(empty($themeoptions_h5_title_colour)) $themeoptions_h5_title_colour                             ="";
if(empty($themeoptions_h6_title_colour)) $themeoptions_h6_title_colour                             ="";
if(empty($themeoptions_bodytext_colour)) $themeoptions_bodytext_colour                             ="";
if(empty($themeoptions_lighttext_colour)) $themeoptions_lighttext_colour                           ="";
if(empty($themeoptions_content_links_colour)) $themeoptions_content_links_colour                   ="";
if(empty($themeoptions_content_links_hover_colour)) $themeoptions_content_links_hover_colour       ="";
if(empty($themeoptions_breadcrumb_links_colour)) $themeoptions_breadcrumb_links_colour             ="";
if(empty($themeoptions_breadcrumb_links_hover_colour)) $themeoptions_breadcrumb_links_hover_colour ="";

// Footer
if(empty($themeoptions_footer_header_colour)) $themeoptions_footer_header_colour           ="";
if(empty($themeoptions_footer_text_colour)) $themeoptions_footer_text_colour               ="";
if(empty($themeoptions_footer_links_colour)) $themeoptions_footer_links_colour             ="";
if(empty($themeoptions_footer_links_hover_colour)) $themeoptions_footer_links_hover_colour ="";

// Add to cart buttons
if(empty($themeoptions_button_background_colour)) $themeoptions_button_background_colour ="";
if(empty($themeoptions_button_text_colour)) $themeoptions_button_text_colour             ="";
if(empty($themeoptions_button_border)) $themeoptions_button_border             ="";

// Products
if(empty($themeoptions_product_name_colour)) $themeoptions_product_name_colour             ="";
if(empty($themeoptions_product_name_hover_colour)) $themeoptions_product_name_hover_colour ="";
if(empty($themeoptions_normal_price_colour)) $themeoptions_normal_price_colour             ="";
if(empty($themeoptions_old_price_colour)) $themeoptions_old_price_colour                   ="";
if(empty($themeoptions_new_price_colour)) $themeoptions_new_price_colour                   ="";

// Other
if(empty($themeoptions_categories_menu_colour)) $themeoptions_categories_menu_colour             ="";
if(empty($themeoptions_categories_menu_hover_colour)) $themeoptions_categories_menu_hover_colour ="";
if(empty($themeoptions_categories_sub_colour)) $themeoptions_categories_sub_colour               ="";
if(empty($themeoptions_categories_sub_hover_colour)) $themeoptions_categories_sub_hover_colour   ="";
if(empty($themeoptions_categories_active_colour)) $themeoptions_categories_active_colour         ="";

if(empty($themeoptions_account_menu_colour)) $themeoptions_account_menu_colour             ="";
if(empty($themeoptions_account_menu_hover_colour)) $themeoptions_account_menu_hover_colour ="";
if(empty($themeoptions_account_sub_colour)) $themeoptions_account_sub_colour               ="";
if(empty($themeoptions_account_sub_hover_colour)) $themeoptions_account_sub_hover_colour   ="";
if(empty($themeoptions_account_active_colour)) $themeoptions_account_active_colour         ="";
?>

<style type="text/css">
	.customhelp { colour: #666; font-size:0.9em; }
	.color { <?php echo $entry_border_caption; ?>1px solid #AAA; }
	.pttrn {width:32px; display: inline-block; text-align: center;}
	#title_font_preview {
		font-size: <?php echo $themeoptions_title_font_size; ?>px; 
		font-family: "<?php echo str_replace("+", " ", $themeoptions_title_font); ?>";
	}
	#body_font_preview {
		font-size: <?php echo $themeoptions_body_font_size; ?>px; 
		font-family: "<?php echo str_replace("+", " ", $themeoptions_body_font); ?>";
	}
	#small_font_preview {
		font-size: <?php echo $themeoptions_small_font_size; ?>px; 
		font-family: "<?php echo str_replace("+", " ", $themeoptions_small_font); ?>";
	}
	#title_font_preview,
	#body_font_preview,
	#small_font_preview {
		padding: 6px 12px;
		background: #fefddf;
	}
</style>

<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
    <?php if ($success) { ?>
        <div class="success"><?php echo $success; ?></div>
    <?php }
	if ($error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>

<div class="box">

	<div class="heading">
		<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
		<div class="buttons">
            <a onclick="$('#form').attr('action', '<?php echo $action; ?>&continue=1');$('#form').submit();" class="button"><?php echo $button_apply; ?></a> 
        	<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
        </div>
	</div>

	<div class="content">

	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

		<div style="float:right; margin-<?php echo $entry_bottom_caption; ?> 10px">
			<label><?php echo $entry_status; ?></label> 
			<select name="themeoptions_status">
				<?php if ($themeoptions_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
				<?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				<?php } ?>
			</select>
		</div>

		<div id="settings_tabs" class="htabs clearfix">
		<a href="#custom_code_settings"><?php echo $entry_tab_custom_code; ?></a>
		</div>
        
        
		<div id="custom_code_settings" class="divtab">
		
			<table class="form">

				<tr>
					<td>
						<h3><?php echo $entry_custom_css_sub; ?></h3>
						<span class="customhelp"><?php echo $entry_custom_css_help; ?></span>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_custom_css; ?><p>
					<textarea name="themeoptions_custom_css" cols="52" rows="20" style="width:90%;"><?php echo $themeoptions_custom_css; ?></textarea>
						</td>
				</tr>

				<tr>
					<td>
						<h3><?php echo $entry_custom_js_sub; ?></h3>
						<span class="customhelp"><?php echo $entry_custom_js_help; ?></span>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_custom_js; ?><p>
					<textarea name="themeoptions_custom_js" cols="52" rows="20" style="width:90%;"><?php echo $themeoptions_custom_js; ?></textarea>
						</td>
				</tr>

			</table>

		</div>

		</form>

	</div>

</div>

<?php echo $footer; ?>

<script type="text/javascript">

	$('#settings_tabs a').tabs();

</script>