<?php
declare(strict_types = 1);

namespace Attogram\Body;

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Body Mass Info Chart</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
body { 
    background-color:white;
    color:black; 
    font-family:monospace;
    font-size:110%;
    margin:0;
    padding:0;
}
a {
    background-color:#ddeeff;
    color:black;
    padding:1px;
    text-decoration:none;
}
a:hover {
    background-color:yellow;
    color:black;
}
.hdr {
    font-weight:bold; 
    padding:10px; 
}
.bw {
    background-color:lightseagreen;
    color:black;
}
.bold {
    font-weight:bold;
}
.error {
    background-color:black;
    border:1px solid red;
    color:yellow;
    padding:0 4px 0 4px;
}
form {
    padding:14px;
    margin:0;
}
table, tr, td {
    border:1px solid black;
    border-collapse:collapse;
    margin:20px;
    padding:2px 8px 2px 8px;
}
</style></head><body>
<div class="hdr bw">
    <a href="<?= $this->router->getUriBase(); ?>/">Body Mass Info Chart</a>
    &nbsp; <a href="<?= $this->router->getUriBase(); ?>/about/">About</a>
</div>
