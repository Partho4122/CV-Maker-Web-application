<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_maker"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $religion = $_POST['religion'];
    $nationality = $_POST['nationality'];
    $marital_status = $_POST['marital_status'];
    $hobbies = $_POST['hobbies'];
    $languages = $_POST['languages'];
    $address = $_POST['address'];

    // Insert data into database
    $sql = "INSERT INTO cv_data (full_name, email, mobile, dob, gender, religion, nationality, marital_status, hobbies, languages, address) 
            VALUES ('$full_name', '$email', '$mobile', '$dob', '$gender', '$religion', '$nationality', '$marital_status', '$hobbies', '$languages', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('CV created successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
