<?php
/**
 * db connection
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
 */
  
$dbconnect = new mysqli($dbhost, $dbuser, $dbpass, $database);
 
if (mysqli_connect_errno())
{
	// do nothing, user will not be authenticated
}