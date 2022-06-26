<?php
require 'config.php';
require_once 'models/Auth.php';

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken();


require 'partials/header.php';
require 'partials/navbar.php';
require 'partials/sidebar.php';
?>

<?php require 'partials/footer.php'; ?>