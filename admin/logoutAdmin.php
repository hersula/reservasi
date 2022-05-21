<?php
include('../helper/base_url.php');
session_start();
session_destroy();

header("Location: " . BASE_URL . 'admin/');
