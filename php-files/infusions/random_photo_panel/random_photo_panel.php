<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type: Panel
| Name: Random Photo Panel
| Version: 1.00
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

/* settings */
$side_title = "Foto a Caso";
$num_of_photos = 1;
$album_id = false;
$show_num_of_photos = false;
$show_photo_title = false;
$trim_photo_title = 23;
$show_photo_description = false;

/* functions */
if (!function_exists("rapporto_immagine")) {
	/**
	 * @author max costa (sumotoy.net)
	 * @copyright sumotoy 2008
	 * Input: image, larghezza massima, altezza massima 
	 * out: false (errore) oppure un array con la nuova larghezza e altezza
	 */
	function rapporto_immagine($image,$max_width,$max_height){
		if($max_width > 0 && $max_height > 0 && file_exists($image)){
			$size = @getimagesize($image);
			if (!empty($size[0]) && !empty($size[1])){
				$out = array();
				$rapporto_immagine = $size[1] / $size[0];
				$rapporto_zona = $max_height / $max_width;
				if ($rapporto_immagine < $rapporto_zona){
					$out['w'] = $max_width;
					$out['h'] = round($max_width * $rapporto_immagine);
				} else {
					$out['w'] = round($max_height / $rapporto_immagine);
					$out['h'] = $max_height;
				}   
				return $out;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

/* checks */
$side_title = isset($side_title) && !empty($side_title) ? $side_title : "Foto a Caso";
$num_of_photos = isset($num_of_photos) && ($num_of_photos < 1) ? 1 : $num_of_photos;
$album_id = isset($album_id) && isnum($album_id) ? $album_id : false;
$show_num_of_photos = isset($show_num_of_photos) && is_bool($show_num_of_photos) ? $show_num_of_photos : true;
$show_photo_title = isset($show_photo_title) && is_bool($show_photo_title) ? $show_photo_title : true;
$trim_photo_title = isset($trim_photo_title) && isnum($trim_photo_title) ? $trim_photo_title : 23;
$show_photo_description = isset($show_photo_description) && is_bool($show_photo_description) ? $show_photo_description : false;

$album_clause = isset($album_id) && isnum($album_id) ? "album_id='".$album_id."' AND " : "";

/* panel */
$result = dbquery("SELECT tp.*,ta.* FROM ".DB_PHOTOS." tp
		LEFT JOIN ".DB_PHOTO_ALBUMS." ta USING (album_id) 
		WHERE ".$album_clause.groupaccess('album_access')." 
		ORDER BY RAND() LIMIT ".$num_of_photos."");
$rows = intval(dbrows($result));

if ($rows != 0) {
	//if (!defined("SAFEMODE")) { define("SAFEMODE", @ini_get("safe_mode") ? true : false); }
	$num_of_photos = $rows < $num_of_photos ? $rows : $num_of_photos;
	$side_title = ($show_num_of_photos ? $num_of_photos." " : "").$side_title;
	openside($side_title);
	$i = $rows - 1;
	while ($data = dbarray($result)) {
		//checks
		$space = ($i != 0) ? "<hr />" : "";
		$data['photo_title'] = trimlink($data['photo_title'], $trim_photo_title);
		$photo_dir = PHOTOS.(!@ini_get("safe_mode") ? "album_".$data['album_id']."/" : "");
		//apply watermark
		if ($settings['photo_watermark']) {
			if ($settings['photo_watermark_save']) {
				$parts = explode(".", $data['photo_filename']);
				$wm_file1 = $parts[0]."_w1.".$parts[1];
				$wm_file2 = $parts[0]."_w2.".$parts[1];
				if (!file_exists($photo_dir.$wm_file1)) {
					if ($data['photo_thumb1']) { $photo_thumb = "photo.php?photo_id=".$data['photo_id']; }
					$photo_file = "photo.php?photo_id=".$data['photo_id'];
				} else {
					if ($data['photo_thumb1']) { $photo_thumb = $photo_dir.$wm_file1; }
					$photo_file = $photo_dir.$wm_file2;
				}
			} else {
				if ($data['photo_thumb1']) { $photo_thumb = "photo.php?photo_id=".$data['photo_id']; }
				$photo_file = "photo.php?photo_id=".$data['photo_id'];
			}
		} else {
			$photo_thumb = $data['photo_thumb1'] && file_exists($photo_dir.$data['photo_thumb1']) ? $photo_dir.$data['photo_thumb1'] : "";
			$photo_file = $photo_dir.$data['photo_filename'];
		}
		//showing
		if ($show_photo_title) {
			echo THEME_BULLET." <a href='".BASEDIR."photogallery.php?photo_id=".$data['photo_id']."' title='".$data['photo_title']."' ";
				echo "class='side'>".$data['photo_title']."</a><br />\n";
		}
		$photo = isset($photo_thumb) && !empty($photo_thumb) ? $photo_thumb : $photo_file;	
		$out = rapporto_immagine($photo,$settings['thumb_w'],$settings['thumb_h']); //print_r($out);
		echo "<!-- photo_id:".$data['photo_id']." - photo_title:".$data['photo_title']." - photo_thumb:".$photo." -->\n";
		echo "<a href='".BASEDIR."photogallery.php?photo_id=".$data['photo_id']."' title='".$data['photo_title']."' style='border:0px;'>";
		echo "<img src='".$photo."' width='".$out['w']."' height='".$out['h']."' alt='".$data['photo_filename']."' title='".$data['photo_title']."' ";
			echo "style='border:0px;margin:0 auto;display:block;' class='photogallery_photo' />";
		echo "</a>\n";
		if ($data['photo_description'] && $show_photo_description) {
			echo "<div class='small'>".nl2br(parseubb($data['photo_description'], "b|i|u|center|small|url|mail|img|quote"))."</div>\n";
		}
		echo $space;
		$i--;
	}
	closeside();
}


?>