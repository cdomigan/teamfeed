<?php

$data = $_POST['image'];
$user = $_POST['user'];
$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
file_put_contents('/tmp/'.$user.'.png', $image);
