<?php
$conn = new mysqli("localhost", "root", "", "bomb_game");

$action = $_POST['action'];
$user = $_POST['username'];
$pass = $_POST['password'];

if ($action == "register") {
    
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $hashed_pass);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "User already exists!";
    }
    $stmt->close();

} else {
   
  
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        
        if (password_verify($pass, $row['password'])) {
            echo "success";
        } else {
            echo "Invalid Credentials!";
        }
    } else {
        echo "Invalid Credentials!";
    }
    $stmt->close();
}
$conn->close();
?>