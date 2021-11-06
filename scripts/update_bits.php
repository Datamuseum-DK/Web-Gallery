<?php 
/**
 * Metadata updater
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
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




// 123456:1
$bitstoreident = get_metadata_line("BitStore.Ident", $argv[1]);
// remove ident version nr
$bitstoreid = substr($bitstoreident, 0, strpos($bitstoreident, ":"));

system("/usr/local/bin/php -f /root/scripts/extract_bits.php https://datamuseum.dk/wiki/Bits:{$bitstoreid} {$argv[2]}");

