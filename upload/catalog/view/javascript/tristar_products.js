// JavaScript Document

  function addtoprice(obj,pid)
  {
	  $.ajax({
		url: 'index.php?route=product/product/calculate&product_id=' + pid,
		type: 'post',
		data: $('.product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select'  ),
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				// $("#rrp").val(json['price'])
				//var price =  +$('#ptoadd').val() + +json['price'].substring(1); 
				//var p = "&pound;"+price;
				 $('#pricediv').html(json['price'])
				 $('#taxdiv').html(json['tax'])
				
				
			}
		}
		 }); 
	
	   
		
		
	  
  }
