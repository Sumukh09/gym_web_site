<?php
// backend.php

$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "gymApp";

// Create connection
$conn =  mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the POST request (save workout data)
    $exercise = $_POST["exercise"];
    $sets = $_POST["sets"];
    $reps = $_POST["reps"];
    $weight = $_POST["weight"];

    // Here, you can insert this data into your database
    $sql = "INSERT INTO workout_data (exercise, sets, reps, weight) VALUES ('$exercise', $sets, $reps, $weight)";

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            "exercise" => $exercise,
            "sets" => $sets,
            "reps" => $reps,
            "weight" => $weight,
        ]);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Handle other requests (e.g., fetching existing workout data)
    // For simplicity, we'll just return dummy data in this example
    $result = $conn->query("SELECT * FROM workout_data");

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "exercise" => $row["exercise"],
            "sets" => $row["sets"],
            "reps" => $row["reps"],
            "weight" => $row["weight"],
        ];
    }

    echo json_encode($data);
}

$conn->close();
?>
