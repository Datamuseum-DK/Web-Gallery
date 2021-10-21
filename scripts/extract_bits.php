<?php 
/**
 * Metadata fetcher
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
 */


$htmlcontent = file_get_contents($argv[1]);

preg_match('/<pre>(.*?)<\/pre>/s', $htmlcontent, $match);
$lines = explode(PHP_EOL, $match[1]);

$found = false;

foreach ($lines as $line)
{
	if ($found == true)
	{
		 $path = basename(trim(strtolower($line)), ".zip");
		 $found = false;
		 break;
	}
	elseif (strpos($line, "BitStore.Filename"))
	{
		$found = true;
	}
} 
file_put_contents($path . DIRECTORY_SEPARATOR . "metadata.meta", $match[1]);
