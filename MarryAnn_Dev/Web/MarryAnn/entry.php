<?php

$data = json_encode($_GET);
setcookie("fb_sig", $data, time() + 10, "/");
header("Location: /SS/");

/* End of file index.php */
/* Location: ./index.php */