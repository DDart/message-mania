<?php
/*
Plugin Name: Message Mania
Plugin URI: http://cartpauj.icomnow.com/message-mania/
Description: Message Mania is the best Personal/Private Messaging plugin for WordPress - PERIOD!
Version: 1.0.0
Author: Cartpauj
Author URI: http://cartpauj.icomnow.com
Text Domain: mmania
Copyright: 2009-2014, Cartpauj

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//DEFINE PATHS
define('MMANIA_PATH', plugin_dir_path(__FILE__));
define('MMANIA_CLASSES_PATH', MMANIA_PATH.'classes');
define('MMANIA_VIEWS_PATH', MMANIA_PATH.'views');

//DEFINE URLS
define('MMANIA_URL', plugin_dir_url(__FILE__));
define('MMANIA_IMAGES_URL', MMANIA_URL.'images');
define('MMANIA_CSS_URL', MMANIA_URL.'css');
define('MMANIA_JS_URL', MMANIA_URL.'js');

//INCLUDE THE CLASSES
require_once('classes/database.php');
require_once('classes/utils.php');
require_once('classes/helper.php');
require_once('classes/controller.php');

//SETUP GLOBALS
global $mmania_db;
$mmania_db = new MManiaDB();

//LOAD HOOKS
MManiaController::load_hooks();

/* TODO NOTES TO SELF
1 - Right now Read/Unread is not handled in the DB. Putting it in the recipients table seems to be the best option right now, however this will only notify the user of 1 unread message even if that particular thread has had multiple replies since the user last read it. The other option is to add it to the replies table, and create a duplicate reply for each user who is a participant in the thread. This is how Blair does it in Mingle, but it seems really wasteful and redundant.

*/
?>
