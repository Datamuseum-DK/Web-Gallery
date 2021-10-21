<?php
/**
 * Common Header
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
 */


if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
{
    exit;
}

?>
<!doctype html>
<html>
  <head>
    <meta charset='utf-8'>
    <title title_id=""><?php echo $htmltitle ?></title>
    <link rel="stylesheet" type="text/css" href="style/style.css" />
  </head>
  <body>
  <p class='headerbar'><img class='headerlogo' src='img/ddhf_header.png' alt='DDHF' width='262' height='75'></p>