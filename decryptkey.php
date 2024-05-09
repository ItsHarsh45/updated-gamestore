<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('images/bg4.png') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .card {
            width: 800px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(9px);
            color: #fff;
            border-radius: 12px;
            padding: 30px 40px;
            position: relative;
        }

        .card h1 {
            font-size: 36px;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: white;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        button[type="submit"] {
            background-color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: black;
            cursor: pointer;
            border-radius: 5px;
        }

        .output {
            background-color: rgba(211, 211, 211, 0.5);
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 18px;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: transparent;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="card">
        <a href="admin.html" class="back-button">&#8592;</a>
        <h1>AES Decryption</h1>
        <form method="post">
            <div class="form-group">
                <label for="email">Encrypted Card Number</label>
                <input type="text" id="enccn" name="enccn" placeholder="Enter Encrypted Card Number" required>
            </div>
            <div class="form-group">
                <label for="card-number">Encrypted Card Holder Name</label>
                <input type="text" id="encchn" name="encchn" placeholder="Enter Encrypted Card Holder Name" required><br/><br/>
                <button type="submit" class="btn btn-primary">Decrypt</button>
            </div>
        </form>
        <?php
        $conn = mysqli_connect("localhost", "root", "");

        $key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

        function decryptthis($data, $key)
        {
            $encryption_key = base64_decode($key);
            list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
            return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $enccn = htmlspecialchars($_POST["enccn"]);
            $encchn = htmlspecialchars($_POST["encchn"]);

            $dec_card_number = decryptthis($enccn, $key);
            $dec_card_holder_name = decryptthis($encchn, $key);

            $query = "INSERT INTO websitelogin.decrypteddata VALUES('','$dec_card_number','$dec_card_holder_name')";
            mysqli_query($conn, $query);

            echo '<div class="output">';
            echo '<h2>Decrypted Data</h2>';
            echo '<p><strong>Decrypted Card Number:</strong> ' . $dec_card_number . '</p>';
            echo '<p><strong>Decrypted Card Holder Name:</strong> ' . $dec_card_holder_name . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>