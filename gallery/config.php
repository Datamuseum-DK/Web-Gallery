<?php
/**
 * Config
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
 */


if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
{
    exit;
}

/*
 * Authentication methods: wiki, varnish
 * wiki - MediaWiki - Fill out "MySQL Config"
 * varnish - Varnish proxy - Fill out "Varnish Config"
 */
define("authmethod", "varnish");



// Authentication Config
if (authmethod == "varnish")
{
	// Varnish Config
	define("", $_HTTP['DDHF-UserAuth']);
}
elseif (authmethod == "wiki")
{
	// MySQL Config
	define("dbhost", "localhost");
	define("dbuser", "myuser");
	define("dbpass", "mypass");
	define("database", "database");
}
