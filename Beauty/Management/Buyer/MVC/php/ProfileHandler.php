<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'AuthController.php';
include_once 'ProfileController.php';

if (!isUserLoggedIn()) {
    header('Location: ../html/login.php');
    exit();
}

$userId = getCurrentUserId();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action == 'update_profile') {
        $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
        $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        $postalCode = isset($_POST['postal_code']) ? trim($_POST['postal_code']) : '';
        $country = isset($_POST['country']) ? trim($_POST['country']) : '';

        $result = updateUserProfile($userId, $firstName, $lastName, $phone, $address, $city, $postalCode, $country);

        if ($result['status']) {
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name'] = $lastName;
            header('Location: ../html/profile.php?tab=info&success=1');
        } else {
            header('Location: ../html/profile.php?tab=info&error=' . urlencode($result['message']));
        }
        exit();
    }

    if ($action == 'change_password') {
        $currentPassword = isset($_POST['current_password']) ? $_POST['current_password'] : '';
        $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        $result = changePassword($userId, $currentPassword, $newPassword, $confirmPassword);

        if ($result['status']) {
            header('Location: ../html/profile.php?tab=password&success=1');
        } else {
            header('Location: ../html/profile.php?tab=password&error=' . urlencode($result['message']));
        }
        exit();
    }

    if ($action == 'delete_account') {
    
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($password)) {
            header('Location: ../html/profile.php?error=Password required to delete account');
            exit();
        }

        
        $user = getUserProfile($userId);
        if (!password_verify($password, $user['password'])) {
            header('Location: ../html/profile.php?error=Incorrect password');
            exit();
        }

        $result = deleteUserAccount($userId);

        if ($result['status']) {
            header('Location: ../html/login.php?deleted=1');
        } else {
            header('Location: ../html/profile.php?error=' . urlencode($result['message']));
        }
        exit();
    }
}

header('Location: ../html/profile.php');
exit();
