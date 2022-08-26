// Create a Stripe client.
var stripe = Stripe(ppxd);
  
// Create an instance of Elements.
var elements = stripe.elements();

var paymentRequest = stripe.paymentRequest({
     country: 'US',
     currency: 'usd',
     total: {
      label: 'Demo total',
      amount: 100,
     },
    requestPayerName: true,
    requestPayerEmail: true,
    });
    
paymentRequest.on('source', function(event) {
     console.log('Got source: ', event.source.id);
     event.complete('success');
     ChromeSamples.log(JSON.stringify(event.source, 2));
     // Send the source to your server to charge it!
    });
    
var prButton = elements.create('paymentRequestButton', {
     paymentRequest: paymentRequest,
    });
// Check the availability of the Payment Request API first.
paymentRequest.canMakePayment().then((result) => {
 //console.log(prButton);
 if (result) {
  prButton.mount('#payment-request-button');
 } else {
  document.getElementById('payment-request-button').style.display = 'none';
 }
});

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#222221',
        fontFamily: 'Graphik, Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '13px',
        iconColor: '#5e72e4',
        fontWeight: '400',
        '::placeholder': {
            color: '#222221'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
  
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
  
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
  
// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});
  
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    $("#pay-now").attr("disabled", "disabled");
    card.update({disabled: true});
    stripe.createSource(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeSourceHandler(result.source);
        }
    });
});
  
// Submit the form with the source ID.
function stripeSourceHandler(source) {
    // Insert the source ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeSource');
    hiddenInput.setAttribute('value', source.id);
    form.appendChild(hiddenInput);
  
    // Submit the form
    form.submit();
  }
