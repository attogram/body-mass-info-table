<?php
declare(strict_types = 1);

namespace Attogram\Body;

header('HTTP/1.0 404 Not Found');

$this->includeTemplate('header');

?>
<h1 class="alert alert-danger">
    404 Page Not Found
</h1>
<?php

$this->includeTemplate('footer');
