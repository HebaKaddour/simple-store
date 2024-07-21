// This is your test publishable API key.
const stripe = Stripe("pk_test_51PWlPJRvU9zVGftxjcOQZ7RiZH8J2X6EJxsL8Hf9IQuw2CR3T6gq8crtIfNu0VimWjQzqgNVjQV5jolvq4PuxdSX00Xwfoyb6B");

// The items the customer wants to buy
const items = [{ id: "xl-tshirt" }];


let elements;

initialize();
checkStatus();

document
  .querySelector("#payment-form")
  .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {
    try {
      const response = await fetch('api/handle', {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ items }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        console.error('Error creating payment intent:', errorData);
        return;
      }

      const { client_secret } = await response.json();
      if (!client_secret) {
        console.error('No client_secret returned');
        return;
      }

      const elements = stripe.elements({ clientSecret: client_secret });

      const paymentElementOptions = {
        layout: "tabs",
      };

      const paymentElement = elements.create("payment", paymentElementOptions);
      paymentElement.mount("#payment-element");
    } catch (error) {
      console.error('Error initializing payment:', error);
    }
  }

async function handleSubmit(e) {
  e.preventDefault();
  setLoading(true);

  const { error } = await stripe.confirmPayment({
    elements,
    confirmParams: {
      // Make sure to change this to your payment completion page
      return_url: "{{ route('confirm') }}",
    },
  });
  if (paymentIntent.error) {
    // Handle payment error
  } else {
    // Redirect the user to the confirmation page with the payment_intent_id
    window.location.href = "{{ route('confirm') }}";
  }

  // This point will only be reached if there is an immediate error when
  // confirming the payment. Otherwise, your customer will be redirected to
  // your `return_url`. For some payment methods like iDEAL, your customer will
  // be redirected to an intermediate site first to authorize the payment, then
  // redirected to the `return_url`.
  if (error.type === "card_error" || error.type === "validation_error") {
    showMessage(error.message);
  } else {
    showMessage("An unexpected error occurred.");
  }

  setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
  const clientSecret = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
  );

  if (!clientSecret) {
    return;
  }

  const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

  switch (paymentIntent.status) {
    case "succeeded":
      showMessage("Payment succeeded!");
      break;
    case "processing":
      showMessage("Your payment is processing.");
      break;
    case "requires_payment_method":
      showMessage("Your payment was not successful, please try again.");
      break;
    default:
      showMessage("Something went wrong.");
      break;
  }
}

// ------- UI helpers -------

function showMessage(messageText) {
  const messageContainer = document.querySelector("#payment-message");

  messageContainer.classList.remove("hidden");
  messageContainer.textContent = messageText;

  setTimeout(function () {
    messageContainer.classList.add("hidden");
    messageContainer.textContent = "";
  }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("#submit").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
}
