<?php
session_start();

// ডাটাবেস সংযোগ
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";  // এখানে রেজিস্ট্রেশন টেবিলের ডাটাবেস থাকবে

$conn = new mysqli($servername, $username, $password, $dbname);

// কানেকশন চেক
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ফর্ম সাবমিশন চেক
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email'])); // ইমেইল ইনপুট
    $password = trim($_POST['password']); // পাসওয়ার্ড ইনপুট

    // ইমেইল দিয়ে ইউজার খুঁজুন
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // পাসওয়ার্ড যাচাই
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id; // সেশন সেট করা
            $_SESSION['email'] = $email;

            // লগইন সফল হলে প্রোফাইল বা ড্যাশবোর্ডে রিডাইরেক্ট
            header("Location: cvtemplate.html");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>
