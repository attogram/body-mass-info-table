<?php
declare(strict_types = 1);

namespace Attogram\Body;

$autoload = '../vendor/autoload.php';
if (!is_readable($autoload)) {
    die('Vendor autoload file not found.  Please run composer install.');
}
require_once($autoload);

$web = new Web();

$web->route();
