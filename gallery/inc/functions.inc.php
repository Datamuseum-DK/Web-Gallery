<?php
/**
 * Functions
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
 */


if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
{
    exit;
}

require_once("inc/constants.inc.php");


/**
 * Checks if user has permission to view album
 * @author Carsten Jensen
 * @param string $metafile full path to metafile
 * @return bool true if authenticated and permission is good
 */
function check_meta_auth($metafile)
{
	if ($authenticated == true AND get_metadata_line("BitStore.Access", $metafile) == 'private')
	{
		return true;
	}
	elseif (get_metadata_line("BitStore.Access", $metafile) == 'public')
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * Gets next line from metadata file
 * @author Carsten Jensen
 * @param string $search Search for X
 * @param string $file Path of file
 * @return string with contents or false
 */
function get_metadata_line($search, $file) {
	
	$get = false;
	
	if (file_exists($file))
	{
		$fh = fopen($file, 'r');
		while ($line = fgets($fh)) 
		{
			if ($get == true)
			{
				return trim($line);
			}
			else
			{
				if (stripos($line, $search) != false)
				{
					$get = true;
				}
			}
		}
	}
	return false;
}
