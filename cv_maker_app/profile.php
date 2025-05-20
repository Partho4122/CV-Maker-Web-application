<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found in the database!";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            overflow: hidden;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #007bff;
            margin-bottom: 15px;
        }

        .profile-header h2 {
            margin: 10px 0;
            color: #343a40;
        }

        .profile-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
            padding: 20px;
            border-top: 2px solid #f1f1f1;
        }



        .profile-info p {
            font-size: 16px;
            margin: 10px 0;
            color: #333;
            line-height: 1.6;
        }
        
        .profile-info p span {
            font-weight: bold;
            color: #1e88e5;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .actions a {
            text-decoration: none;
            padding: 12px 25px;
            background: #1e88e5;
            color: #ffffff;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .actions a:hover {
            background: #1565c0;
            transform: translateY(-2px);
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #888;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
            <h2><?php echo htmlspecialchars($user['fullname']); ?></h2>
        </div>

        <div class="profile-info">
            <p><span>Email:</span> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><span>Phone:</span> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><span>Date of Birth:</span> <?php echo htmlspecialchars($user['dob']); ?></p>
            <p><span>Address:</span> <?php echo htmlspecialchars($user['address']); ?></p>
        </div>

        <div class="actions">
            <a href="edit_profile.php">Edit Profile</a>
            <a href="cvtemplate.html">CV Templates</a>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> CV Builder | All Rights Reserved
    </footer>
</body>
</html>