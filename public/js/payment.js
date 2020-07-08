(function() {
    console.log(key);
    var stripe = Stripe(key);
    var elements = stripe.elements();
    // var cardElement = elements.create('card');
    // cardElement.mount('#card-element');

    var style = {};

    var classes = {
        base: {}
    };

    var option = {
        style: style,
        classes: classes
        // hidePostalCode: true,
    };

    var cardNumberElement = elements.create("cardNumber");
    cardNumberElement.mount("#card-number");

    var cardExpiryElement = elements.create("cardExpiry");
    cardExpiryElement.mount("#card-expiry");

    var cardCvcElement = elements.create("cardCvc");
    cardCvcElement.mount("#card-cvc");

    document
        .getElementById("payment-form")
        .addEventListener("submit", async function(e) {
            e.preventDefault();

            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: "card",
                card: cardNumberElement,
                billing_details: {
                    name: document.getElementById("card-holder-name").value
                }
            });

            if (error) {
                alert("決済に失敗しました。");
                errorElement.textContent = error.message;
            } else {
                alert("決済します。");
                console.log(paymentMethod.id);
                paymentMethodsHandler(paymentMethod.id);
            }
        });

    function paymentMethodsHandler(paymentMethodId) {
        var form = document.getElementById("payment-form");
        var hiddenInput = document.createElement("input");
        hiddenInput.setAttribute("type", "hidden");
        hiddenInput.setAttribute("name", "paymentMethodsId");
        hiddenInput.setAttribute("value", paymentMethodId);
        form.appendChild(hiddenInput);

        form.submit();
    }
})();
