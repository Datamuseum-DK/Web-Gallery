<?php
/**
 * Wiki Authentication Module
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
 */
 
require_once("../config.php");
$authenticated = false;


if (authmethod == 'varnish')
{
	$HTML_HEADERS = getallheaders();
	if ($HTML_HEADERS('DDHF_AUTH') == 'private')
	{
		$authenticated = true;
	}
}
elseif (authmethod == 'wiki')
{
	require_once("db.inc.php");
	if (isset($_COOKIE['wikidbUserID']) AND isset($_COOKIE['wikidbUserName']) AND isset($_COOKIE['wikidbToken']))
	{
		$stmt = $conn->prepare("
			SELECT user_id 
			FROM user
			WHERE
				`user_id` = '?'
			AND
				`user_name` = '?' 
			AND
				`user_token` = '?'
			LIMIT 1
		");
		
		$stmt->bind_param("sss", {$_COOKIE['wikidbUserID']}, {$_COOKIE['wikidbUserName']}, {$_COOKIE['wikidbUserID']});
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows > 0)
		{
			$authenticated = true;
		}
	}
}