<?php echo $header; ?>
<script>
$(function(){
	$('input[name="address_1"]').parent().parent().hide();
	$('input[name="address_2"]').parent().parent().hide();
	$('input[name="numero"]').parent().parent().hide();
	$('input[name="complemento"]').parent().parent().hide();
	$('input[name="city"]').parent().parent().hide();
	$('select[name="country_id"]').parent().parent().hide();
	$('select[name="zone_id"]').parent().parent().hide();
	if ($('input[name="postcode"]').val().length != 0 ) {
		$('input[name="address_1"]').parent().parent().fadeIn('slow');
		$('input[name="address_2"]').parent().parent().fadeIn('slow');
		$('input[name="numero"]').parent().parent().fadeIn('slow');
		$('input[name="complemento"]').parent().parent().fadeIn('slow');
		$('input[name="city"]').parent().parent().fadeIn('slow');
		$('select[name="country_id"]').parent().parent().fadeIn('slow');
		$('select[name="zone_id"]').parent().parent().fadeIn('slow');
	}		
	$('input[name="postcode"]').blur(function(){
		
		if ($('input[name="postcode"]').val().length != 0 ) {
			$('input[name="address_1"]').parent().parent().fadeIn('slow');
			$('input[name="address_2"]').parent().parent().fadeIn('slow');
			$('input[name="numero"]').parent().parent().fadeIn('slow');
			$('input[name="complemento"]').parent().parent().fadeIn('slow');
			$('input[name="city"]').parent().parent().fadeIn('slow');
			$('select[name="country_id"]').parent().parent().fadeIn('slow');
			$('select[name="zone_id"]').parent().parent().fadeIn('slow');

			cep = $.trim($('input[name="postcode"]').val().replace('-', ''));
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+cep, function(){
				if(resultadoCEP["resultado"] == "1"){
					$('input[name="address_1"]').val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
					$('input[name="address_2"]').val(unescape(resultadoCEP["bairro"]));
					$('input[name="city"]').val(unescape(resultadoCEP["cidade"]));
					$('select[name=\'zone_id\']').load('index.php?route=account/cadastro/estado_autocompletar&estado='+unescape(resultadoCEP["uf"]));			
				}else{
					alert("Endereço do cep não encontrado. Digite o endereço manualmente!");
				}
			});
		}	
	});
});	

<?php if ($error_warning) { ?>
$.colorbox({
	overlayClose: true,
	opacity: 0.3,
	width: '720px',
	height: '110px',
	href: false,
	html: '<div class="warning"><?php echo $error_warning; ?></div>'
});	

<?php } ?>
</script>

<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <p><?php echo $text_account_already; ?></p>
      
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="register" class="form-horizontal">
        <fieldset id="account">
          <legend><?php echo $text_your_details; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-firstname">Nome Completo</label>
            <div class="col-sm-10">
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
  
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="telephone"><?php echo $entry_telephone; ?></label>
            <div class="col-sm-10">
             <div class="row">
                                      <div class="col-sm-1 col-xs-12 col-ddd" style="padding-right:0px">
                                      <input type="tel" style="padding-right:2px" name="ddd" value="<?php echo $ddd; ?>" placeholder="ddd" id="ddd" class="form-control" />
                                     </div>
                                      <div class="col-sm-11 col-xs-12 col-tel" style="padding-left:2px">
                                      <input  type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="telephone" class="form-control" />
                                   </div>
              <?php if ($error_telephone) { ?>
              <div class="text-danger col-sm-12"><?php echo $error_telephone; ?></div>
              <?php } ?>
                       </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="telephone2">Celular</label>
            <div class="col-sm-10">
             <div class="row">
                                      <div class="col-sm-1 col-xs-12 col-ddd" style="padding-right:0px">
                                      <input type="tel" style="padding-right:2px" name="ddd2" value="<?php echo $ddd; ?>" placeholder="ddd" id="ddd" class="form-control" />
                                     </div>
                                      <div class="col-sm-11 col-xs-12 col-tel" style="padding-left:2px">
                                      <input  type="tel" name="telephone2" value="<?php echo $telephone2; ?>" placeholder="<?php echo $entry_telephone; ?>" id="telephone2" class="form-control" />
                                   </div>
                       </div>
            </div>
          </div>
          <div class="form-group sex">
            <label class="col-sm-2 control-label" for="sex">Sexo</label>
            <div class="col-sm-10">                     
          
           <?php if ($sex == '') { ?>
              <div class="radio col-radio">
                    <input type="radio"  name="sex" value="Masculino">  <label>Masculino</label></div>
              <div class="radio col-radio">
                    <input type="radio"  name="sex" value="Feminino">  <label>Feminino</label></div>
                    <?php } ?>
           <?php if ($sex == 'Masculino') { ?>
              <div class="radio col-radio">
                    <input type="radio"  name="sex" value="Masculino" checked="checked">  <label>Masculino</label></div>
              <div class="radio col-radio">
                    <input type="radio"  name="sex" value="Feminino">  <label>Feminino</label></div>
                    <?php } ?>
           <?php if ($sex == 'Feminino') { ?>
              <div class="radio col-radio">
                    <input type="radio"  name="sex" value="Masculino">  <label>Masculino</label></div>
              <div class="radio col-radio">
                    <input type="radio"  name="sex" value="Feminino" checked="checked">  <label>Feminino</label></div>
                    <?php } ?></lablel>
            </div>
          </div>
          <div class="form-group<?php if ($dados_nascimento){?> required<?php } ?>">
            <label class="col-sm-2 control-label" for="input-data_nascimento"> Data de Nascimento:</label>
            <div class="col-sm-10">
                                                <?php 
                                                $dataparts = explode("-",$data_nascimento);
                                                if (sizeof($dataparts)<>"3"){
                                                                       $data = $data_nascimento;
                                                }else{
                                                                       $data = $dataparts[2]."/".$dataparts[1]."/".$dataparts[0]; 
                                                }
                                                ?>
              <input type="text" name="data_nascimento" value="<?php echo $data; ?>" placeholder="Data de Nascimento" id="input-firstname" class="form-control" />
              <?php if ($error_data_nascimento) { ?>
              <div class="text-danger"><?php echo $error_data_nascimento; ?></div>
              <?php } ?>
            </div>
          </div>    
          
          <div class="form-group required">
            <label class="col-sm-2 control-label">Tipo:</label>
            <div class="col-sm-10">
                                                <?php if ($cpf<>"" ){?>
              <div class="radio col-radio">
                         <input type="radio" name="pessoa" id="fisica" checked value="fisica">
                
                <label>   Pessoa Física </label>
              </div>
              <div class="radio col-radio">
                         <input type="radio" id="juridica" name="pessoa" value="juridica">
                       
                <label>  Pessoa Juridica</label>
              </div>
              <?php } else { ?>
              <div class="radio col-radio">
                                                <input type="radio" name="pessoa" id="fisica" value="fisica">
				
                <label>  Pessoa Física </label>
              </div>
              <div class="radio col-radio">
                                                <input type="radio" id="juridica" name="pessoa" checked value="juridica">
				
                <label>  Pessoa Juridica</label>
                </label>
              </div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group<?php if ($dados_cpf){?> required<?php } ?> pessoa_fisica">
            <label class="col-sm-2 control-label" for="cpf">CPF</label>
            <div class="col-sm-10">
              <input type="text" name="cpf" value="<?php echo $cpf; ?>" placeholder="CPF" id="cpf" class="form-control" />
              <?php if ($error_cpf) { ?>
              <div class="text-danger"><?php echo $error_cpf; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group<?php if ($dados_cnpj){?> required<?php } ?> pessoa_juridica">
            <label class="col-sm-2 control-label" for="cnpj">CNPJ</label>
            <div class="col-sm-10">
              <input type="text" name="cnpj" value="<?php echo $cpf; ?>" placeholder="CNPJ" id="cnpj" class="form-control" />
              <?php if ($error_cnpj) { ?>
              <div class="text-danger"><?php echo $error_cnpj; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group pessoa_juridica">
            <label class="col-sm-2 control-label" for="razao_social">Razão Social</label>
            <div class="col-sm-10">
              <input type="text" name="razao_social" value="<?php echo $razao_social; ?>" placeholder="Razão Social" id="razao_social" class="form-control" />
            </div>
          </div>
          <div class="form-group pessoa_juridica">
            <label class="col-sm-2 control-label" for="inscricao_estadual">Inscrição Estadual</label>
            <div class="col-sm-10">
              <input type="text" name="inscricao_estadual" value="<?php echo $inscricao_estadual; ?>" placeholder="Inscrição Estadual" id="inscricao_estadual" class="form-control" />
            </div>
          </div>
        </fieldset>
        <fieldset id="address">
          <legend><?php echo $text_your_address; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-address-1">Endereço</label>
            <div class="col-sm-10">
              <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1" class="form-control" />
              <?php if ($error_address_1) { ?>
              <div class="text-danger"><?php echo $error_address_1; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="numero">Número</label>
            <div class="col-sm-10">
              <input type="text" name="numero" value="<?php echo $numero; ?>" placeholder="Número" id="numero" class="form-control" />
              <?php if ($error_numero) { ?>
              <div class="text-danger"><?php echo $error_numero; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group pessoa_juridica">
            <label class="col-sm-2 control-label" for="complemento">Complemento</label>
            <div class="col-sm-10">
              <input type="text" name="complemento" value="<?php echo $complemento; ?>" placeholder="Complemento" id="complemento" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-address-2"><?php echo $entry_address_2; ?></label>
            <div class="col-sm-10">
              <input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
            <div class="col-sm-10">
              <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
              <?php if ($error_city) { ?>
              <div class="text-danger"><?php echo $error_city; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
            <div class="col-sm-10">
              <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
              <?php if ($error_postcode) { ?>
              <div class="text-danger"><?php echo $error_postcode; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
            <div class="col-sm-10">
              <select name="country_id" id="input-country" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_country) { ?>
              <div class="text-danger"><?php echo $error_country; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
            <div class="col-sm-10">
              <select name="zone_id" id="input-zone" class="form-control">
              </select>
              <?php if ($error_zone) { ?>
              <div class="text-danger"><?php echo $error_zone; ?></div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        <fieldset id="cadastro">
          <legend><?php echo $text_your_password; ?></legend>

      <?php 
	  if ($guest_checkout){	 
			//$selecionar = "checked";
			$selecionar = "";
	  ?>
          <div class="form-group required">
            <div class="col-sm-10">
	   <input type="checkbox" name="visitante" id="visitante" value="1" <?php echo $selecionar; ?> > <label for="visitante">Ao marcar essa opção você estará comprando como visitante e não precisará colocar uma senha. A desvantagem disso é que não poderá acompanhar seu pedido pela loja.</label><br><br> 
                          
            </div>
          </div>	
	  <script>
		$(document).ready(function(){
			 if ($("#visitante").is(":checked")){
					$("#cadastro").hide();
			   }else{
					$("#cadastro").show();
			   }
			$("#visitante").click(function(){   
			   if ($("#visitante").is(":checked")){
					$("#cadastro").hide();
			   }else{
					$("#cadastro").show();
			   }
			});   
		});
	  </script>
	  <?php } ?>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" id="input-confirm" class="form-control" />
              <?php if ($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        
        
        <fieldset>
          <legend><?php echo $text_newsletter; ?></legend>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_newsletter; ?></label>
            <div class="col-sm-10">
              <?php if ($newsletter) { ?>
              <label class="radio-inline">
                <input type="radio" name="newsletter" value="1" checked="checked" />
                <?php echo $text_yes; ?></label>
              <label class="radio-inline">
                <input type="radio" name="newsletter" value="0" />
                <?php echo $text_no; ?></label>
              <?php } else { ?>
              <label class="radio-inline">
                <input type="radio" name="newsletter" value="1" />
                <?php echo $text_yes; ?></label>
              <label class="radio-inline">
                <input type="radio" name="newsletter" value="0" checked="checked" />
                <?php echo $text_no; ?></label>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        
        <?php if ($text_agree) { ?>
        <div class="buttons">
          <div class="pull-right"><?php echo $text_agree; ?>
            <?php if ($agree) { ?>
            <input type="checkbox" name="agree" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree" value="1" />
            <?php } ?>
            &nbsp;
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
        <?php } else { ?>
        <div class="buttons">
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
        <?php } ?>
  </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=account/account/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('input[name=\'postcode\']').parent().parent().removeClass('required');
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';
					
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
					}
				
					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});
//--></script> 
<?php echo $footer; ?>