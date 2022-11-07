<?php
declare(strict_types=1);
session_start();
require_once "vendor/autoload.php";
use netvod\db\ConnectionFactory;
use netvod\dispatch\Dispatcher;

ConnectionFactory::setConfig("db.config.ini");

$dispatch = new Dispatcher();
$dispatch->run();
?>