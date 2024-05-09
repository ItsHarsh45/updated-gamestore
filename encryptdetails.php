<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('images/bg4.png') no-repeat;
            background-size: cover;
            background-position: center;
            font-family: 'Poppins', sans-serif;
        }

        .wrapper {
            width: calc(100% - 300px);
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(9px);
            color: #fff;
            border-radius: 12px;
            padding: 30px 40px;
            position: relative;
        }

        .wrapper h1 {
            font-size: 36px;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-align: left;
        }

        th {
            background-color: rgba(255, 255, 255, 0.3);
        }

        tr:last-child td {
            border-bottom: none;
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
    <div class="wrapper">
        <a href="admin.html" class="back-button">&#8592;</a>
        <h1>Card Details</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Encrypted Card Number</th>
                    <th>Encrypted Card Holder Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = mysqli_connect("localhost", "root", "");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $database = "websitelogin";
                mysqli_select_db($conn, $database);

                $sql = "SELECT id, enc_card_number, enc_card_holder_name FROM card_details";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td>' . $row["id"] . '</td>
                                <td>' . $row["enc_card_number"] . '</td>
                                <td>' . $row["enc_card_holder_name"] . '</td>
                            </tr>';
                    }
                } else {
                    echo "<tr><td colspan='3'>No card details found.</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>