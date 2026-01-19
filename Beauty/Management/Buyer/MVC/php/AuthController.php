<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../db/connection.php';

function registerUser($firstName, $lastName, $email, $password, $confirmPassword)
{
    global $connection;

  
    if ($password !== $confirmPassword) {
        return array('status' => false, 'message' => 'Passwords do not match');
    }

    $email = escapeInput($email);

  
    $checkQuery = "SELECT user_id FROM users WHERE email = '$email'";
    $result = fetchOne($checkQuery);

    if ($result) {
        return array('status' => false, 'message' => 'Email already registered');
    }

   
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $firstName = escapeInput($firstName);
    $lastName = escapeInput($lastName);

    $insertQuery = "INSERT INTO users (first_name, last_name, email, password)
                    VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";

    if (executeQuery($insertQuery)) {
        return array('status' => true, 'message' => 'Registration successful. Please login.');
    } else {
        return array('status' => false, 'message' => 'Registration failed. Try again.');
    }
}

function loginUser($email, $password)
{
    global $connection;

    $email = escapeInput($email);

    $query = "SELECT user_id, first_name, last_name, email, password FROM users WHERE email = '$email'";
    $user = fetchOne($query);

    if (!$user) {
        return array('status' => false, 'message' => 'Email not found');
    }

    if (!password_verify($password, $user['password'])) {
        return array('status' => false, 'message' => 'Invalid password');
    }

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['logged_in'] = true;

    return array('status' => true, 'message' => 'Login successful');
}


function logoutUser()
{
    session_destroy();
    return array('status' => true, 'message' => 'Logged out successfully');
}


function isUserLoggedIn()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function getCurrentUserId()
{
    if (isUserLoggedIn()) {
        return $_SESSION['user_id'];
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {

        if ($_POST['action'] == 'register') {
            $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
            $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            $result = registerUser($firstName, $lastName, $email, $password, $confirmPassword);
            $_SESSION['response'] = $result;

            if ($result['status']) {
                header('Location: ../html/login.php?success=1');
            } else {
                header('Location: ../html/register.php?error=1');
            }
            exit();
        }

        if ($_POST['action'] == 'login') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            $result = loginUser($email, $password);
            $_SESSION['response'] = $result;

            if ($result['status']) {
                header('Location: ../html/dashboard.php');
            } else {
                header('Location: ../html/login.php?error=1');
            }
            exit();
        }
    }
}
