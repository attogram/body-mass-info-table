<?php
declare(strict_types = 1);

namespace Attogram\Body;

?>
<html><head><title>Body Mass Info Chart</title><style type="text/css">
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
    &nbsp;
    <a href="<?= $this->router->getUriBase(); ?>/about/">About</a>
</div>
