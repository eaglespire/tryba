jQuery(document).ready(function ($) {
    'use strict';
    window.id = 0;
    $('.waf_product_repeater').repeater(
        {
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },
            ready: function (setIndexes) {}
        }
    );
    function randomId() {
        const uint32 = window.crypto.getRandomValues(new Uint32Array(1))[0];
        return Date.now() + uint32.toString(16);
    }
    $("#waf_button_customizer_form").validate({
        ignore: ".ignore",
        rules: {
            wafCallbackUrl: {
                required: true,
                url: true
            },
            wafReturnUrl: {
                required: true,
                url: true
            },
        },
        messages: {
            wafItemTitle: "Please enter the item name",
            wafItemDescription: "Please enter the item description",
            wafCallbackUrl: {
                required: "Please enter the callback URL",
                url: "Please enter a valid callback URL"
            },
            wafReturnUrl: {
                required: "Please enter the return URL",
                url: "Please enter a valid return URL"
            },
        }
    });
    function wafItemOptionList(){
        $('.waf_select_list option').remove();
        $('.waf_select_list').append($('<option>',
            {
                value: "",
                text : "Choose an option"
            }
        ));
        let waf_product_repeater = $('.waf_product_repeater').repeaterVal();
        let currencyText = $('#wafCurrency option:selected').text();
        $.each(waf_product_repeater.variable_item_option, function(index,option){
            if(option.waf_list_price && option.waf_list_option){
                $('.waf_select_list').append($('<option>',
                    {
                        value: option.waf_list_price,
                        text : option.waf_list_option + " - " + option.waf_list_price + " " + currencyText
                    }
                ));
            }
        });
    }
    function checkButtonType(type){
        $('.button_type_group').addClass('hide');
        $('.button_type_group input').addClass('ignore');
        let waf_uuid = $('.waf_vgc_tx_ref').val();
        if(type === "fixed_price"){
            $('.fixed_price_group').removeClass('hide');
            $('.fixed_price_group input').removeClass('ignore');
            $(' .waf_vgc_js_form .waf_variable_label').remove();
            $(' .waf_vgc_js_form .waf_variable_price').remove();
            $(' .waf_vgc_js_form .waf_variable_currency').remove();
            $(' .waf_vgc_js_form .waf_select_list').remove();
        }else if(type === "single_select"){
            $('.single_select_group').removeClass('hide');
            $('.single_select_group input').removeClass('ignore');
            $(' .waf_vgc_js_form .waf_variable_label').remove();
            $(' .waf_vgc_js_form .waf_variable_price').remove();
            $(' .waf_vgc_js_form .waf_variable_currency').remove();
            $(' .waf_vgc_js_form').prepend('<select class="waf_select_list" data-uuid="' + waf_uuid + '" required></select>');
            wafItemOptionList();
        }else{
            $(' .waf_vgc_js_form .waf_select_list').remove();
            $(' .waf_vgc_js_form').prepend('<span name="waf_variable_currency" class="waf_variable_currency"></span>');
            $(' .waf_vgc_js_form').prepend('<input name="waf_variable_price" data-uuid="' + waf_uuid + '" type="number" class="waf_variable_price" required>');
            $(' .waf_vgc_js_form').prepend('<label class="waf_variable_label"></label>');
            $('.waf_variable_currency').text($("#wafCurrency option:selected").text());
            $('.variable_price_group').removeClass('hide');
            $('.variable_price_group input').removeClass('ignore');
        }
    }
    checkButtonType($('#wafButtonType').val());
    $('#wafButtonType').on('change', function (){
        let buttonType = $(this).val();
        $('.waf_list_price')
        checkButtonType(buttonType);
    });
    function bindChangedValue(customizer, element, type = "value", currency = false){
        $(customizer).on('keyup change', function (){
            let value = $(this).val();
            if(type === "value"){
                $(element).val(value);
            }
            if(type === "text"){
                $(element).text(value);
            }
            if(currency === true){
                let currencyText = $(customizer + " option:selected").text();
                $('.waf_variable_currency').text(currencyText);
                wafItemOptionList();
            }
        });
    }
    bindChangedValue('#wafMerchantKey', '.waf_vgc_merchant_key');
    bindChangedValue('#wafButtonText', '.waf_vgc_js_form_btn', "text");
    bindChangedValue('#wafItemTitle', '.waf_vgc_title');
    bindChangedValue('#wafItemDescription', '.waf_vgc_description');
    bindChangedValue('#wafCallbackUrl', '.waf_vgc_callback_url');
    bindChangedValue('#wafReturnUrl', '.waf_vgc_return_url');
    bindChangedValue('#wafCurrency', '.waf_vgc_currency', 'value', true);
    bindChangedValue('#wafItemPrice', '.waf_vgc_amount');
    bindChangedValue('#wafVariableItem', '.waf_variable_label', 'text');
    $('.waf_vgc_js_form_btn').css('background-color', '#ffc43a');
    $('#wafButtonColour').on('change', function (e){
       let color = $(this).val();
       switch (color){
           case "Blue":
               $('.waf_vgc_js_form_btn').css({
                   'background-color': '#0070ba',
                   'border': '',
                   'color': '#ffffff'
               });
               break;
           case "Silver":
               $('.waf_vgc_js_form_btn').css({
                   'background-color': '#eeeeee',
                   'border': '',
                   'color': ''
               });
               break;
           case "White":
               $('.waf_vgc_js_form_btn').css({
                   'background-color': '#ffffff',
                   'border': '#555555 solid 1px',
                   'color': ''
               });
               break;
           case "Black":
               $('.waf_vgc_js_form_btn').css({
                   'background-color': '#2c2e2f',
                   'border': '',
                   'color': '#ffffff'
               });
               break;
           default:
               $('.waf_vgc_js_form_btn').css({
                   'background-color': '#ffc43a',
                   'border': '',
                   'color': ''
               });
               break;
       }
    });
    $.getJSON( "https://tryba.io/api/currency-supported2", function( data ) {
        if(data.currency_code && data.currency_name){
            $.each( data.currency_code, function( key, val ) {
                $('#wafCurrency').append($('<option>',
                    {
                        value: data.currency_code[key],
                        text : data.currency_name[key]
                    }
                ));
            });
        }
    });
    $('#wafButtonShape').on('change', function (e){
        let shape = $(this).val();
        if(shape === "Pill"){
            $('.waf_vgc_js_form_btn').addClass('pill');
            $('.waf_select_list').addClass('pill');
        }else{
            $('.waf_vgc_js_form_btn').removeClass('pill');
            $('.waf_select_list').removeClass('pill');
        }
    });
    new ClipboardJS('#wafCopyButton', {
        text: function() {
            let uuid = randomId();
            let merchant_key = $('#wafMerchantKey').val();
            let button_type = $('#wafButtonType').val();
            let title = $('#wafItemTitle').val();
            let description = $('#wafItemDescription').val();
            let callback_url = $('#wafCallbackUrl').val();
            let return_url = $('#wafReturnUrl').val();
            let shape = $('#wafButtonShape').val();
            let color = $('#wafButtonColour').val();
            let element_id = 'vgc_' + uuid;
            let price_label = null;
            if(button_type === "fixed_price"){
                price_label = $('#wafItemPrice').val();
            }else{
                price_label = $('#wafVariableItem').val();
            }
            return '<!--Tryba Button starts-->\n' +
                '<div class="wafVgcButtonContainer" id="vgc_' + uuid + '"></div>\n' +
                '<script src="https://tryba.io/asset/js/payment.js"></script>\n' +
                '<script>wafInitVgcButton("' + merchant_key + '", "' + button_type + '", "' + title + '", "' + description + '", "' + callback_url + '", "' + return_url + '", "' + shape + '", "' + color + '", "' + element_id + '", "' + price_label + '")</script>\n' +
                '<!--Tryba Button ends-->';
        }
    });

    $('#wafCopyButton').on('click', function (e){
        e.preventDefault();
        if($("#waf_button_customizer_form").valid() === false){
            $('.waf_copy_success_message').addClass('hide');
            return false;
        }else{
            $('.waf_copy_success_message').removeClass('hide');
        }
    });
    $('.waf_product_repeater').on('change keyup', '.waf_list_option, .waf_list_price', function (){
        wafItemOptionList();
    });
    $('#waf_button_customizer_form').on('change', function (e){
        $('.waf_copy_success_message').addClass('hide');
    });
});
