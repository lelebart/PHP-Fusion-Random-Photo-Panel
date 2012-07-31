+--------------------------------------------------------+
| Type: ...... Panel
| Name: ...... Random Photo Panel
| Version: ... 1.00
| Author: .... Valerio Vendrame (lelebart)
| Released: .. Jan, 26th 2010
| Download: .. http://www.php-fusion.it
+--------------------------------------------------------+
| "rapporto_immagine" function
| @author max costa (sumotoy.net)
| @copyright sumotoy 2008
+--------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------+

	/************************************************\
	
		Table of Contents
		- Description
		- Installation
		- Usage
		- Feature
		- Authors
		- Future Releases
		- Notes for Developers
		
	\************************************************/

+-------------+
| DESCRIPTION |
+-------------+

With this panel you can show how many random photos you wants from your PHP-Fusion's photogallery, or from a particular album.

+--------------+
| INSTALLATION |
+--------------+

1. Upload the 'random_photo_panel' folder to your Infusions folder on your webserver;
2. Go to System Admin -> Panels;
3. Click "Add new panel": 
 3.1. give a significative title,
 3.2. select from the drop-down menu 'random_photo_panel',
 3.3. choose the visibilty,
 3.4. type your administration password and
 3.5. click "Save";
4. Set the order and the side of the panel created right away.


+-------+
| USAGE |
+-------+

Open 'random_photo_panel.php' with your favourite editor (read "Notes for Developers" for more), then set up as your preferences:

	/* settings */
	$side_title = "Foto a Caso";           // Write here the title of the panel
	$num_of_photos = 1;                    // Limit the number of photo showing
	$album_id = false;                     // Give the album id or type false
	$show_num_of_photos = false;           // Choose if show the number of photo (before) the panel's title or not
	$show_photo_title = false;             // Choose if show the title of the photo before the photo thumb or not
	$trim_photo_title = 23;                // Limit the leght of the showed title
	$show_photo_description = false;       // Choose if show description of the photo (if it's not empty) or not

Update the remote file if necessary.
	
	
+----------+
| FEATURES |
+----------+

- Respect album's access
- Paranoic check to show the thumb correctly
- Watermarked -if enabled- thumb
- Very customizable (read "Usage" for more)
+ Compatible with:
  - PHP-Fusion 7.00.xx
  - PHP-Fusion 7.01.xx

  
+---------+
| AUTHORS |
+---------+

 name - website ............................................ | 1.00
-------------------------------------------------------------+------
 Valerio Vendrame (lelebart) - http://www.valeriovendrame.it |  *  

 
+-----------------+
| FUTURE RELEASES |
+-----------------+

+ 1.01 - n/a
 - Administrative settings page (infusion)
 
 
+----------------------+
| NOTES for DEVELOPERS |
+----------------------+

1. Have Fun ;)
2. For Micorsoft Windows users only: Notepad++ rocks! - http://notepad-plus.sourceforge.net/