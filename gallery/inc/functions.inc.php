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



