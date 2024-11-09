@extends('layouts.main')

@section('content')
<style>
    .card-element {
        border: 1px solid #ccc; /* Border style */
        padding: 10px; /* Padding around the card element */
        height: 50px; /* Height of the card element */
        border-radius: 5px; /* Border radius */
    }
</style>
<div class="row">
    
    <div class="col-md-3"></div>
    <div class="col-md-6">
        

    <div class="card shadow-lg mx-4 card-profile-bottom" style="margin-top: 4rem;">
    <div class="card-body p-3">
    <h4>Subscribe to {{ $plan->name }}</h4>
    <form id="subscribe-form" action="{{route('pay')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="card-element">
                Credit or debit card
            </label>
            <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
            </div>
            <div id="card-errors" role="alert"></div>
        </div>
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <button type="submit" class="btn btn-primary">Subscribe</button>
    </form>
    </div>
  </div>
    </div>
    <div class="col-md-3"></div>
</div>
  
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('subscribe-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: '{{ Auth::user()->name }}',
                },
            }).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.paymentMethod.id);
                }
            });
        });

        function stripeTokenHandler(paymentMethodId) {
            var form = document.getElementById('subscribe-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', paymentMethodId);
            form.appendChild(hiddenInput);

            form.submit();
        }
    </script>
</div>
@endsection
