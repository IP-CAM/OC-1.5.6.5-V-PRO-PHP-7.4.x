<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>

    <?php if (isset($this->session->data['success'])) { ?>
    <div class="success"><?php echo $this->session->data['success']; ?></div>
    <?php unset($this->session->data['success']); } ?>

    <?php if ($error_product_from_value) { ?>
    <div class="warning"><?php echo $error_product_from_value; ?></div>
    <?php } ?>
    <?php if ($error_product_to_value) { ?>
    <div class="warning"><?php echo $error_product_to_value; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form" style="width:48%; float:left;">
                    <tr>
                        <td><b><?php echo $entry_product_from; ?></b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_product; ?></td>
                        <td><input type="text" name="product_from" value="<?php echo $product_from;?>" id="product_from"/>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="javascript:void(0);" class="button" id="check_options">Check Options</a>
                            <input type="hidden" name="product_from_value" value="<?php echo $product_from_value;?>" id="product_from_value" /></td>
                    </tr>
                  

                </table>
                
                <table class="form" style="width:48%; float:right;">
                    <tr>
                        <td><b><?php echo $entry_product_to; ?></b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_product; ?></td>
                        <td><input type="text" name="product_to" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><div id="product_to" class="scrollbox" style="height:200px;">

                            </div>
                            <input type="hidden" name="product_to_value" value="" /></td>
                    </tr>
                </table>
<div id="search-result" style="float:left;  background:#D1D0CE;"></div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product_to\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.name,
                            value: item.product_id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('#product_to' + ui.item.value).remove();

            $('#product_to').append('<div id="product_to' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" value="' + ui.item.value + '" /></div>');

            $('#product_to div:odd').attr('class', 'odd');
            $('#product_to div:even').attr('class', 'even');

            data = $.map($('#product_to input'), function(element) {
                return $(element).attr('value');
            });

            $('input[name=\'product_to_value\']').attr('value', data.join());

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });

    $('#product_to div img').live('click', function() {
        $(this).parent().remove();

        $('#product_to div:odd').attr('class', 'odd');
        $('#product_to div:even').attr('class', 'even');

        data = $.map($('#product_to input'), function(element) {
            return $(element).attr('value');
        });

        $('input[name=\'product_to_value\']').attr('value', data.join());
    });
//--></script> 


<script type="text/javascript"><!--
$('input[name=\'product_from\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.name,
                            value: item.product_id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('#product_from').val(ui.item.label);
            $('#product_from_value').val(ui.item.value);

            return false;
        }

    });

    $("#check_options").live('click', function() {
        $.ajax({
            url: 'index.php?route=module/copy_product_options/getAProductOptions&token=<?php echo $token;?>',
            type: 'post',
            data: 'product_id='+$('#product_from_value').val(),
            dataType: 'html',
            success: function(html) {
                $("#search-result").html(html);

            }
        });
    });

//--></script> 

<?php echo $footer; ?>