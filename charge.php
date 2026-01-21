<?php
session_start();

if (file_exists(__DIR__ . '/.reg-closed')) {
    include 'registration-closed.php';
    exit;
}

if (empty($_SESSION['cart'])) {
    $error_message = "No cart data found. Please start registration again.";
    $is_success = false;
} else {
    require 'vendor/autoload.php';
    \Stripe\Stripe::setApiKey('sk_test_h4tVlJzffFYOhkmJQxGf8sgx'); // ← use your real key in production

    $token = $_POST['stripeToken'] ?? null;
    $total_cost = (float) ($_SESSION['cart']['total_cost'] ?? 0);
    $group_name = $_SESSION['cart']['group_name'] ?? 'Unknown Group';
    $email = $_SESSION['cart']['email'] ?? $_SESSION['cart']['user_email'] ?? null;

    if (!$token) {
        $error_message = "No payment token received. Please try again.";
        $is_success = false;
    } elseif ($total_cost <= 0) {
        $error_message = "Registration total is $0. Please add at least one participant.";
        $is_success = false;
    } else {
        $amount_in_cents = (int) round($total_cost * 100);

        try {
            $charge = \Stripe\Charge::create([
                'amount'      => $amount_in_cents,
                'currency'    => 'usd',
                'description' => "2026 Tucson Mariachi Conference Registration - $group_name",
                'source'      => $token,
                'receipt_email' => $email,
            ]);

            $is_success = true;
            $charge_id = $charge->id;
            $payment_amount = number_format($total_cost, 2);

            // Clear cart on success
            unset($_SESSION['cart']);

        } catch (\Stripe\Exception\CardException $e) {
            $error_message = $e->getError()->message ?? 'Your card was declined.';
            $is_success = false;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $error_message = $e->getMessage() ?: 'Invalid payment request.';
            $is_success = false;
        } catch (Exception $e) {
            $error_message = $e->getMessage() ?: 'An unexpected error occurred.';
            error_log("Stripe error: " . $e->getMessage());
            $is_success = false;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Result - Tucson Mariachi Conference</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
        }
        .container {
            max-width: 620px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            background: #10e225;
            color: white;
            padding: 30px 25px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
        }
        .content {
            padding: 35px 30px;
            text-align: center;
        }
        h2 {
            margin: 0 0 1.2em;
            font-size: 28px;
        }
        .success-icon {
            font-size: 64px;
            color: #2e7d32;
            margin-bottom: 0.4em;
        }
        .error-icon {
            font-size: 64px;
            color: #c62828;
            margin-bottom: 0.4em;
        }
        .details {
            background: #f5f5f5;
            border-radius: 6px;
            padding: 20px;
            margin: 1.8em 0;
            text-align: left;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .details p {
            margin: 0.8em 0;
        }
        .highlight {
            color: #b22222;
            font-weight: bold;
        }
        .gold {
            color: #d4a017;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background: #f5f5f5;
            color: #222;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 1.5em;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #c6c6c6;
        }
        .footer {
            background: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #666;
            border-top: 1px solid #eee;
        }
        .footer a {
            color: #b22222;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>2026 Tucson International Mariachi Conference</h1>
        <p>Payment Processing</p>
    </div>

    <div class="content">

        <?php if ($is_success): ?>
            <h2>Payment Successful!</h2>
            <p>Thank you for registering your group<?php if ($group_name !== 'Unknown Group') echo " <strong>$group_name</strong>"; ?>.</p>
            <p>Your payment of <span class="highlight">$<?php echo $payment_amount; ?></span> was successfully processed.</p>

            <div class="details">
                <p><strong>Charge ID:</strong> <?php echo htmlspecialchars($charge_id); ?></p>
                <p><strong>Amount:</strong> $<?php echo $payment_amount; ?></p>
                <?php if ($email): ?>
                    <p><strong>Receipt sent to:</strong> <?php echo htmlspecialchars($email); ?></p>
                <?php endif; ?>
            </div>

            <p>A detailed confirmation email has also been sent to you.</p>
            <a href="index.php" class="btn">Return to Home Page</a>

        <?php else: ?>
            <h2>Payment Could Not Be Processed</h2>
            <p><?php echo htmlspecialchars($error_message ?? 'An unknown error occurred.'); ?></p>

            <?php if (isset($total_cost) && $total_cost <= 0): ?>
                <p>Please go back and make sure at least one participant is added.</p>
            <?php endif; ?>

            <p style="color:#555; margin-top:2em;">
                If this problem continues, please contact us at<br>
                <a href="mailto:info@tucsonmariachi.org">info@tucsonmariachi.org</a>
            </p>
        <?php endif; ?>

    </div>

    <div class="footer">
        <p>2026 Tucson Mariachi Conference | tucsonmariachi.org</p>
    </div>
</div>

</body>
</html>