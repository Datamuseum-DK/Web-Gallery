<?php 
/**
 * Main Page
 * Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
 * Author: Carsten Jensen
 */

// TODO check i18n on browser and select lang
$version = "v1.2.1beta";

require_once("inc/functions.inc.php");
require_once("inc/auth.inc.php");

$page = (isset($_GET['page']) ? trim($_GET['page']) : false);
$pic = (isset($_GET['img']) ? trim($_GET['img']) : false);


if ($page === false)
{
	// Show Front/Index/Album Page
	
	$htmltitle = "DDHF Galleri oversigt";
	
	$html = "<table class='center'>";
	$html .= "<tr><th>Katalog</th><th>Aktivitet</th></tr>\n";

	foreach (glob("gallery/*", GLOB_ONLYDIR) as $gallery) 
	{
		$metafile = $gallery . DIRECTORY_SEPARATOR . "metadata.meta";
		if (check_meta_auth($metafile))
		{
			$html .= "<tr>";
			$html .= "<td class='right katalog'><a class='button' href='index.php?page=" . substr($gallery, 8) . "'>" . substr($gallery, 8) . "</a></td><td class='left katalog'>";
			$html .= get_metadata_line("Event.Title", $metafile);
			$html .= "</td></tr>\n";
		}
	}
	$html .= "</table>\n";
}
else if (is_dir("gallery" . DIRECTORY_SEPARATOR . $page) && $pic !== false)
{
	// Show single image from album
	
	$currentgallerypath = "gallery" . DIRECTORY_SEPARATOR . $page;
	$metafile = $currentgallerypath . DIRECTORY_SEPARATOR . "metadata.meta";
	
	if (check_meta_auth($metafile) === true)
	{
		$img = $currentgallerypath . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $pic;	
		$htmltitle = get_metadata_line("Event.Title", $metafile) . " [" . $page . "]";
		
		$html = "<a class='button navbutton' href='index.php?page=" . $page . "'>&laquo; Tilbage</a>\n";
		$html .= "<a class='button navbutton' href='index.php'>Hovedmenu</a>\n";

		// 123456:1
		$bitstoreident = get_metadata_line("BitStore.Ident", $metafile);
		// remove ident version nr
		$bitstoreid = substr($bitstoreident, 0, strpos($bitstoreident, ":"));
		$html .= "<a class='button navbutton' href='".WIKIBITS."{$bitstoreid}' target='_blank'>Bitarkivet</a>\n";
		$html .= "<table class='center'>";
		$html .= "<tr><th>";
		$html .= get_metadata_line("Event.Title", $metafile);

		$html .= "</th></tr>";
		$comment = get_metadata_line(basename($pic), $metafile);
		
		if (stripos($img, 'jpg') !== false)
		{
			$html .= "<tr><td><img class='feature' src='" . $img . "' alt='" . $comment . "'></td></tr>\n";
		}
		elseif (stripos($img, 'mp4') !== false)
		{
			$html .= "<tr><td><video width='1024' height='768' controls><source src='{$img}' type='video/mp4'>Your browser does not support video</video> </td></tr>\n";
		}
		
		$html .= "<tr><td class='comment'>" . $comment . "</td></tr>\n";
		$html .= "</table>";
		
		// Previous/Next Image
		$images = glob($currentgallerypath . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "*.{[jJ][pP][gG],[mM][pP][4]}", GLOB_BRACE);
		
		$imagecount = count($images);
		$currentimage = array_search($img, $images);
		
		$previousimage = ($currentimage > 0 ? $currentimage - 1 : false);
		$nextimage = ($currentimage < $imagecount - 1 ? $currentimage + 1 : false);
		
		if ($previousimage !== false) 
		{
			$html .= "<a class='btnprevious round' href='index.php?page=" . $page . "&amp;img=". basename($images[$previousimage]) . "' accesskey='o'>&#8249;</a>";
		}
		if ($nextimage !== false)
		{
			$html .= "<a class='btnnext round' href='index.php?page=" . $page . "&amp;img=". basename($images[$nextimage]) . "' accesskey='p'>&#8250;</a>";
		}
	}
	else 
	{
		header("Location: index.php");
		exit;
	}
}
else if (is_dir("gallery" . DIRECTORY_SEPARATOR . $page = $_GET['page']))
{
	// Show full album
	
	$currentgallerypath = "gallery" . DIRECTORY_SEPARATOR . $page;
	$metafile = $currentgallerypath . DIRECTORY_SEPARATOR . "metadata.meta";
	
	if (check_meta_auth($metafile) === true)
	{
		$eventtitle = get_metadata_line("Event.Title", $metafile);
		$htmltitle = $eventtitle . " [" . $page . "]";
		
		// 123456:1
		$bitstoreident = get_metadata_line("BitStore.Ident", $metafile);
		// remove ident version nr
		$bitstoreid = substr($bitstoreident, 0, strpos($bitstoreident, ":"));

		$html = "<a class='button navbutton' href='index.php'>Hovedmenu</a>\n";
		$html .= "<a class='button navbutton' href='".WIKIBITS."{$bitstoreid}' target='_blank'>Bitarkivet</a>\n";
		$html .= "<table class='center'>";
		$html .= "<tr><th>";
		$html .= $eventtitle;
		$html .= "</th></tr>\n";
		
		foreach (glob($currentgallerypath . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "*.{[jJ][pP][gG],[mM][pP][4]}", GLOB_BRACE) as $img)
		{
			$comment = get_metadata_line(basename($img), $metafile);
			if (stripos($img, 'jpg') !== false)
			{
				$html .= "<tr><td><a href='index.php?page=" . $page . "&amp;img=" . basename($img) . "'><img class='feature' src='" . $img . "' alt='" . $comment . "'></a></td></tr>\n";
			}
			elseif (strpos($img, 'mp4') !== false)
			{
				$html .= "<tr><td><video width='1024' height='768' controls><source src='{$img}' type='video/mp4'>Your browser does not support video</video> </td></tr>\n";
				$html .= "<tr><td><a href='index.php?page=" . $page . "&amp;img=" . basename($img) . "'>" . basename($img) . " - Video</a></td></tr>\n";
			}		
			$html .= "<tr><td class='comment'>" . $comment . "</td></tr>\n";
		}
		$html .= "</table>\n";
	}
	else 
	{
		header("Location: index.php");
		exit;
	}
}	
else
{
	// There's nothing to see move along
	require_once("inc/htmlheader.inc.php");
	$html = "<a class='button' href='index.php'>Hovedmenu</a>\n";
	$html .= "<p class='center'>Kataloget eksisterer ikke</p>";
}

require_once("inc/htmlheader.inc.php");
echo $html;
require_once('inc/htmlfooter.inc.php');
