<?php
//purpose of this file: review registration details and collect payment info via Stripe

session_start();

if (file_exists(__DIR__ . '/.reg-closed')) {
    include 'registration-closed.php';
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: template.html");
    exit;
}
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Review & Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Review Registration</h1>
    <p><strong>Group:</strong> <?= htmlspecialchars($cart['group_name']) ?></p>
    <p><strong>Total:</strong> $<?= number_format($cart['total_cost'], 2) ?></p>
    <p><strong>PO Number:</strong> <?= htmlspecialchars($cart['po_number']) ?></p>

    <form id="payment-form" action="charge.php" method="post">
        <div id="card-element" style="padding: 10px; border: 1px solid #ccc; margin: 20px 0;"></div>
        <button type="submit">Pay $<?= number_format($cart['total_cost'], 2) ?> with Stripe</button>
    </form>

    <script>
        const stripe = Stripe('pk_test_5zXydl1GTGaWdaNmEDh7Oa6G'); 
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const { token, error } = await stripe.createToken(card);
            if (error) {
                alert(error.message);
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    </script>
</body>
</html>