
$(document).ready(function(e) {
    $('.dummy-dd').on('click', function(e) {
       add.off();
    });

    $("#mccModal").modal("show")
    $(".select").select2({ width: '100%', dropdownCssClass: "bigdrop" })
  //   $("#mccModal").modal({show: true, backdrop: 'static'})

    // $("#beneficiaryId").select2()

    let user
    let oldVal = ''
    let oldSortC = ''
    let cid = $("#cid").val()
    let beneficaries = []

    String.prototype.chunk = function(n) {
      var space = [];
      for(var i=0, len=this.length; i < len; i += n) {
          space.push(this.substr(i, n))
        }
        return space
    };

    $.each($(".accNum"), function(index, value) {
        let txt = `${value.innerText}`

      //   console.log(txt.chunk(4).join(' '))
        value.innerHTML = value.innerText.chunk(4).join(' ')
      //   $(".accNum").text(txt.chunk(4).join(''))
    });

    $("#spinner").hide()
    $("#loader").hide()
    $("#companyName").hide()
    $("#companyRegNum").hide()
    $("#errMsg").hide()
    $("#errorMessage").hide()

    const userID = $("#userTarget").data('uid')
    getUser(userID)
    let accessToken = ''

    $("#verifyKyc").on("click", function(e) {
      e.preventDefault()
      // console.log("Click")
      // $("#accountModal").modal({backdrop: 'static'})
      // $("#accountModal").modal('show')
      // $("#spinner").show()
      // $(this).attr('disabled', true)
    })

    $("#submBtn").on("click", function(e) {
      e.stopImmediatePropagation()
      // $("#loader").show()
      // console.log("TEST")
      // $(this).attr('disabled', true)
      // createAccount()
    })


    function createAccount() {
      let accountType = $("#account_type").val()
      let addressLine2 = $("#address_2").val()
      let data = {
        user_id: user.id,
        first_name: user.first_name,
        last_name:  user.last_name,
        dob: $("#dob").val(),
        accountType: $("#account_type").val(),
        country: $("#country").val(),
        postCode: $("#post_code").val(),
        postTown: $("#post_town").val(),
        addressLin1: $("#address_1").val(),
        industryCode: $("#industry_code").val(),
      }
      if(accountType === 'LLC') {
        data['company_regNumber'] = $("#company_reg_number").val()
        data['companyName'] = $("#company_name").val()
      }
      if(addressLine2 !== '') {
        data['addressLin2'] = $("#address_2").val()
      }

      axios.post('/api/banking/save-details', data)
      .then(response => {
      //   console.log("Banking", response)
        if(response.data.status) {
          $("#accountModal").hide()
          getAccessToken()
        }
      })
      .catch(err =>  {
        if(err.response) {
          let message
          if(err.response.status == 422 || err.response.status == 200 || err.response.status == 401 || err.response.status == 404) {
            if(err.response.data.errors) {
                let errors = err.response.data.errors
                let errorList = Object.values(errors)
                errorList.map(msg => {
                    message = msg
                })
            }
            $("#errMsg").html(`<strong>${err.response.data.message || message}</strong>`)
            $("#errMsg").fadeIn('slow')
          }
          else {
            $("#errMsg").fadeOut('slow')
          }
        }
      })
      .finally(() => {
        $("#loader").hide()
        $("#submBtn").attr('disabled', false)
      })
    }

    function getAccessToken() {
      axios.post(`/api/get-accessToken`, {
        user_id: user.id
      })
      .then(response => {
      //   console.log("ACCESS TOKEN", response)
        if(response.data.status && response.data.message === 'success') {
        //   launchWebSdk(response.data.data.token)
          $("#verificationModal").modal('show')
        }
        else {
          $("#verificationModal").modal('hide')
        }
      })
      .catch(err => console.log(err))
      .finally(() => {
        $("#spinner").hide()
        $("#verifyKyc").attr('disabled', false)
      })
    }

    $("#closeModal").on("click", function(e) {
      e.stopImmediatePropagation()
      $("#verificationModal").modal("hide")
      $("#loader").hide()
      $("#spinner").hide()
      window.location.reload()
    })

    $("#closeAccountModal").on("click", function(e) {
      e.stopImmediatePropagation()
      $("#accountModal").modal("hide")
      $("#spinner").hide()
      $("#loader").hide()
    })


    function getNewAccessToken() {
      return Promise.resolve(accessToken)
    }

    function getUser(id) {
      axios.get(`/api/user/${id}`)
      .then(response => {
      //   console.log("USERF", response)
        if(response.data.status) {
          user = response.data.data
          updateAccount(user.id)
        }
      })
    }

    function updateAccount(id) {
      axios.get(`/api/banking/${id}/account`)
      .then(response => {
        if(response.data.status) {
          let balance = new Intl.NumberFormat('en-EN', { style: 'currency', currency: 'GBP' }).format(response.data.data.balance)
          $("#accountBalance").text(balance || '£0.00')
          $("#bankAccountNumber").text(response.data.data.accountNumber+' / '+response.data.data.sortCode || '00000000 / 00-00-00')
        }
      })
    }

    $("#account_type").on("change", function(e) {
      e.stopImmediatePropagation()
      let selected = $(this).val()
      if(selected === 'LLC') {
        $("#companyRegNum").show()
        $("#companyName").show()
      }
      else {
        $("#companyRegNum").hide()
        $("#companyName").hide()
      }
    })

    function getApplicantStatus(applicantId) {
      axios.get(`/api/user/${applicantId}/${user.id}`)
      .then(response => {
      //   console.log("CONFIRMATION", response)
        if(response.data.status) {
          // user = response.data.data
        }
      })
    }

    $("#post_code").on("focus", function(e) {
      e.stopImmediatePropagation()
      // console.log("BLUR")
      var postal = document.getElementById('post_code');
      var town = document.getElementById('post_town');
      var options = { types: ['(regions)'] }
      // console.log("POSTCODE", postal)
      var autocomplete = new google.maps.places.Autocomplete(postal, options);
      var autocomp = new google.maps.places.Autocomplete(town, options);
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
          var location = autocomplete.getPlace();
          geocoder = new google.maps.Geocoder();
          lat = location['geometry']['location'].lat();
          lng = location['geometry']['location'].lng();
          var latlng = new google.maps.LatLng(lat, lng);
          geocoder.geocode({ 'latLng': latlng }, function (results) {
            for(i = 0; i < results.length; i++) {
              for(var j = 0; j < results[i].address_components.length; j++) {
                for (var k = 0; k < results[i].address_components[j].types.length; k++) {
                  if (results[i].address_components[j].types[k] == "postal_code" && results[i].address_components[j].types.length == 1) {
                    zipcode = results[i].address_components[j].long_name;
                    postal.value   = zipcode;
                  }
                }
              }
            }
          });
      });
      // google.maps.event.addListener(autocomp, 'place_changed', function () {
      //     var location = autocomp.getPlace();
      //     geocoder = new google.maps.Geocoder();
      //     lat = location['geometry']['location'].lat();
      //     lng = location['geometry']['location'].lng();
      //     var latlng = new google.maps.LatLng(lat, lng);
      //     geocoder.geocode({ 'latLng': latlng }, function (results) {
      //       for(i = 0; i < results.length; i++) {
      //         for(var j = 0; j < results[i].address_components.length; j++) {
      //           for (var k = 0; k < results[i].address_components[j].types.length; k++) {
      //             if (results[i].address_components[j].types[k] == "postal_code" && results[i].address_components[j].types.length == 1) {
      //               zipcode = results[i].address_components[j].long_name;
      //               town.value = zipcode;
      //             }
      //           }
      //         }
      //       }
      //     });
      // });
      // window.onload = function () {
      // }
    })

    // $("#showCardForm").on("click", function(e) {
    //   e.stopImmediatePropagation()
    //   console.log("show form")
    //   $("#cardModal").modal("show")
    //   $("#cardModal").modal({show: true, backdrop: "static"})
    // })

    $("#sendMoney").on("click", function(e) {
      e.stopImmediatePropagation()
      $(".spinner").hide()
      if(cid !== undefined || cid !== '') {
        fetchBeneficiaries()
      }
      $("#sendMoneyModal").modal("show")
      $("#sendMoneyModal").modal({backdrop: "static", show: true})
    })

    function validateAccountNumber(str) {
      return /^[0-9]{0,8}$/.test(str)
    }

    function validateSortCode(str) {
      return /^[0-9]{0,6}$/.test(str)
    }

    $("#accountNumber").on("input", function(e) {
      e.stopImmediatePropagation()
      let accountNumber = $(this).val()
      if(validateAccountNumber(accountNumber)) {
        oldVal = accountNumber
      }
      else {
        $(this).val(oldVal)
      }
      if(accountNumber.length < 8 || accountNumber.length > 8) {
        $(this).css("border", "1px solid red")
        $(this).parent().find('small').text('Account number must be 8 digits').fadeIn()
      }
      else {
        $(this).css("border", "1px solid green")
        $(this).parent().find('small').text('').fadeOut()
        $("#paymentReference").trigger("focus")
        // $("#sortCode").trigger("focus")
      }
    })

    $("#sortCode").on("input", function(e) {
      e.stopImmediatePropagation()
      let sortCode = $(this).val()
      if(validateSortCode(sortCode)) {
        oldSortC = sortCode
      }
      else {
        $(this).val(oldSortC)
      }
      if(sortCode.length < 6 || sortCode.length > 6) {
        $(this).css("border", "1px solid red")
        $(this).parent().find('small').text('Sort Code must be 6 digits').fadeIn("slow")
      }
      else {
        $(this).css("border", "1px solid green")
        $(this).parent().find('small').text('').fadeOut("slow")
        $("#accountNumber").trigger("focus")
        // $("#beneficiaryName").trigger("focus")
      }
    })

    $("#benBtn").on("click", function(e) {
        e.stopImmediatePropagation()
        $(".spinner").fadeIn()
        let data = {
          accountType: $("#accountType").val(),
          accountNumber: $("#accountNumber").val(),
          sortCode: $("#sortCode").val(),
          phoneNumber: $("#beneficiaryPhoneNumber").val(),
          emailAddress: $("#beneficiaryEmail").val(),
          beneficiaryName: $("#beneficiaryName").val(),
          cid: $("#cid").val(),
          uid: user.id
        }
        let explode = data.sortCode.split('')
        let sortCodeFormatted = explode[0]+explode[1]+'-'+explode[2]+explode[3]+'-'+explode[4]+explode[5]

        if(data.beneficiaryName === '') {
          $("#errorMessage").html('<strong>Please enter the beneficiary name</strong>')
          $("#errorMessage").fadeIn()
        }
        else {

          $("#errorMessage").html('')
          $("#errorMessage").fadeOut()
          // createBeneficiary(data)
          // $(".spinner").fadeIn()
        //   accountNameCheck(data)
        //   return
          axios.post(`/api/banking/beneficiary/verify-payee-account`, {
            userId: user.id,
            accountNumber: data.accountNumber,
            accountType: data.accountType,
            name: data.beneficiaryName,
            sortCode: '000000',
            paymentAccountId: $("#accountId").val(),
          })
          .then(response => {
            //   console.log("Verification res", response)
              //   <td colspan="2" class="text-centers">
              //       <p>
              //           <strong class="text-danger">CLOSELY MATCHED</strong><br>
              //           <strong>Name doest not match the account details. Please be certain before proceeding.</strong>
              //       </p>
              //   </td>
              if(response.data.status) {
                let payName = response.data.data.code === 'MATCHED' ? data.beneficiaryName : 'No Matching account found'
                let html =
                `<div class="text-center">
                  <table class="tables">
                      <tr class="text-centers">
                          <td colspan="2" class="text-centers">
                              <p>
                                  <strong class="text-success">Account Name is a MATCH</strong><br>
                              </p>
                          </td>
                      </tr>
                      <tr>
                          <td>Name:</td>
                          <td>${payName}</td>
                      </tr>
                      <tr>
                        <td>Account Number:</td>
                        <td>${data.accountNumber}</td>
                        </tr>
                        <tr>
                        <td>Sort Code:</td>
                        <td>${sortCodeFormatted}</td>
                      </tr>
                      </table>
                    </div>
                `
                $(".confirmPayee").attr("id", "confirmPayee")
                $("#confirmationTable").html(html);
                $("#confirmationModalCenterTitle").text("Payee Confirmation")
                $("#sendMoneyModal").modal("hide")
                $("#confirmationModal").modal("show")

                $("#confirmPayee"). on("click", function(e) {
                e.stopImmediatePropagation()
                $(".spinner").fadeIn()
                    axios.post('/api/banking/beneficiary/otp', {
                    userId: user.id,
                    type: "send"
                    })
                    .then(response => {
                    if(response.data.status) {
                        $("#confirmationModal").modal("hide")
                        Swal.fire({
                        title: 'OTP verification',
                        html: `<p class="text-primary">A verification email has been sent to ${user.email}, enter the code in the box below</p>`,
                        input: 'text',
                        inputPlaceholder: 'OTP Code',
                        showCancelButton: true,
                        confirmButtonText: 'Verify',
                        showLoaderOnConfirm: true,
                        inputValidator: (value) => {
                            if (!value) {
                            return 'Enter the OTP code'
                            }
                        },
                        preConfirm: ((value) => {
                            // console.log("preconfirm")
                            return axios.post('/api/banking/beneficiary/otp', {
                            type: 'verification',
                            otp: value,
                            userId: user.id,
                            })
                            .then(response => {
                            if(response.data.status) {
                                createBeneficiary(data)
                            }
                            })
                            .catch(err => {
                            if(err.response) {
                                let message
                                if(err.response.status == 422) {
                                if(err.response.data.errors) {
                                    let errors = err.response.data.errors
                                    let errorList = Object.values(errors)
                                    errorList.map(msg => {
                                    message = msg
                                    })
                                }
                                Swal.fire({
                                    title: 'Error',
                                    icon: 'error',
                                    text: err.response.data.message || message,
                                    confirmButtonText: 'OK'
                                })
                                .then(() => {
                                    $("#sendMoneyModal").modal("show")
                                    $("#sendMoneyModal").modal({backdrop: "static", show: true})
                                })

                                }
                            }
                            })
                        })
                        })
                        .then(result => {
                        // console.log("REs ", result)
                        if(result.isConfirmed) {

                        }
                        else {
                            $("#sendMoneyModal").modal("show")
                            $("#sendMoneyModal").modal({backdrop: "static", show: true})
                        }
                        })
                    }
                    })
                    .catch(err => console.log("ERR", err))
                    .finally(() => $(".spinner").fadeOut())
                })
              }
              else {
                  Swal.fire({
                      icon: 'error',
                      text: 'No matching account details found'
                  })
              }
            })
         .catch(err => console.log(err.response.data))
         .finally(() => $(".spinner").fadeOut())
        }
    })


    $("#closeConfirm").on("click", function (e) {
      e.stopImmediatePropagation()
      $("#confirmationModal").modal("hide")
      $("#sendMoneyModal").modal("show")
    })


    $("#verifyOtp").on("click", function(e) {
      e.stopImmediatePropagation()
      let data = {
        accountNumber: $("#accountNumber").val(),
        sortCode: $("#sortCode").val(),
        phoneNumber: $("#beneficiaryPhoneNumber").val(),
        emailAddress: $("#beneficiaryEmail").val(),
        beneficiaryName: $("#beneficiaryName").val(),
        cid: $("#cid").val(),
        uid: user.id
      }
      verifyOtp(data)
    })

    function createBeneficiary(data) {
      $(".spinner").fadeIn()
      axios.post('/api/banking/beneficiary/create', data)
      .then(response => {
        if(response.data.status) {
          // console.log("DATA==>", response.data.data)
          let data = response.data.data
          beneficaries.push(response.data.data)
          let html = ''
          $("#payeeAccountNumber").val(data.destinationIdentifier.accountNumber)
          $("#payeeSortCode").val(data.destinationIdentifier.sortCode)
          $("#payeeName").val(data.name)
          html = `<option value="${data.id}" selected>${data.name}</option>`
          $("#beneficiaryId").append(html)
          $("#sendMoneyModal").modal("show")
          $("#sendMoneyModal").modal({backdrop: "static", show: true})
          $("#addBtn").trigger("click")
          Swal.fire({
            title: 'success',
            icon: 'success',
            text: response.data.message,
            confirmButtonText: 'OK'
          })
          .then(() => {
              window.location.reload()
            $("#sortCode").val('')
            $("#beneficiaryPhoneNumber").val('')
            $("#beneficiaryEmail").val('')
            $("#beneficiaryName").val('')
          })
        }
      })
      .catch(err =>  {
        if(err.response) {
          let message
          if(err.response.status == 422 || err.response.status == 200 || err.response.status == 401 || err.response.status == 404) {
            if(err.response.data.errors) {
              let errors = err.response.data.errors
              let errorList = Object.values(errors)
              errorList.map(msg => {
                message = msg
              })
            }
            Swal.fire({
              title: 'Error',
              icon: 'error',
              text: `${err.response.data.message || message}`,
              confirmButtonText: 'OK'
            })
            .then(() => {
              $("#sendMoneyModal").modal("show")
              $("#sendMoneyModal").modal({backdrop: "static", show: true})
            })
          }
        }
      })
      .finally(() => $(".spinner").fadeOut())
    }

    function fetchBeneficiaries() {
      $("#beneficiaryId").parent().find('small').show()
      axios.get(`/api/banking/beneficiary/get-list/${cid}/${user.id}`)
      .then(response => {
        if(response.data.status) {
          let data = response.data.data
          beneficaries = response.data.data
            // console.log(beneficaries)
          // beneficaries = response.data.data.map(benf => {
          //   return {
          //     text: benf.name,
          //     data: benf.id
          //   }
          // })
          // $("#beneficiaryId").select2({
          //   data: beneficaries,
          // })
          let html = ''
          $.each(data, function(index, value) {
            html = `<option value="${value.id}">${value.name}</option>`
            $("#beneficiaryId").append(html)
          });
        }
      })
      .finally(() => $("#beneficiaryId").parent().find('small').hide())
    }

    $(".addBtn").on("click", function(e) {
      e.stopImmediatePropagation()
      let selected = $(this).data('operation')
      if(selected === 'existing') {
        $("#sendMoneyModalCenterTitle").text("Pay Existing Payee")
        $(".payment-selection").slideUp()
        $("#beneficiaryForm").slideUp()
        $("#paymentForm").slideDown()
      }
      else if(selected === 'new_payee') {
        $("#sendMoneyModalCenterTitle").text("Pay Someone New")
        $(".payment-selection").slideUp()
        $("#paymentForm").slideUp()
        $("#beneficiaryForm").slideDown()
      }
      else {
          $("#paymentForm").slideUp()
          $("#beneficiaryForm").slideUp()
          $(".payment-selection").slideDown()
      }
    })

    $("#beneficiaryId").on("change", function(e) {
      e.stopImmediatePropagation()
      let selected = $(this).val()
      let payee = beneficaries.filter(paye => paye.id === selected)
      $("#payeeAccountNumber").val(payee[0].destinationIdentifier.accountNumber)
      $("#payeeSortCode").val(payee[0].destinationIdentifier.sortCode)
      $("#payeeName").val(payee[0].name)
    })



    $("#paymentBtn").on("click", function(e) {
      e.stopImmediatePropagation()
      $("#confirmationModal").modal("hide")
      const data = {
        beneficiaryId: $("#beneficiaryId").val(),
        amount: $("#amount").val(),
        payeeAccountNumber: $("#payeeAccountNumber").val(),
        payeeSortCode: $("#payeeSortCode").val(),
        payeeName: $("#payeeName").val(),
        sourceAccountId: $("#accountId").val(),
        payment_type:    $("#payment_type option:selected").val(),
        account_type:    $("#account_type").val(),
        payment_date:    $("#payment_date").val(),
        user_id: user.id,
      }
      // console.log("data", data)
      if(data.payment_type === '' || data.amount === '' || data.payeeSortCode === '' || data.payeeAccountNumber === '' || data.payeeName === '') {
        Swal.fire({
          title: 'Error',
          icon: 'error',
          text: 'Fill the form correctly'
        })
        return
      }

      if(data.payment_type === 'standing_order' && data.payment_date == '') {
          Swal.fire({
              title: 'Error',
              icon: 'error',
              text: 'Please chose a payment date'
          })
          return
      }

      if(data.payment_type !== 'standing_order') {
          data.payment_date = ''
      }

      let explode = data.payeeSortCode.split('')
      let sortCodeFormatted = explode[0]+explode[1]+'-'+explode[2]+explode[3]+'-'+explode[4]+explode[5]
    //   let html =
    //   `<div class="text-center">
    //       <table class="tables">
    //       <tr>
    //         <td colspan="2" class="text-centers">
    //             <div class="text-center mb-2"><i class="fas fa-exclamation-triangle fa-2x text-warning"></i></div>
    //             <h3 class="text-info text-center">UNABLE TO CHECK ACCOUNT NAME</h3>
    //             <p class="text-center"> We can't check the account name right now. Please try again later.</p>
    //             <p class="text-center mt-2">Only continue if you're sure the request is trustworthy and you have the correct details.
    //             </p>
    //         </td>
    //       </tr>
    //       <tr>
    //         <td colspan="2" class="text-center">
    //             <strong>You entered</strong> <br/>
    //             Peter Andrew <br/>
    //             00-99-00<br/>
    //             43093849<br/>
    //             <br/>
    //         </td>
    //       </tr>
    //       <tr>
    //         <td colspan="2">
    //             <button type="button" class="btn btn-primary form-control mt-3">Go back</button>
    //         </td>
    //       </tr>
    //       <tr>
    //         <td colspan="2">
    //             <button type="button" class="btn btn-outline-primary form-control mt-3">Continue with what I entered</button>
    //         </td>
    //       </tr>
    //       </table>
    //     </div>
    //   `

    //   let html =
    //   `<div class="text-center">
    //       <table class="tables">
    //       <tr>
    //         <td colspan="2" class="text-centers">
    //             <div class="text-center"><i class="fas fa-exclamation-triangle fa-2x text-danger"></i></div>
    //             Making this payment may lead to money being sent to the wrong account which may not be recoverable.
    //         </td>
    //       </tr>
    //       <tr>
    //         <td colspan="2" class="text-center">
    //             <strong>You entered</strong> <br/>
    //             Peter Andrew <br/><br/>
    //         </td>
    //       </tr>
    //       <tr>
    //         <td colspan="2">
    //             <button type="button" class="btn btn-primary form-control">Go back and edit</button>
    //         </td>
    //       </tr>
    //       <tr>
    //         <td colspan="2">
    //             <button type="button" class="btn btn-outline-primary form-control">Continue with what i entered</button>
    //         </td>
    //       </tr>
    //       </table>
    //     </div>
    //   `

      let html =
      `<div class="text-center">
          <table class="tables">
          <tr>
            <td>First name:</td>
            <td>${data.payeeName}</td>
          </tr>
          <tr>
            <td>Last name:</td>
            <td>${data.payeeName}</td>
          </tr>
          <tr>
          </tr>
            <td colspan="2" class="text-center">
             <div class="bg-success alert w-100" style="color: #fff; padding: 8px;">
                <i class="fas fa-check-circle text-white"></i> Account name is a match
             </div>
            </td>
          <tr>
            <td>Sort Code:</td>
            <td>${sortCodeFormatted}</td>
          </tr>
          <tr>
            <td>Account Number:</td>
            <td>${data.payeeAccountNumber}</td>
          </tr>
          <tr>
            <td>Payment reference:</td>
            <td>Book purchase</td>
          </tr>
          <tr>
            <td>Amount:</td>
            <td>£${data.amount}</td>
          </tr>
          </table>
        </div>
      `
      if(data.payment_type === 'standing_order') {
          html =
          `<div class="text-center">
              <table class="tables">
              <tr>
                <td>Name:</td>
                <td>${data.payeeName}</td>
              </tr>
              <tr>
                <td>Account Number:</td>
                <td>${data.payeeAccountNumber}</td>
              </tr>
              <tr>
                <td>Sort Code:</td>
                <td>${sortCodeFormatted}</td>
              </tr>
              <tr>
                <td>Amount:</td>
                <td>£${data.amount}</td>
              </tr>
              <tr>
                <td>Payment Date:</td>
                <td>${data.payment_date}</td>
              </tr>
              </table>
            </div>
          `
      }

      $(".confirmPayee").attr("id", "confirmPayment")
      $("#confirmationTable").html(html);
      $("#confirmationModalCenterTitle").text("Payment summary")
      $("#sendMoneyModal").modal("hide")
      $("#confirmationModal").modal("show")

      $("#confirmPayment").on("click", function(e) {
        e.stopImmediatePropagation()
        $("#confirmationModal").modal("hide")
        Swal.fire({
          title: 'Password Verification',
          html: `<p class="text-primary">Enter your Tryba account password </p>`,
          input: 'password',
          inputPlaceholder: 'Password',
          showCancelButton: true,
          confirmButtonText: 'Proceed',
          showLoaderOnConfirm: true,
          inputValidator: (value) => {
            if (!value) {
              return 'Enter a password'
            }
          },
          preConfirm: ((value) => {
            return axios.post('/api/banking/beneficiary/verify-password', {
              password: value,
              userId: user.id,
            })
            .then(response => {
              if(response.data.status) {
                  let payload = {
                      beneficiaryId: $("#beneficiaryId").val(),
                      amount: $("#amount").val(),
                      payeeAccountNumber: $("#payeeAccountNumber").val(),
                      payeeSortCode: $("#payeeSortCode").val(),
                      payeeName: $("#payeeName").val(),
                      sourceAccountId: $("#accountId").val(),
                      payment_type:    $("#payment_type option:selected").val(),
                      account_type:    $("#account_type").val(),
                      payment_date:    $("#payment_date").val(),
                      user_id: user.id
                  }
                //   console.log(payload)
                axios.post('/api/banking/payment/create', payload)
                .then(response => {
                  if(response.data.status) {
                    Swal.fire({
                        title: 'Success',
                        text: response.data.message,
                        html: `<div class="text-center"><strong>£${payload.amount}</strong></div>`,
                        icon: 'success',
                    })
                    payload = {}
                    $("#sendMoneyModal").modal("hide")
                    $("#confirmationModal").modal("hide")
                    $("#amount").val('')
                    $("#payeeAccountNumber").val('')
                    $("#payeeSortCode").val('')
                    $("#payeeName").val('')
                    $("#payment_date").val('')
                    window.location.reload()
                  }
                })
                .catch(err => {
                    console.log(err.response.data)
                  if(err.response) {
                    let message
                    if(err.response.status == 422) {
                      if(err.response.data.errors) {
                        let errors = err.response.data.errors
                        console.log("errors", errors)
                        let errorList = Object.values(errors)
                        errorList.map(msg => {
                          message = msg
                        })
                      }
                      Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: err.response.data.message || message,
                        confirmButtonText: 'OK'
                      })
                      .then(() => {
                        $("#sendMoneyModal").modal("hide")
                        $("#confirmationModal").modal("hide")
                        $("#amount").val('')
                        $("#payeeAccountNumber").val('')
                        $("#beneficiaryId").prop('selectedIndex',0);
                        $("#payeeSortCode").val('')
                        $("#payeeName").val('')
                        $("#payment_date").val('')
                        $("#sendMoneyModal").modal({backdrop: "static", show: true})
                      })
                    }
                  }
                })
                .finally(() => $(".spinner").fadeOut())
              }
            })
            .catch(err => {
              if(err.response) {
                let message
                if(err.response.status == 422) {
                  if(err.response.data.errors) {
                    let errors = err.response.data.errors
                    let errorList = Object.values(errors)
                    errorList.map(msg => {
                      message = msg
                    })
                  }
                  Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: err.response.data.message || message,
                    confirmButtonText: 'OK'
                  })
                  .then(() => {
                    $("#sendMoneyModal").modal("show")
                  })

                }
              }
            })
          })
        })
      })
    })


    $(".toggleAccountView").on("click", function(e) {
      e.stopImmediatePropagation()
      let account = $(this).data('account')
      let target = $(this).parent().find("h5")
      let account_text = target.text()
      account === account_text ? target.html('**********') : target.html(account)
      $(this).find('i').toggleClass('fa-eye').toggleClass('fa-eye-slash')
    })

    $(".cardItem").on("click", function(e) {
      e.stopImmediatePropagation()
      let type =  $(this).data('type')
      let title
      let cardId = $(this).data('cid')
      // alert(cardId)

      $("."+type).show()
       if(type === 'details') {
        $(".block").hide()
        $(".freeze").hide()
        title = 'Details'
        $(".details").find("button").attr("data-cid", cardId)
       }
       else if(type === 'block') {
        $(".freeze").hide()
        $(".details").hide()
        title = 'Block Card'
        $(this).attr("data-cid", cardId)
       }
       else if(type === 'freeze' || type === 'unfreeze') {
        $(".block").hide()
        $(".details").hide()
        title = type //'Freeze'
        $(".freeze").find("button").attr("data-cid", cardId)
       }
      $("#modalTitle").html(title)
      $("#cardManager").modal("show")
    })

    $(".card-front").on("click", function(e) {
      e.stopImmediatePropagation()
      $(this).parent().find('div').slideToggle()
      $(this).fadeOut()
    })

    $(".card-back").on("click", function(e) {
      e.stopImmediatePropagation()
      $(this).parent().find('div').slideToggle()
      // $(this).parent().find('div').slideToggle()
      $(this).fadeOut()
    })

    // / *** Card management *** /
    var loading = false
    // create physical card
    function createPhysicalCard() {
      // console.log("Sending")
      loading = true
      const data = {
        user_id: user.id,
        account_id: $("#accountId").val(),
        // first_name: user.first_name,
        // last_name: user.last_name,
        // email: user.email,
        // phone: user.phone,
      }
      axios.post('/api/banking/cards/physical-card', data)
      .then(response => {
        if(response.data.status) {
          Swal.fire({
            icon: 'success',
            text: response.data.message,
            showCancelButton: true
          })
        }
      })
      .catch(err => {
      //   console.log("card error => V", err.response.data)
      })
      .finally(() => loading = false)
    }

    // create virtual card
    function createVirtualCard() {
      $("#loaderMsg").text('Sending request....')
      const data = {
        user_id: user.id
      }
      axios.post('/api/banking/cards/virtual', data)
      .then(response => {
        if(response.data.status) {
          Swal.fire({
            icon: 'success',
            text: response.data.message,
            showCancelButton: true
          })
          .then(r => {
            window.location.reload()
          })
        }
      })
      .catch(err => {
      //   console.log("card error => V", err.response.data)
        if(err.response.data && err.response.data.status == 422) {
          Swal.fire({
            icon: 'error',
            text: err.response.data.message,
            showCancelButton: true
          })
        }
      })
      .finally(() => {
        $("#loaderMsg").text('Request Card')
      })

    }

    // block/unblock card
    function blockOrUnblock(cardId, action) {
      axios.get(`/api/banking/cards/block-unblock/${cardId}/${action}`)
      .then(response => {
      //   console.log("block response", response)
        if(response.data.status) {
          Swal.fire({
            icon: 'success',
            text: response.data.message,
          })
          window.location.reload()
          $("#cardManager").modal('hide')
        }
      })
      .catch(err => {
        if(err.response) {
          let message
          if(err.response.status == 422) {
            if(err.response.data.errors) {
              let errors = err.response.data.errors
              let errorList = Object.values(errors)
              errorList.map(msg => {
                message = msg
              })
            }
            Swal.fire({
              title: 'Error',
              icon: 'error',
              text: err.response.data.message || message,
              confirmButtonText: 'OK'
            })
            .then(() => {
              $("#cardManager").modal('show')
            })
          }
        }
      })
    }

    // get card details
    function getCardDetails(card_id) {
      axios.get(`/api/banking/cards/${card_id}`)
      .then(response => {
        //   console.log(response)
        if(response.data.status) {
          let details = response.data.data
          //   <p><strong>CVV:</strong> ${cvv}</p>
        //   <p><strong>PAN:</strong> ${maskedPan} </p>
          let html = `
          <p><strong>PIN:</strong> ${details.pin.pin}</p>
          <p><strong>Currency:</strong> ${details.currency}</p>
          <p><strong>Status:</strong> ${details.status}</p>
          <p><strong>Type:</strong> ${details.cardScheme}</p>
          <p><strong>Scheme:</strong> ${details.cardType}</p>
          `
          $('.card-details').html(html)
        }
      })
      .catch(err => {
        if(err.response) {
          let message
          if(err.response.status == 422) {
            if(err.response.data.errors) {
              let errors = err.response.data.errors
              let errorList = Object.values(errors)
              errorList.map(msg => {
                message = msg
              })
            }
            Swal.fire({
              title: 'Error',
              icon: 'error',
              text: err.response.data.message || message,
              confirmButtonText: 'OK'
            })
            .then(() => {
              $("#cardManager").modal('show')
            })
          }
        }
      })
    }

    // Get key
    function getKey(card_id) {
      axios.get(`/api/banking/settings/get-key/${card_id}`)
      .then(res => {
      //   console.log("KEY", res)
        if(res.data.token) {
          getCardSDetails(res.data.token, card_id)
        }
        else {
            Swal.fire({
                icons: 'error',
              text: 'Could not generate token'
            })
        }
      })
    }

    // get card details
    function getCardSDetails(key, card_id) {
      axios.get(`https://api-sandbox.modulrfinance.com/api-sandbox-token/cards/${card_id}/secure-details-token`, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer '+key,
        }
      })
      .then(response => {
      //   console.log("c response", response)
        if(response.data.status == 200) {
            let details = response.data.data
            getCardDetails(card_id, details.pan, details.cvv2)
          // Swal.fire({
          //   icon: 'success',
          //   text: response.data.message,
          //   showCancelButton: true
          // })
        }
      })
      .catch(err => {
        if(err.response) {
          let message
          if(err.response.status) {
            if(err.response.data.errors) {
              let errors = err.response.data.errors
              let errorList = Object.values(errors)
              errorList.map(msg => {
                message = msg
              })
            }
            Swal.fire({
              title: 'Error',
              icon: 'error',
              text: err.response.data.message || message,
              confirmButtonText: 'OK'
            })
            .then(() => {
              $("#cardManager").modal('show')
            })
          }
        }
      })
    }

    // activate
    function activate(cid) {
      $(".spinner").show()
      let card_id =  $("#card_id").val()
      axios.get(`/api/banking/cards/${cid}/activate`)
      .then(response => {
        if(response.data.status) {
          Swal.fire({
            icon: 'success',
            text: response.data.message,
          })
          .then(() => window.location.reload())
        }
      })
      .catch(err => {
        console.log("card error => V", err.response.data)
      })
      .finally(() => $(".spinner").hide())
    }

    $("#createCard").on("click", function(e) {
      e.stopImmediatePropagation()
      $(this).text("Please wait....")
      createPhysicalCard()
    })

    function copy(selector){
      var $temp = $("<div>");
      $("body").append($temp);
      $temp.attr("contenteditable", true)
           .html($(selector).html()).select()
           .on("focus", function() { document.execCommand('selectAll',false,null); })
           .focus();
      document.execCommand("copy");
      $temp.remove();
    }

    $("#startOpenbanking").on("click", function(e) {
      e.stopImmediatePropagation()
      $(".open-banking").fadeIn("slow")
    })

    $(".getCard").on("click", function(e) {
      e.stopImmediatePropagation()
      $("#card_type").val($(this).data('type'))
      $("#cardModal").modal("show")
    //   createVirtualCard()
    })

    $("#addMoney").on("click", function() {
      $("#addMoneyModal").modal("show")
      // getInstitutions()
    })

    $("#generateInvoice").on("click", function() {
      $("#addMoneyModal").modal("show")
      // getInstitutions()
    })

      // get institutions
    function getInstitutions() {
      const data = {
        user_id: user.id
      }
      axios.get('/api/banking/get-institutions/list')
      .then(response => {
        if(response.data.status) {
          let institutions = response.data.data
          let html = ''
          $.each(data, function(index, value) {
            html = `<div>${value.name}</div>`
            $("#institutions").append(html)
          });
        }
      })
      .catch(err => {
      //   console.log("card error => V", err.response.data)
        if(err.response.data && err.response.data.status == 422) {
          Swal.fire({
            icon: 'error',
            text: err.response.data.message,
            showCancelButton: true
          })
        }
      })
      .finally(() => {
        loading = false
      })

    }

    $(".freezeCard").on("click", function(e) {
      let cardId = $(this).data('cid');
      let action = $(this).data('action')
      let text;
      let title;
      if(action === 'unfreeze') {
          text = 'This will activate your virtual card'
          title = 'Activate Card'
      }
      else if(action === 'freeze') {
        text = 'Your debit card use will be suspended'
        title = 'Freeze Card'
      }
      else {
        text = 'Your debit card will be Blocked'
        title = 'Block Card'
      }
      e.stopImmediatePropagation()
      Swal.fire({
        icon: 'warning',
        title: title,
        text: text,
        input: 'password',
        inputPlaceholder: 'Enter account password',
        showLoaderOnConfirm: true,
        showCancelButton: true,
        confirmButtonText: 'Yes, Proceed',
        preConfirm: ((value) => {
          return axios.post('/api/banking/beneficiary/verify-password', {
            password: value,
            userId: user.id,
          })
          .then(response => {
              if(response.data.status) {
                  blockOrUnblock(cardId, action)
              }
          })
          .catch(err => {
            if(err.response) {
              let message
              if(err.response.status == 422) {
                if(err.response.data.errors) {
                  let errors = err.response.data.errors
                  let errorList = Object.values(errors)
                  errorList.map(msg => {
                    message = msg
                  })
                }
                Swal.fire({
                  title: 'Error',
                  icon: 'error',
                  text: err.response.data.message || message,
                  confirmButtonText: 'OK'
                })
                .then(() => {
                  $("#cardManager").modal("show")
                })
              }
            }
          })
          .finally(() => $(".passcode").val(''))
        })
      })
    })

    $(".blockCard").on("click", function(e) {
      let cardId = $(this).data('cid');
      e.stopImmediatePropagation()
      Swal.fire({
        icon: 'warning',
        text: 'Your debit card will be block. Do you wish to continue?',
        showLoaderOnConfirm: true,
        showCancelButton: true,
        confirmButtonText: 'Yes, Proceed',
        preConfirm: ((value) => {
          return axios.post('/api/banking/beneficiary/verify-password', {
            password: $(".passcode").val(),
            userId: user.id,
          })
          .then(response => {
              // console.log("R2", response)
            if(response.data.status) {
              blockOrUnblock(cardId, 'block')
            }
          })
          .catch(err => {
            if(err.response) {
              let message
              if(err.response.status == 422) {
                if(err.response.data.errors) {
                  let errors = err.response.data.errors
                  let errorList = Object.values(errors)
                  errorList.map(msg => {
                    message = msg
                  })
                }
                Swal.fire({
                  title: 'Error',
                  icon: 'error',
                  text: err.response.data.message || message,
                  confirmButtonText: 'OK'
                })
                .then(() => {
                  $("#cardManager").modal("show")
                })
              }
            }
          })
          .finally(() => $(".passcode").val(''))
        })
      })
    })

    $(".viewCardDetails").on("click", function(e) {
      e.stopImmediatePropagation()
      let cardId = $(this).data('cid');
      getKey(cardId)
      Swal.fire({
        icon: 'warning',
        text: 'Please confirm your action',
        showLoaderOnConfirm: true,
        showCancelButton: true,
        confirmButtonText: 'Yes, Proceed',
        preConfirm: ((value) => {
          return axios.post('/api/banking/beneficiary/verify-password', {
            password: $(".dpasscode").val(),
            userId: user.id,
          })
          .then(response => {
            if(response.data.status) {
            //   getKey(cardId)
                getCardDetails(cardId)
            }
          })
          .catch(err => {
            if(err.response) {
              let message
              if(err.response.status == 422) {
                if(err.response.data.errors) {
                  let errors = err.response.data.errors
                  let errorList = Object.values(errors)
                  errorList.map(msg => {
                    message = msg
                  })
                }
                Swal.fire({
                  title: 'Error',
                  icon: 'error',
                  text: err.response.data.message || message,
                  confirmButtonText: 'OK'
                })
                .then(() => {
                  $("#cardManager").modal("show")
                })
              }
            }
          })
          .finally(() => $(".passcode").val(''))
        })
      })
    })

    $('#activateCard').on("click", function(e) {
      e.stopImmediatePropagation()
      let cid = $(this).data('cid')
      console.log('cid', cid)
      activate(cid)
    })

    $('#payment_type').on("change", function(e) {
      e.stopImmediatePropagation()
      let type = $(this).val()
      if(type === 'standing_order') {
          let d = new Date()
          let tm = new Date()
          tm.setDate(d.getDate() + 1)
          $("#standingOrder").show()
          $("#standingOrder").find('input').attr("min", tm.toISOString().split("T")[0])
          $("#standingOrder").find('input').attr("required", true)
      }
      else {
          // $("#standingOrder").find('input').val('')
          $("#standingOrder").hide()
      }
    })

    $("#kba_question").on("change", function(e) {
        e.stopImmediatePropagation()
        $("#kba_answer").focus()
    })

    $("#startVerif").on("click", function(e) {
        e.stopImmediatePropagation()
        $(".spinnerz").show()
        const formdata = Object.fromEntries(new FormData($("#verifForm").get(0)).entries());
        // console.log(formdata)

        axios.post('/api/compliance-verification/verification', formdata, {
            headers: {
                'Conten-Type': 'application/json'
            }
        })
        .then(response => {
            if(response.data.status && response.data.token != null) {
                // console.log("user", user)
                // console.log(user.first_name)
                launchWebSdk(response.data.token, user.email, user.phone)
                $("#verifForm").hide()
            }
        })
        .catch(err =>  {
            if(err.response) {
              let message
              if(err.response.status == 422 || err.response.status == 200 || err.response.status == 401 || err.response.status == 404) {
                if(err.response.data.errors) {
                    let errors = err.response.data.errors
                    let errorList = Object.values(errors)
                    errorList.map(msg => {
                        message = msg
                    })
                }
                Swal.fire({
                    icon: 'error',
                    text: err.response.data.message || message
                })
              }
            }
        })
        .finally(() => $(".spinnerz").hide())
    })

    $("#actOpening").on("click", function(e) {
        e.stopImmediatePropagation()
        console.log("USER", user)
        if(user && user.verif_details_submitted === "YES") {
            $("#verificationModal").modal("show")
            axios.post(`/api/get-accessToken`, {
              user_id: user.id
            })
            .then(response => {
              if(response.data.status && response.data.message === 'success') {
                  $("#verificationModal").modal('show')
                  launchWebSdk(response.data.data.token, user.email, user.phone)
              }
              else {
                $("#verificationModal").modal('hide')
              }
            })
            .catch(err => console.log(err))
            .finally(() => {
              $("#spinner").hide()
              $("#verifyKyc").attr('disabled', false)
            })
        }
        else {
            $("#accountOpening").modal("show")
        }
    })    

    function launchWebSdk(accessToken, applicantEmail, applicantPhone) {
            let snsWebSdkInstance = snsWebSdk.init(
                accessToken,
                () => getNewAccessToken()
            )
            .withConf({
                lang: 'en',
                email: applicantEmail,
                phone: applicantPhone,
                i18n: {
                    "document": {
                        "subTitles": {
                            "IDENTITY": "Upload a document that proves your identity"
                        }
                    }
                },
                onMessage: (type, payload) => {
                    console.log('WebSDK onMessage', type, payload)
                },
                uiConf: {
                    customCssStr: ":root {\n  --black: #000000;\n   --grey: #F5F5F5;\n  --grey-darker: #B2B2B2;\n  --border-color: #DBDBDB;\n}\n\np {\n  color: var(--black);\n  font-size: 16px;\n  line-height: 24px;\n}\n\nsection {\n  margin: 40px auto;\n}\n\ninput {\n  color: var(--black);\n  font-weight: 600;\n  outline: none;\n}\n\nsection.content {\n  background-color: var(--grey);\n  color: var(--black);\n  padding: 40px 40px 16px;\n  box-shadow: none;\n  border-radius: 6px;\n}\n\nbutton.submit,\nbutton.back {\n  text-transform: capitalize;\n  border-radius: 6px;\n  height: 48px;\n  padding: 0 30px;\n  font-size: 16px;\n  background-image: none !important;\n  transform: none !important;\n  box-shadow: none !important;\n  transition: all 0.2s linear;\n}\n\nbutton.submit {\n  min-width: 132px;\n  background: none;\n  background-color: var(--black);\n}\n\n.round-icon {\n  background-color: var(--black) !important;\n  background-image: none !important;\n}"
                },
                onError: (error) => {
                    console.error('WebSDK onError', error)
                },
            })
            .withOptions({
                addViewportTag: false,
                adaptIframeHeight: true
            })
            .on('stepCompleted', (payload) => {
                console.log('stepCompleted', payload)
                window.location.reload()
            })
            .on('onError', (error) => {
                console.log('onError', payload)
            })
            .onMessage((type, payload) => {
                console.log('onMessage', type, payload)
            })
            .build();
            snsWebSdkInstance.launch('.sumsub-containers')
    }
        
        function getNewAccessToken() {
            return Promise.resolve(accessToken)
        }
        // Form widget
        
        
        let errorMsg = document.querySelector('#errorMsg');
        
        let getStarted = document.querySelector('#getStarted');
        let firstPage = document.querySelector('#first-page');
        
        let secondPage = document.querySelector('#second-page');
        let secondBtn = document.querySelector('#second-btn');
        let secondBtnBack = document.querySelector("#second-back");
        
        let thirdBtn = document.querySelector('#third-btn');
        let thirdPage = document.querySelector('#third-page');
        let thirdBtnBack = document.querySelector("#third-back");
        
        let fouthBtn = document.querySelector('#fouth-btn');
        let fouthPage = document.querySelector('#fouth-page');
        let fouthBtnBack = document.querySelector("#fouth-back");
        
        let fifthBtn = document.querySelector('#fifth-btn');
        let fifthPage = document.querySelector('#fifth-page');
        let fifthBtnBack = document.querySelector("#fifth-back");
        
        let sixthBtn = document.querySelector('#sixth-btn');
        let sixthPage = document.querySelector('#sixth-page');
        let sixthBtnBack = document.querySelector("#sixth-back");
        
        let seventhBtn = document.querySelector('#seventh-btn');
        let seventhPage = document.querySelector('#seventh-page');
        let seventhBtnBack = document.querySelector("#seventh-back");
        
        let eightBtn = document.querySelector('#eight-btn');
        let eightPage = document.querySelector('#eight-page');
        let eightBtnBack = document.querySelector("#eight-back");
        
        let ninthBtn = document.querySelector('#ninth-btn');
        let ninthPage = document.querySelector('#ninth-page');
        let ninthBtnBack = document.querySelector("#ninth-back");
        
        let finalBtn = document.querySelector('#final-btn');
        let finalPage = document.querySelector('#final-page');
        let finalBtnBack = document.querySelector("#final-back");
        
        
        
        
        getStarted.addEventListener('click',()=>{
        firstPage.classList.toggle('d-none');
        secondPage.classList.toggle('d-none');
        });
        
        secondBtn.addEventListener('click',() => {
        let value = (document.querySelector('input[name="usingTryba"]:checked')) ? document.querySelector('input[name="usingTryba"]:checked').value : false;
        if(!value){
            errorMsg.innerText = "Select an option";
        }else{
            errorMsg.innerText = ""
            secondPage.classList.toggle('d-none');
            thirdPage.classList.toggle('d-none');
        }
        });
        
        secondBtnBack.addEventListener('click',()=>{
        secondPage.classList.toggle('d-none');
        firstPage.classList.toggle('d-none');       
        });
        
        thirdBtn.addEventListener('click',() => {
        let value = (document.querySelector('input[name="servicesType"]:checked')) ? document.querySelector('input[name="servicesType"]:checked').value : false;
        if(!value){
            errorMsg.innerText = "Select an option";
        }else{
            errorMsg.innerText = "";
            thirdPage.classList.toggle('d-none');
            fouthPage.classList.toggle('d-none');
        }
        });
        
        thirdBtnBack.addEventListener('click',()=>{
        thirdPage.classList.toggle('d-none');
        secondPage.classList.toggle('d-none');
        });
        
        fouthBtn.addEventListener('click',() => {
        let value = (document.querySelector('input[name="gender"]:checked')) ? document.querySelector('input[name="gender"]:checked').value : false;
        let day = document.querySelector('#date_account').value;
        let month = document.querySelector('#month_account').value;
        let year = document.querySelector('#year_account').value;
        errorMsg.innerText = "";
        if(!value){
            errorMsg.innerText = "Select a gender option";
        }else if(!day || !month || !year){
            errorMsg.innerText = "Select your date of birth";
        }
        else{
            errorMsg.innerText = "";
            let date = `${year}/${month}/${day}`
            fouthPage.classList.toggle('d-none');
            fifthPage.classList.toggle('d-none');
        }       
        });
        
        fouthBtnBack.addEventListener('click',()=>{
        fouthPage.classList.toggle('d-none');
        thirdPage.classList.toggle('d-none');
        });
        
        fifthBtn.addEventListener('click',() => {
        let value = document.querySelector('#business_description').value;
        if(!value){
            errorMsg.innerText = "Description field is required";
        }else{
            errorMsg.innerText = "";
            fifthPage.classList.toggle('d-none');
            sixthPage.classList.toggle('d-none');
        }
        });
        
        fifthBtnBack.addEventListener('click',()=>{
        fifthPage.classList.toggle('d-none');
        fouthPage.classList.toggle('d-none');
        });
        
        sixthBtn.addEventListener('click',() => {
        let value = (document.querySelector('input[name="ownWebsite"]:checked')) ? document.querySelector('input[name="ownWebsite"]:checked').value : false;
        let websiteURL = document.querySelector("#websiteURL").value
        if(!value){
            errorMsg.innerText = "Select an option";
        }else if(value == 'yes' && !websiteURL)
            errorMsg.innerText = "Website URL field is required";
        else{
            errorMsg.innerText = "";
            sixthPage.classList.toggle('d-none');
            seventhPage.classList.toggle('d-none');
        }
        
        });
        
        sixthBtnBack.addEventListener('click',()=>{
        sixthPage.classList.toggle('d-none');
        fifthPage.classList.toggle('d-none');
        });
        
        seventhBtn.addEventListener('click',() => {
        let value = document.querySelector('#turnover').value;
        if (!value) {
            errorMsg.innerText = "Turn over field is required";
        }else{
            errorMsg.innerText = "";
            seventhPage.classList.toggle('d-none');
            eightPage.classList.toggle('d-none');
        }
        
        });
        
        seventhBtnBack.addEventListener('click',()=>{
        seventhPage.classList.toggle('d-none');
        sixthPage.classList.toggle('d-none');  
        });
        
        eightBtn.addEventListener('click',() => {
        let value = document.querySelector('#business_name').value;
        if (!value) {
            errorMsg.innerText = "Business name field is required";
        }else{
            errorMsg.innerText = "";
            eightPage.classList.toggle('d-none');
            ninthPage.classList.toggle('d-none');
        }
        });
        
        eightBtnBack.addEventListener('click',()=>{
        eightPage.classList.toggle('d-none');
        seventhPage.classList.toggle('d-none');
        });
        
        
        ninthBtn.addEventListener('click',() => {
        ninthPage.classList.toggle('d-none');
        finalPage.classList.toggle('d-none');
        });
        
        ninthBtnBack.addEventListener('click',()=>{
        ninthPage.classList.toggle('d-none');
        eightPage.classList.toggle('d-none');
        });
        
        finalBtn.addEventListener('click',() => {
        let postal_code = document.querySelector('#postal_code').value;
        let state = document.querySelector('#state').value;
        let address_line = document.querySelector('#address_line').value;
        if (!postal_code){
            errorMsg.innerText = "Postal code field is required";
        }else if(!state){
            errorMsg.innerText = "State field is required";
        }else if(!address_line){
            errorMsg.innerText = "Address field is required";
        }else{
            errorMsg.innerText = "";
            $(".spinnerz").show()
            let formdata = Object.fromEntries(new FormData($("#accountOpeningForm").get(0)).entries());
            formdata.dob = `${formdata.year_account}-${formdata.month_account}-${formdata.date_account}`
            console.log("Form data", formdata)
            axios.post('/api/compliance-verification/verification', formdata, {
                headers: {
                    'Conten-Type': 'application/json'
                }
            })
            .then(response => {
                console.log("TOKEN", response.data.status)
                console.log("TOKEN", response.data.token)
                if(response.data.status && response.data.token != null) {
                    // $('#accountOpeningForm').hide();
                    $('#accountOpening').modal('hide');
                    // $("#verificationModal").modal('show')
                    // console.log(response.data.token)
                    // console.log(formdata.email)
                    // console.log(formdata.phone)
                    launchWebSdk(response.data.token, formdata.email, formdata.phone)                 
                }
            })
            .catch(err =>  {
                if(err.response) {
                  let message
                  if(err.response.status == 422 || err.response.status == 200 || err.response.status == 401 || err.response.status == 404) {
                    if(err.response.data.errors) {
                        let errors = err.response.data.errors
                        let errorList = Object.values(errors)
                        errorList.map(msg => {
                            message = msg
                        })
                    }
                    Swal.fire({
                        icon: 'error',
                        text: err.response.data.message || message
                    })
                  }
                }
            })
            .finally(() => $(".spinnerz").hide())        
        }
        });
        
        finalBtnBack.addEventListener('click',()=>{
        finalPage.classList.toggle('d-none');
        ninthPage.classList.toggle('d-none');
        });
        
        $('input[name="ownWebsite"]').on('change', function(e) {
        var item = event.target.value;
        errorMsg.innerText = "";
        let div = document.querySelector("#websitediv");
        let social = document.querySelector("#websiteSocial")
        if(item == 'yes'){
            social.classList.add('d-none')
            div.classList.toggle('d-none');
        }else{
            div.classList.add('d-none');
            social.classList.toggle('d-none');
        }
        });

})        
    
    
