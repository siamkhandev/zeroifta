@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form id="payment-form">
    <div class="mb-3">
        <label for="methodName" class="form-label">Method Name</label>
        <input type="text" class="form-control" id="methodName" placeholder="Method Name" required>
    </div>
    <div class="mb-3">
        <label for="card-element" class="form-label">Card Details</label>
        <!-- Stripe Elements Card Element will be inserted here -->
        <div id="card-element" class="form-control"></div>
        <div id="card-errors" role="alert" style="color: red; margin-top: 5px;"></div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Add Payment Method</button>
</form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsencrypt/3.0.0/jsencrypt.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Stripe
        const stripe = Stripe('YOUR_STRIPE_PUBLISHABLE_KEY'); // Replace with your Stripe publishable key
        const elements = stripe.elements();

        // Create an instance of the card Element
        const card = elements.create('card', {
            style: {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });

        // Mount the card Element into the #card-element div
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element
        card.on('change', function (event) {
            const errorElement = $('#card-errors');
            if (event.error) {
                errorElement.text(event.error.message);
            } else {
                errorElement.text('');
            }
        });

        // Handle form submission
        $('#payment-form').on('submit', async function (e) {
            e.preventDefault();

            const methodName = $('#methodName').val(); // Get method name

            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: methodName
                }
            });

            if (error) {
                // Show error in the form
                $('#card-errors').text(error.message);
                return;
            }

            // Send the paymentMethod.id to your server
            $.ajax({
                url: '/store-payment-method',
                type: 'POST',
                data: {
                    paymentMethodId: paymentMethod.id,
                    methodName: methodName,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status === 200) {
                        alert('Payment method added successfully!');
                    } else {
                        alert('Failed to add payment method: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>
@endsection
