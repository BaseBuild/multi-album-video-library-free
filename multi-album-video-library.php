<?php
/*
Plugin Name: Multi Album Video Library
Description: This plugin allows you to display and navigate your albums and videos from video-sharing websites.
Author: Basebuild, Inc.
Version: 0.1.0
Author URI: http://www.basebuildguys.com/
*/

require("init.php"); // Settings and Assets
require("vimeo/autoload.php"); // Vimeo API
require("includes/view.php"); // Front-End Display
require("includes/controller.php"); // Back-End Controller
require("includes/admin-menu.php"); // Vimeo Albums Menu and Settings Page

?>