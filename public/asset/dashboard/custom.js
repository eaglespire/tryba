//
// Quill.js
//
"use strict"
$('#ggglogin').on('click',function()
{
  $(this).html('<span class="spinner-border spinner-border-sm"></span> &nbsp; Please wait ...').prop('disabled','disabled');
  $('#payment-form').submit();
});

"use strict"
function gvals(){
	var amount = $("#amount3").val();
	var coupon = $("#coupon").val();
	var tax = $("#tax").val();
	var xx = $("#ship_fee").find(":selected").val();
	var myarr = xx.split("-");
	var ship_fee = myarr[1].split("<");
	var subtotal = parseFloat(amount)-parseFloat(tax)+parseFloat(coupon);
	var total = parseFloat(subtotal)+parseFloat(ship_fee)+parseFloat(tax)-parseFloat(coupon);
	$("#subtotal3").text(subtotal.toFixed(2));
	$("#coupon3").text(parseFloat(coupon).toFixed(2));
	$("#total3").text(total.toFixed(2));
	$("#flat3").text(parseFloat(ship_fee).toFixed(2));
	$("#xship3").val(myarr[0].split("<"));
	$("#xship_fee3").val(myarr[1].split("<"));
  }
  "use strict"
function gvals2(){
	var amount = $("#amount3").val();
	var coupon = $("#coupon").val();
	var tax = $("#tax").val();
	var xx = $("#state").find(":selected").val();
	var myarr = xx.split("*");
	var ship_fee = myarr[2].split("<");
	var subtotal = parseFloat(amount)-parseFloat(tax)+parseFloat(coupon);
	var total = parseFloat(subtotal)+parseFloat(ship_fee)+parseFloat(tax)-parseFloat(coupon);
	$("#subtotal3").text(subtotal.toFixed(2));
	$("#coupon3").text(parseFloat(coupon).toFixed(2));
	$("#total3").text(total.toFixed(2));
	$("#flat3").text(parseFloat(ship_fee).toFixed(2));
	$("#xship3").val(myarr[1].split("<"));
	$("#xship_fee3").val(myarr[2].split("<"));
  }


$(function (){
	$('.menu-sub-dropdown').css('left', '-98px')
})
'use strict';

var QuillEditor = (function() {

	// Variables


	// Methods

	function init($this) {

		// Get placeholder
		var placeholder = $this.data('quill-placeholder');

		// Init editor
		var quill = new Quill($this.get(0), {
			modules: {
				toolbar: [
					['bold',],
					['link', 'blockquote'],
					[{
						'list': 'ordered'
					}, {
						'list': 'bullet'
					}]
				]
			},
			placeholder: placeholder,
			theme: 'snow'
		});
		quill.on('text-change', function() {
			document.getElementById("quill_html").value = quill.root.innerHTML;
		});
		return quill;

	}	
	function init1($this) {

		// Get placeholder
		var placeholder = $this.data('quill-placeholder');

		// Init editor
		var quill = new Quill($this.get(0), {
			modules: {
				toolbar: [
					['bold',],
					['link', 'blockquote'],
					[{
						'list': 'ordered'
					}, {
						'list': 'bullet'
					}]
				]
			},
			placeholder: placeholder,
			theme: 'snow'
		});
		quill.on('text-change', function() {
			document.getElementById("quill_html1").value = quill.root.innerHTML;
		});
		return quill;

	}	
	function init2($this) {

		// Get placeholder
		var placeholder = $this.data('quill-placeholder');

		// Init editor
		var quill = new Quill($this.get(0), {
			modules: {
				toolbar: [
					['bold',],
					['link', 'blockquote'],
					[{
						'list': 'ordered'
					}, {
						'list': 'bullet'
					}]
				]
			},
			placeholder: placeholder,
			theme: 'snow'
		});
		quill.on('text-change', function() {
			document.getElementById("quill_html2").value = quill.root.innerHTML;
		});
		return quill;

	}

	// Events
	var $quill = $('[data-toggle="quill"]');
	var $quill1 = $('[data-toggle="quill1"]');
	var $quill2 = $('[data-toggle="quill2"]');
	if ($quill.length) {
		$quill.each(function() {
			init($(this));
		});
	}
	if ($quill1.length) {
		$quill1.each(function() {
			init1($(this));
		});
	}
	if ($quill2.length) {
		$quill2.each(function() {
			init2($(this));
		});
	}

})();

'use strict';
$(function () {
	$("#customCheckLoginx8").click(function () {
		if ($(this).is(":checked")) {
			$("#dvBank").show();
			$('#acct_no').attr('required', '');   
			$('#routing_number').attr('required', '');   
		} else {
			$("#dvBank").hide();
			$('#acct_no').removeAttr('required', '');   
			$('#routing_number').removeAttr('required', '');  
		}
	});	
	$("#customCheckLoginhh").click(function () {
		if ($(this).is(":checked")) {
			$("#dvStore").show();
			$('#background_color').attr('required', '');   
			$('#text_color').attr('required', '');   
			$('#welcome_title').attr('required', '');   
			$('#welcome_message').attr('required', '');   
		} else {
			$("#dvStore").hide();
			$('#background_color').removeAttr('required', '');   
			$('#text_color').removeAttr('required', '');  
			$('#welcome_title').removeAttr('required', '');  
			$('#welcome_message').removeAttr('required', '');  
		}
	});	
	$("#customCheckLoginhhf").click(function () {
		if ($(this).is(":checked")) {
			$("#dvStoref").show();
			$('#background_colorf').attr('required', '');   
			$('#text_colorf').attr('required', '');   
			$('#welcome_titlef').attr('required', '');   
			$('#welcome_messagef').attr('required', '');   
		} else {
			$("#dvStoref").hide();
			$('#background_colorf').removeAttr('required', '');   
			$('#text_colorf').removeAttr('required', '');  
			$('#welcome_titlef').removeAttr('required', '');  
			$('#welcome_messagef').removeAttr('required', '');  
		}
	}); 	
	$("#customCheckLoginxf8").click(function () {
		if ($(this).is(":checked")) {
			$("#dvdBank").show();
			$('#acct_no').attr('required', '');     
		} else {
			$("#dvdBank").hide();
			$('#acct_no').removeAttr('required', '');    
		}
	});        
	$("#customCheckLoginfx8").click(function () {
		if ($(this).is(":checked")) {
			$("#dvPaypal").show();
			$('#paypal_client_id').attr('required', '');   
			$('#paypal_secret_key').attr('required', '');   
		} else {
			$("#dvPaypal").hide();
			$('#paypal_client_id').removeAttr('required', '');   
			$('#paypal_secret_key').removeAttr('required', '');  
		}
	});       
	$("#customCheckLogingdx8").click(function () {
		if ($(this).is(":checked")) {
			$("#dvStripe").show();
			$('#stripe_public_key').attr('required', '');   
			$('#stripe_secret_key').attr('required', '');   
		} else {
			$("#dvStripe").hide();
			$('#stripe_public_key').removeAttr('required', '');   
			$('#stripe_secret_key').removeAttr('required', '');  
		}
	});
	$("#customCheckLoginhx8").click(function () {
		if ($(this).is(":checked")) {
			$("#dvCoinbase").show(); 
			$('#coinbase_api_key').attr('required', '');   
		} else {
			$("#dvCoinbase").hide();
			$('#coinbase_api_key').removeAttr('required', '');    
		}
	});        
	$("#customCheckLoging66").click(function () {
		if ($(this).is(":checked")) {
			$('#support_email').attr('required', '');   
		} else {
			$('#support_email').removeAttr('required', '');    
		}
	});        
	$("#customCheckLoging55").click(function () {
		if ($(this).is(":checked")) {
			$('#support_phone').attr('required', '');   
		} else {
			$('#support_phone').removeAttr('required', '');    
		}
	});
});

'use strict';
$(document).ready(function(){
	$("#mygInput").on("keyup", function() {
	  var value = $(this).val().toLowerCase();
	  $("#myDIV .col-xl-4").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	  });
	});
  });

'use strict';
var clipboard = new ClipboardJS('.btn');

clipboard.on('success', function(e) {
	navigator.clipboard.writeText(e.text);
		  $(e.trigger)
			  Swal.fire({
				icon: 'success',
				title: 'Link copied to clipboard',
			  })
			  .tooltip('_fixTitle')
			  .tooltip('show')
			  .attr('title', 'Copy to clipboard')
			  .tooltip('_fixTitle')
		  e.clearSelection()
	  });

clipboard.on('error', function(e) {
  console.error('Action:', e.action);
  console.error('Trigger:', e.trigger);
});
'use strict';
var clipboard = new ClipboardJS('.castro-copy');

clipboard.on('success', function(e) {
	navigator.clipboard.writeText(e.text);
		  $(e.trigger)
			  .attr('title', 'Copied!')
			  Swal.fire({
				icon: 'success',
				title: 'Link copied to clipboard',
			  })
			  .tooltip('_fixTitle')
			  .tooltip('show')
			  .attr('title', 'Copy to clipboard')
			  .tooltip('_fixTitle')

		  e.clearSelection()
	  });

clipboard.on('error', function(e) {
  console.error('Action:', e.action);
  console.error('Trigger:', e.trigger);
});

'use strict';
	$("#kt_datatable_example_5").DataTable({
		"language": {
		"lengthMenu": "Show _MENU_",
		},
		"dom":
		"<'row'" +
		"<'col-sm-6 d-flex align-items-center justify-conten-start'B>" +
		"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
		">" +
	
		"<'table-responsive'tr>" +
	
		"<'row'" +
		"<'col-sm-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-start'l>" +
		"<'col-sm-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
		"<'col-sm-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
		">",
   });	
   $("#kt_datatable_example_7").DataTable({
		"language": {
		"lengthMenu": "Show _MENU_",
		},
		"dom":
		"<'row'" +
		"<'col-sm-6 d-flex align-items-center justify-conten-start'B>" +
		"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
		">" +
	
		"<'table-responsive'tr>" +
	
		"<'row'" +
		"<'col-sm-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-start'l>" +
		"<'col-sm-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
		"<'col-sm-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
		">",
   });
   $("#kt_datatable_example_6").DataTable({
	"dom":
	 "<'row'" +
	 "<'col-lg-6 d-flex align-items-center justify-conten-start'f>" +
	 "<'col-lg-6 d-flex align-items-center justify-content-end'l>" +
	 ">" +
   
	 "<'table-responsive'tr>" +
   
	 "<'row'" +
	 "<'col-lg-12 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
	 "<'col-lg-12 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
	 ">",
   
   });
   $('input[name="date"]').daterangepicker();
   $('#vacation_date').daterangepicker();
   $('input[name="due_date"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 1901,
		maxYear: parseInt(moment().format("YYYY"),10)
	});