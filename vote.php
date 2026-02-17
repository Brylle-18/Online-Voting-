<?php
session_start();
include 'db.php';

$allowed = ["Python", "Java", "C++", "JavaScript"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['voted'])) {
        header("Location: results.php?msg=already_voted");
        exit();
    }

    $vote = $_POST['vote'] ?? '';

    if (!in_array($vote, $allowed)) {
        header("Location: index.html?msg=invalid");
        exit();
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO votes (language) VALUES (?)");
    mysqli_stmt_bind_param($stmt, "s", $vote);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['voted'] = true;

    header("Location: results.php?msg=success");
    exit();
}
?>