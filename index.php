<?php
require_once 'config/router.php';

$url = $_GET['url'] ?? '';
route($url);