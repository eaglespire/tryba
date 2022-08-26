let viewBalance = document.querySelector('#viewBalance');
let hideBalance = document.querySelector('#hideBalance');
let accountBalance = document.querySelector('#account_balance');
let hiddenBalance = document.querySelector('#hidden_balance');

const balances = document.querySelectorAll('[data-balance="balance"]');
const hiddenbalances = document.querySelectorAll('[data-hidden="balance"]');

const toogleBalance = ()=>{

    balances.forEach((item,index) => {
        item.classList.toggle('d-none');
        hiddenbalances[index].classList.toggle('d-none');
    });

    hideBalance.classList.toggle('d-none')
    viewBalance.classList.toggle('d-none')

    if(accountBalance.classList.contains("d-none")){
        localStorage.removeItem('view_account_balance', false);
    }else{
        localStorage.setItem('view_account_balance', true);
    }

}

viewBalance.addEventListener('click',toogleBalance);
hideBalance.addEventListener('click',toogleBalance);
let showBalance = localStorage.getItem('view_account_balance');
if(showBalance){
    balances.forEach((item,index) => {
        item.classList.remove('d-none');
        hiddenbalances[index].classList.add('d-none');
    });
    hideBalance.classList.add('d-none')
    viewBalance.classList.remove('d-none')
}else{
    balances.forEach((item,index) => {
        item.classList.add('d-none');
        hiddenbalances[index].classList.remove('d-none');
    });
    hideBalance.classList.remove('d-none')
    viewBalance.classList.add('d-none')
}


function changeSlide(num,to){
    let slide = document.querySelector(`#service_${num}`);
    let destination = document.querySelector(`#service_${to}`);
    if(to > num){
        slide.classList.add('translate-x-full')
        setTimeout(() => {
            slide.classList.toggle('d-none');
            slide.classList.remove('translate-x-full')
            destination.classList.toggle('d-none');
            destination.classList.remove('translate-x-full-postive');
        }, 330);
        

    }else{
        slide.classList.add('translate-x-full-postive')
        setTimeout(() => {
            slide.classList.toggle('d-none');
            slide.classList.remove('translate-x-full-postive')
            destination.classList.toggle('d-none');
            destination.classList.remove('translate-x-full');
        }, 330);
    }


}


function changeTransactionSlide(num,to){
    let slide = document.querySelector(`#trnx_${num}`);
    let destination = document.querySelector(`#trnx_${to}`);
    if(to > num){
        slide.classList.add('translate-x-full')
        setTimeout(() => {
            slide.classList.toggle('d-none');
            slide.classList.remove('translate-x-full')
            destination.classList.toggle('d-none');
            destination.classList.remove('translate-x-full-postive');
        }, 330);
        

    }else{
        slide.classList.add('translate-x-full-postive')
        setTimeout(() => {
            slide.classList.toggle('d-none');
            slide.classList.remove('translate-x-full-postive')
            destination.classList.toggle('d-none');
            destination.classList.remove('translate-x-full');
        }, 330);
    }


}

function copyClipboard(text){
    navigator.clipboard.writeText(text);
}

let switchBtn = document.querySelector('#switchAccount');
let switchOverlay = document.querySelector('#switch-overlay');
let body = document.getElementsByTagName("body")
const showdropDown = () => {

    let switchBtn = document.querySelector('#switchContent');
    switchBtn.classList.toggle('d-none')
    body[0].classList.toggle("overflow-hidden")
    switchOverlay.classList.toggle('d-none')
    
}
switchOverlay.addEventListener('click',showdropDown);
switchBtn.addEventListener('click',showdropDown);


function changeAccount(currency){
    let gpbAccount = document.querySelector('#account-gpb');
    let euroAccount = document.querySelector('#account-euro');
    let accountBtn = document.querySelector("#account-btn")
    if(currency == 'gbp'){
       euroAccount.classList.add('d-none');
       gpbAccount.classList.remove('d-none');
       accountBtn.setAttribute("data-bs-target", "#accountInformation");
    }else{
        euroAccount.classList.remove('d-none');
        gpbAccount.classList.add('d-none');
        accountBtn.setAttribute("data-bs-target", "#accountInformation-euro");
    }
    showdropDown();
}

let cards = document.querySelector("#cards");
let cardOverlay = document.querySelector("#card-overlay");

cards.addEventListener('mouseenter',()=>{
    cardOverlay.classList.remove("d-none")
});

cards.addEventListener('mouseleave',()=>{
    cardOverlay.classList.add("d-none")
});


function addMoney(currency){
    if(currency == "GBP"){
        $('#accountInformation').modal('hide');
    }else{
        $('#accountInformation-euro').modal('hide');   
    }
    let modal = `#addMoney-` + currency 
    $(modal).modal('show');
}

let addMoneyBtn = document.querySelector('#addMoneyBtn');

addMoneyBtn.addEventListener('click',()=>{
    let gpbAccount = document.querySelector('#account-gpb');
    let euroAccount = document.querySelector('#account-euro');
    let currency = (euroAccount.classList.contains('d-none')) ? "GBP" : "EURO"
    let modal = `#addMoney-` + currency 
    $(modal).modal('show');
})

$(function() {
    $('input[name="singleDate"]').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1901,
      maxYear: parseInt(moment().format('YYYY'),10)
    });
});

let sendMoneyBtn = document.querySelector("#sendMoneyBtn");

sendMoneyBtn.addEventListener('click',()=>{
    let euroAccount = document.querySelector('#account-euro');
    let currency = (euroAccount.classList.contains('d-none')) ? "GBP" : "EURO"
    let modal = `#sendMoney-` + currency 
    $(modal).modal('show');
});

function switchSendMoney(tab){
    let sendOptions = document.querySelector('#send-option');
    let beneficiary = document.querySelector('#beneficiary');
    let accounttypeDiv = document.querySelector('#accounttypeDiv');
    let beneficariesDiv = document.querySelector("#beneficariesDiv");
    let inputReceiverDiv = document.querySelector("#inputReceiverDiv");
    let beneficiaryaccountNumber = document.querySelector('#beneficiaryaccountNumber');
    let beneficiaryaccountSortCode = document.querySelector('#beneficiaryaccountSortCode');
    let saveBeneficiary = document.querySelector("#saveBeneficiary");
    let switchBeneficiary = document.querySelector("#switch-beneficiary");
    let switchBeneficiaryType = document.querySelector("#switchBeneficiaryType");
    sendOptions.classList.toggle('d-none');
    beneficiary.classList.toggle('d-none');

    if(tab == 'new'){
        accounttypeDiv.classList.remove('col-6')
        accounttypeDiv.classList.add('col-12');
        beneficariesDiv.classList.add("d-none");
        inputReceiverDiv.classList.remove('d-none');
        beneficiaryaccountNumber.removeAttribute("readonly");
        beneficiaryaccountSortCode.removeAttribute("readonly");
        saveBeneficiary.classList.remove("d-none");
        switchBeneficiary.innerText = "Pay Beneficiary";
        switchBeneficiaryType.value = "new";
    }else{
        accounttypeDiv.classList.remove("col-12");
        accounttypeDiv.classList.add("col-6");
        beneficariesDiv.classList.remove("d-none")
        inputReceiverDiv.classList.add('d-none');
        beneficiaryaccountNumber.setAttribute("readonly","readonly");
        beneficiaryaccountSortCode.setAttribute("readonly","readonly");
        saveBeneficiary.classList.add("d-none");
        switchBeneficiary.innerText = "Pay Someone New";
        switchBeneficiaryType.value = "existing";
    }
}

$('#beneficiaryInput').select2({
    dropdownParent: $('#sendMoney-GBP')
});

let beneficiaryInput = document.querySelector('#beneficiaryInput');

$("#beneficiaryInput").on('select2:select',async (e) => {
    let beneficiaryaccountNumber = document.querySelector('#beneficiaryaccountNumber');
    let beneficiaryaccountSortCode = document.querySelector('#beneficiaryaccountSortCode');
    let amountAccountNumber = document.querySelector('#amountAccountNumber');
    let amountAccountSortCode = document.querySelector('#amountAccountSortCode');
    let reciverName = document.querySelector('#reciverName');

    let url = window.location.origin + '/user/beneficary/' + e.params.data.id;

    try {
        let res = await fetch(url,{
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        let result = await res.json(); 
        console.log(result);
        if (res.ok) {
            reciverName.innerText = result.accountName;
            beneficiaryaccountNumber.value = amountAccountNumber.innerText = result.accountNumber;
            beneficiaryaccountSortCode.value = amountAccountSortCode.innerText = result.sortCode;
            beneficiaryaccountNumber.readonly = beneficiaryaccountSortCode.readonly = true;
        }else{
            beneficiaryaccountNumber.value = beneficiaryaccountSortCode.value = "";
            beneficiaryaccountNumber.readonly = beneficiaryaccountSortCode.readonly = false;
        }
    } catch (error) {
        beneficiaryaccountNumber.value = beneficiaryaccountSortCode.value = "";
        beneficiaryaccountNumber.readonly = beneficiaryaccountSortCode.readonly = false;
        console.log(error)
    }
});

let paymentType = document.querySelector('#paymentType');
let paymentTypeDiv = document.querySelector('#paymentTypeDiv');
let paymentDateDIv = document.querySelector('#paymentDateDIv')
paymentType.addEventListener('change',()=>{
    if (paymentType.value == 'instant') {
        paymentDateDIv.classList.add('d-none');
        paymentTypeDiv.classList.remove('col-6').add('col-12');
    }else{
        paymentDateDIv.classList.remove('d-none');
        paymentTypeDiv.classList.add('col-6').remove('col-12');
    }
});

let errorSendMoney = document.querySelector("#errorSendMoney");
let confirmPayee = document.querySelector('#confirmPayee');

confirmPayee.addEventListener('click',()=>{
    let beneficiary = document.querySelector('#beneficiary');
    let review = document.querySelector('#review');
    let accountype = document.querySelector('#accountype');
    let amountSend = document.querySelector('#amountSend');
    let amountConfirm = document.querySelector("#amountConfirm");
    let amountNumberBlue = document.querySelector("#amountNumberBlue");
    let beneficiaryaccountNumber = document.querySelector('#beneficiaryaccountNumber').value;
    let beneficiaryaccountSortCode = document.querySelector('#beneficiaryaccountSortCode').value;
    let paymentType = document.querySelector('#paymentType');
    let date = document.querySelector('#date');
    let firstName = document.querySelector('#firstName');
    let lastName = document.querySelector('#lastName');
    let switchBeneficiaryType = document.querySelector("#switchBeneficiaryType").value;

    if(!accountype.value){
        errorSendMoney.innerText = "Select an account type";
    }
    else if(!beneficiaryInput.value && switchBeneficiaryType == "existing"){
        errorSendMoney.innerText = "Select Beneficiary";
    }else if(!amountSend.value){
        errorSendMoney.innerText  = "Enter an amount";
    }else if(!paymentType.value){
        errorSendMoney.innerText  = "Select a payment type";
    }else if(!beneficiaryaccountNumber || beneficiaryaccountNumber.length != 8){
        errorSendMoney.innerText  = "Account number must be 8 digits";
    }else if(!beneficiaryaccountSortCode || beneficiaryaccountSortCode.length != 6){
        errorSendMoney.innerText  = "Sort code must be 6 digits";
    }else if(!date.value && paymentType.value == "scheduled"){
        errorSendMoney.innerText  = "Date field is required";
    }else if(!firstName.value && switchBeneficiaryType == "new"){
        errorSendMoney.innerText  = "Firstname field is required";
    }else if(!lastName.value && switchBeneficiaryType == "new"){
        errorSendMoney.innerText  = "Lastname field is required";
    }
    else{
        amountConfirm.value = amountNumberBlue.innerText = amountSend.value 
        review.classList.toggle('d-none');
        beneficiary.classList.toggle('d-none');
    }
});

function goToTab(elem1,elem2){
    let tab1 = document.querySelector(`#${elem1}`);
    let tab2 = document.querySelector(`#${elem2}`);
    tab1.classList.toggle('d-none');
    tab2.classList.toggle('d-none');
}


// let proceedPayment = document.querySelector("#proceedPayment");

// proceedPayment.addEventListener('click',()=>{
//     let modal = `#sendMoney-GBP`;    
//     $(modal).modal('show');
//     $()

// });

let switchBeneficiary = document.querySelector("#switch-beneficiary");

switchBeneficiary.addEventListener('click',()=>{
    let accounttypeDiv = document.querySelector('#accounttypeDiv');
    let beneficariesDiv = document.querySelector("#beneficariesDiv");
    let inputReceiverDiv = document.querySelector("#inputReceiverDiv");
    let beneficiaryaccountNumber = document.querySelector('#beneficiaryaccountNumber');
    let beneficiaryaccountSortCode = document.querySelector('#beneficiaryaccountSortCode');
    let saveBeneficiary = document.querySelector("#saveBeneficiary");
    let switchBeneficiaryType = document.querySelector("#switchBeneficiaryType");
   
    if(beneficariesDiv.classList.contains("d-none")){
        accounttypeDiv.classList.remove("col-12");
        accounttypeDiv.classList.add("col-6");
        beneficariesDiv.classList.remove("d-none")
        inputReceiverDiv.classList.add('d-none');
        beneficiaryaccountNumber.setAttribute("readonly","readonly");
        beneficiaryaccountSortCode.setAttribute("readonly","readonly");
        saveBeneficiary.classList.add("d-none");
        switchBeneficiary.innerText = "Pay Someone New";
        switchBeneficiaryType.value = "existing";
    }else{
        accounttypeDiv.classList.remove('col-6')
        accounttypeDiv.classList.add('col-12');
        beneficariesDiv.classList.add("d-none")
        inputReceiverDiv.classList.remove('d-none');
        beneficiaryaccountNumber.removeAttribute("readonly");
        beneficiaryaccountSortCode.removeAttribute("readonly");
        saveBeneficiary.classList.remove("d-none");
        switchBeneficiary.innerText = "Pay Beneficiary";
        switchBeneficiaryType.value = "new";
    }
});


let requestMoneyBtn = document.querySelector("#request-money-btn");

requestMoneyBtn.addEventListener('click',()=>{
    $('#requestMoney').modal('show');
});

let createReqLink = document.querySelector("#create_request_link");
let share_link_sender = document.querySelector("#share_link_sender");

let error_msg = document.querySelector("#sender_error");
let success_msg = document.querySelector("#sender_success");

createReqLink.addEventListener("submit",async (e)=>{
    e.preventDefault();
    let form = document.querySelector("#create_request_link");
    var formData = new FormData(form);
    let url = window.location.origin + '/user/generate-request-link';

    let data = {
        'first_name': formData.get('sender_first_name'),
        'last_name' : formData.get('sender_last_name'),
        'amount': formData.get('sender_amount')
    }

    try {
        let res = await axios.post(url,data)
        error_msg.innerText = ""
        let sender_generated_link =  document.querySelector("#sender_generated_link");
        let sender_generated_btn =  document.querySelector("#sender_generated_btn");
        let slug = document.querySelector("#slug");
        sender_generated_btn.setAttribute("data-clipboard-text", res.data.data.url);
        sender_generated_link.value = res.data.data.url;
        slug.value = res.data.data.slug
        //Generate QRCODE
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text:  res.data.data.url,
            width: 148,
            height: 148,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
        createReqLink.classList.toggle('d-none');
        share_link_sender.classList.toggle('d-none');
    } catch (error) {
        error_msg.innerText = error.response.data.message;
    }
});


let send_via_checkboxes = document.querySelectorAll('input[name="sender_via"]');
let whatsapp_div = document.querySelector("#whatsapp_div");
let email_div = document.querySelector("#email_div");
let sms_div = document.querySelector("#sms_div");

$('input[name="sender_via"]').on('change', function(e) {
    let array = []
    for (var i = 0; i < send_via_checkboxes.length; i++) {
        if(send_via_checkboxes[i].checked == true){
            array.push(send_via_checkboxes[i].value)
        }
    }

    if (array.includes('whatsapp')) {
        whatsapp_div.classList.remove("d-none")
    }else{
        whatsapp_div.classList.add("d-none")
    }

    if (array.includes('email')) {
        email_div.classList.remove("d-none")
    }else{
        email_div.classList.add("d-none")
    }

    
    if (array.includes('sms')) {
        sms_div.classList.remove("d-none")
    }else{
        sms_div.classList.add("d-none")
    }


});


let send_request_link = document.querySelector("#send_request_link");

let send_link_btn = document.querySelector("#send_link_btn")

send_request_link.addEventListener('submit',async(e)=>{
    e.preventDefault();
    let array = []
    let slug = document.querySelector("#slug");
    let sender_email = document.querySelector('input[name="sender_email"]')
    let sender_phonenumber = document.querySelector('#sender_phonenumber')
    let sender_phone_code = $("#sender_phone_code").find(":selected").val()

    for (var i = 0; i < send_via_checkboxes.length; i++) {
        if(send_via_checkboxes[i].checked == true){
            array.push(send_via_checkboxes[i].value)
        }
    }
    if (array.includes('email') && !sender_email.value) { 
        error_msg.innerText = "Receiver's Email Address is required";
    }else if(array.includes('sms') && !sender_phonenumber.value){
        error_msg.innerText = "Receiver's Phone Number is required";
    }else if(array.includes('sms') && !sender_phone_code){
        error_msg.innerText = "Receiver's Phone Code is required";
    }else{
        let url = window.location.origin + '/user/send-request-link/' + slug.value;
        let data = {
            'email': (sender_email.value && array.includes('email')) ? sender_email.value : null,
            'phone_number': (sender_phonenumber.value && array.includes('sms')) ? sender_phonenumber.value : null,
            'phonecode': sender_phone_code
        }

        error_msg.innerText = "";
        success_msg.innerTex = "";
        send_link_btn.innerText = "Sending ..."

        try {
            let res = await axios.post(url,data);
            send_link_btn.innerText = "Send"
            success_msg.innerText = res.data.message
            
            if(res.data.data.email_status || res.data.data.sms_status){
                resetRequest()
                $('#requestMoney').modal('hide');
            }else if(res.data.data.email_message || res.data.data.sms_message){
                error_msg.innerHTML = `${res.data.data.email_message} <br> ${res.data.data.sms_message}`
            }

        } catch (error) {
            error_msg.innerText = (error.response.status == 400) ? error.response.data.message : "Problem occured try again" 
            send_link_btn.innerText = "Send"
            
        }
    }

});

const resetRequest = () => {
    createReqLink.classList.toggle('d-none');
    share_link_sender.classList.toggle('d-none');
    error_msg.innerText = "";
    success_msg.innerText = "";
}

let generate_another_link = document.querySelector("#generate_another_link");
generate_another_link.addEventListener("click",resetRequest);

let whatsapp_btn_link = document.querySelector("#whatsapp_btn_link");
let sender_whatsapp_number = document.querySelector("#sender_whatsapp_number");
let whatsapp_phone_code = document.querySelector("#whatsapp_phone_code");

sender_whatsapp_number.addEventListener("input", async()=>{
    let phoneNumber = sender_whatsapp_number.value;
    let slug = document.querySelector("#slug");
    if(phoneNumber.length >= 11){
        try {
            let url = window.location.origin + '/user/send-request-link/whatsapp/' + slug.value;
            let data = {
                phonecode: whatsapp_phone_code.value,
                "phone_number" : phoneNumber
            }
            let res = await axios.post(url,data)
            whatsapp_btn_link.setAttribute("href", res.data.data.whatsappLink);
            whatsapp_btn_link.classList.toggle("d-none")
        } catch (error) {
            whatsapp_btn_link.classList.add("d-none")
        }
    }else{
        whatsapp_btn_link.classList.add("d-none")
    }
    
})


function openTransferPopup(currency){
    if(currency == "GBP"){
        $('#accountInformation').modal('hide');
    }else{
        $('#accountInformation-euro').modal('hide');   
    }
    let modal = `#sendMoney-GBP`;
    $(modal).modal('show');
}

let btn_copy_accno_sort_code = document.querySelector("#btn_copy_accno_sort_code");

btn_copy_accno_sort_code.addEventListener("click",()=>{
    let accountNumber = btn_copy_accno_sort_code.getAttribute('data-account');
    let sortCode = btn_copy_accno_sort_code.getAttribute('data-sort');
    let text = `Account Number: ${accountNumber} \nSort Number: ${sortCode}`
    navigator.clipboard.writeText(text);
})