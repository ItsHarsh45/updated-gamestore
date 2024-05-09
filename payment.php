<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    
    <style>
        body {
            background-image: url("images/bg3.jpg");
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: black; 
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .navbar-brand {
            color: black; 
            font-weight: bold;
        }

        .nav-link {
            color: black; 
        }

        .card {
            background-color: rgba(255, 255, 255, 0.37); 
            backdrop-filter: blur(5px); 
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            padding: 20px;
            margin: 20px auto;
            max-width: 500px;
            color: black; 
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: black; 
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            color: black; 
        }

        button[type="submit"] {
            background-color: teal;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        #cart-total {
            font-weight: bold;
            color: black; 
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="Aboutus.html">Game Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Home.html">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="Cart.html">Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h1 class="text-center">Checkout</h1>
            <form method="post">
                <div class="form-group">
                    <label for="total-amount">Total Amount</label>
                    <input type="text" id="total-amount" name="total_amount" readonly>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" required>
                </div>

                <div id="credit-card-details">
                    <h2>Credit Card or Debit card</h2>
                    <div class="form-group">
                        <label for="card-number">CARD NUMBER</label>
                        <input type="text" id="card-number" name="card_number" placeholder="Enter card number" required>
                    </div>
                    <div class="form-group">
                        <label for="card-holder-name">CARD HOLDER NAME</label>
                        <input type="text" id="card-holder-name" name="card_holder_name" placeholder="eg:Jamie Vardy" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry-date">EXPIRY DATE (MM/YY)</label>
                        <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="Enter CVV" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Pay</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            var total = cartItems.reduce(function (acc, curr) {
                return acc + parseFloat(curr.price);
            }, 0).toFixed(2);

            document.getElementById('total-amount').value = total;
            document.getElementById('total-amount-display').textContent = total;
        });
    </script>

</body>

</html>

<?php
$conn = mysqli_connect("localhost", "root", "");

$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

function encryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_amount = htmlspecialchars($_POST["total_amount"]);
    $email = htmlspecialchars($_POST["email"]);

    $card_number = htmlspecialchars($_POST["card_number"]);
    $card_holder_name = htmlspecialchars($_POST["card_holder_name"]);

    $enc_card_number = encryptthis($card_number, $key);
    $enc_card_holder_name = encryptthis($card_holder_name, $key);

    $payment_query = "INSERT INTO websitelogin.payment_details (email, total_amount, full_date) VALUES ('$email', '$total_amount', NOW())";
    mysqli_query($conn, $payment_query);

    $card_query = "INSERT INTO websitelogin.card_details (enc_card_number, enc_card_holder_name) VALUES ('$enc_card_number', '$enc_card_holder_name')";
    mysqli_query($conn, $card_query);

    echo "<script>alert('Payment successful. Your key is sent to your registered email.');window.location.href='Home.html';</script>";
}
?>
