<?php
declare(strict_types=1);

$sessionPath = dirname(__DIR__) . '/storage/sessions';

if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0775, true);
}

session_save_path($sessionPath);
session_start();

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (!current_user()) {
        header('Location: login.php');
        exit;
    }
}

function redirect_if_logged_in(): void
{
    if (current_user()) {
        header('Location: dashboard.php');
        exit;
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
