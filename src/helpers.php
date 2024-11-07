<?php
function redirect($url) {
    header("Location: " . BASE_URL . '/' . $url);
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function flashMessage($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($message)) {
        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
    } elseif (!empty($_SESSION[$name])) {
        echo '<div class="' . $_SESSION[$name . '_class'] . '">' . $_SESSION[$name] . '</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
    }
}
