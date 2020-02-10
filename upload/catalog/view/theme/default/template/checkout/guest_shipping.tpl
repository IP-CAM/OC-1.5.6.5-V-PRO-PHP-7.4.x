<form class="form-horizontal">
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-shipping-firstname"><?php echo $entry_firstname; ?></label>
    <div class="col-sm-10">
      <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-shipping-firstname" class="form-control" />
    </div>
  </div>
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-shipping-lastname"><?php echo $entry_lastname; ?></label>
    <div class="col-sm-10">
      <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-shipping-lastname" class="form-control" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="input-shipping-company"><?php echo $entry_company; ?></label>
    <div class="col-sm-10">
      <input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-shipping-company" class="form-control" />
    </div>
  </div>
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-shipping-address-1"><?php echo $entry_address_1; ?></label>
    <div class="col-sm-10">
      <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-shipping-address-1" class="form-control" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="input-shipping-address-2"><?php echo $entry_address_2; ?></label>
    <div class="col-sm-10">
      <input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-shipping-address-2" class="form-control" />
    </div>
  </div>
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-shipping-city"><?php echo $entry_city; ?></label>
    <div class="col-sm-10">
      <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-shipping-city" class="form-control" />
    </div>
  </div>
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-shipping-postcode"><?php echo $entry_postcode; ?></label>
    <div class="col-sm-10">
      <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-shipping-postcode" class="form-control" />
    </div>
  </div>
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-shipping-country"><?php echo $entry_country; ?></label>
    <div class="col-sm-10">
      <select name="country_id" id="input-shipping-country" class="form-control">
        <option value=""><?php echo $text_select; ?></option>
        <?php foreach ($countries as $country) { ?>
        <?php if ($country['country_id'] == $country_id) { ?>
        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group required">
    <label class="col-sm-2 control-label" for="input-shipping-zone"><?php echo $entry_zone; ?></label>
    <div class="col-sm-10">
      <select name="zone_id" id="input-shipping-zone" class="form-control">
      </select>
    </div>
  </div>
  <div class="buttons">
    <div class="pull-right">
      <input type="button" value="<?php echo $button_continue; ?>" id="button-guest-shipping" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
    </div>
  </div>
</form>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script>
<script type="text/javascript"><!--
$('#collapse-shipping-address select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#collapse-shipping-address select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
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

			$('#collapse-shipping-address select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#collapse-shipping-address select[name=\'country_id\']').trigger('change');
//--></script>