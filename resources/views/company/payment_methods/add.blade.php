@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form id="payment-form">
        <div class="mb-3">
            <label for="cardHolderName" class="form-label">Method Name</label>
            <input type="text" class="form-control" id="methodName" placeholder="Method Name" required>
        </div>
        <div class="mb-3">
            <label for="cardHolderName" class="form-label">Card Holder Name</label>
            <input type="text" class="form-control" id="cardHolderName" placeholder="Enter Card Holder Name" required>
        </div>
        <div class="mb-3">
            <label for="cardNumber" class="form-label">Card Number</label>
            <input type="text" class="form-control" id="cardNumber" placeholder="Enter Card Number" maxlength="16" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="expiryDate" class="form-label">Expiry Date (MM/YY)</label>
                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" maxlength="5" required>
            </div>
            <div class="col-md-6">
                <label for="cvc" class="form-label">CVC</label>
                <input type="text" class="form-control" id="cvc" placeholder="CVC" maxlength="4" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Add Payment Method</button>
    </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsencrypt@3.0.0/bin/jsencrypt.min.js"></script>
<script>
    document.getElementById('payment-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const methodName = document.getElementById('methodName').value;
        const cardHolderName = document.getElementById('cardHolderName').value;
        const cardNumber = document.getElementById('cardNumber').value;
        const expiryDate = document.getElementById('expiryDate').value;
        const cvc = document.getElementById('cvc').value;

        // RSA Public Key (Replace with your actual public key)
        const publicKey = `-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApJsv/AC05XsMNA0kt4P2
C+pKV6FVqk6INlPKBEdyq9AO1/kuzkVq+EcbCM2m2vmOn68iFTmsrebkP5aUV9gd
2Pvj9nzegvN3sN0qaBQxkCyP52Kl875tB5eT8KRnUZ/2ZVjHdSqoFr6O53F8bcDV
zHoB5SPA9fv53d9y3OMm4uCLv1XeClayEmevPD6T1julsvo4kmV7hlABIGZ4JiEK
CKb/E1jVCbVgR44Y6yxm0PhcTHWr/Pcos+PS2OaOnfjLJN2kjcxnd+jMRwtJJ8Mb
YORpta0ZWgqaU2UiBkmXGv/tnDDBWcp+RQGa6wA3JP098rj7XOTsiLcSKO2xNHS/
VwIDAQAB
-----END PUBLIC KEY-----`;

        // Encrypt using jsencrypt
        const encrypt = new JSEncrypt();
        encrypt.setPublicKey(publicKey);

        const encryptedData = encrypt.encrypt(JSON.stringify({
            methodName,
            cardHolderName,
            cardNumber,
            expiryDate,
            cvc
        }));

        if (!encryptedData) {
            alert('Encryption failed. Please try again.');
            return;
        }

        // Send encrypted data to the backend
        const response = await fetch('/store-payment-method', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                "_token": "{{ csrf_token() }}",
            },
            body: JSON.stringify({ encryptedData })
        });

        const result = await response.json();
        if (result.success) {
            alert('Payment method added successfully!');
        } else {
            alert('Failed to add payment method.');
        }
    });
</script>
@endsection
