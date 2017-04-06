<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Minichat\Utils\Spdo;
use Minichat\Utils\User;

session_destroy();

echo "Vous avez été déconnecter";

include(__DIR__ .'/Forms/login_form.php');
include(__DIR__ .'/Forms/register_form.php');