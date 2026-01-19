<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../db/connection.php';

function getUserProfile($userId) {
    $query = "SELECT * FROM users WHERE user_id = $userId";
    return fetchOne($query);
}

function updateUserProfile($userId, $firstName, $lastName, $phone, $address, $city, $postalCode, $country) {
    global $connection;
    
    $firstName = escapeInput($firstName);
    $lastName = escapeInput($lastName);
    $phone = escapeInput($phone);
    $address = escapeInput($address);
    $city = escapeInput($city);
    $postalCode = escapeInput($postalCode);
    $country = escapeInput($country);
    
    $query = "UPDATE users SET 
              first_name = '$firstName',
              last_name = '$lastName',
              phone = '$phone',
              address = '$address',
              city = '$city',
              postal_code = '$postalCode',
              country = '$country'
              WHERE user_id = $userId";
    
    if (executeQuery($query)) {
        return array('status' => true, 'message' => 'Profile updated successfully');
    } else {
        return array('status' => false, 'message' => 'Error updating profile');
    }
}

function changePassword($userId, $currentPassword, $newPassword, $confirmPassword) {
    global $connection;
    
    if ($newPassword !== $confirmPassword) {
        return array('status' => false, 'message' => 'New passwords do not match');
    }
    
    $user = getUserProfile($userId);
    
    if (!password_verify($currentPassword, $user['password'])) {
        return array('status' => false, 'message' => 'Current password is incorrect');
    }
    
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    $query = "UPDATE users SET password = '$hashedPassword' WHERE user_id = $userId";
    
    if (executeQuery($query)) {
        return array('status' => true, 'message' => 'Password changed successfully');
    } else {
        return array('status' => false, 'message' => 'Error changing password');
    }
}

function deleteUserAccount($userId) {
    $query = "DELETE FROM users WHERE user_id = $userId";
    
    if (executeQuery($query)) {
        session_destroy();
        return array('status' => true, 'message' => 'Account deleted successfully');
    } else {
        return array('status' => false, 'message' => 'Error deleting account');
    }
}

?>
