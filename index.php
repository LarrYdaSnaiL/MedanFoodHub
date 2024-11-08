<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION["uid"]) {
    $_SESSION['login'] = true;
    header("Location: ./public/");
    exit();
} else {
    $_SESSION['login'] = false;
    header("Location: ./public/");
    exit();
}