<?php

$env = parse_ini_file('../.env');

$host = $env['DB_HOST'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];
$db = $env['DB_NAME'];

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");

