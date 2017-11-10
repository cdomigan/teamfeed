<?php

$user = $_REQUEST['user'];
header('Content-Type: image/png');
readfile("/tmp/{$user}.png");
