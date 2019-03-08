<html><head><title>BMI Chart</title><style type="text/css">
body { 
    background-color: lightgrey;
    color:black; 
    font-family:monospace;
    font-size:125%;
    margin:0;
}
a {
    background-color:black;
    color:yellow;
}
.hdr {
    font-weight:bold; 
    padding:10px; 
}
.bw {
    background-color:black; 
    color:yellow;
}
.widediv {
    margin:0;
    padding:0;
    width:100%;
}
form {
    background-color:lightyellow;
    padding:14px;
    margin:0;
}
table, tr, td {
    border:1px solid black;
    border-collapse:collapse;
    margin:0;
    padding:2px 8px 2px 8px;
}
</style></head><body>
<div class="hdr bw">
    <a href="<?= $this->router->getUriBase(); ?>/">BMI Chart</a>
    <small>- Body Mass Index for your height, age and sex</small>
</div>
