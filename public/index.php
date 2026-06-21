<?php
require_once dirname(__DIR__) . '/app/auth.php';

if (current_user()) {
    header('Location: dashboard.php');
    exit;
}

header('Location: login.php');
exit;
