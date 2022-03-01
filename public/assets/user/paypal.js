paypal.Buttons({
    style : {
        color: 'blue'
    },
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units:[{
              amount: {
                  value:'150'
              }
            }]
        })
    },
    onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
            console.log(details)
          window.location.replace("/user/facture")
        })
    }
}).render('#paypal-payment-button');