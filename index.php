<?php

/**
 * Name:        index.php
 * Programmer:  Liam Kelly
 * Description: Handles requests for views.
 * Date:        12/24/13
 */

//Includes
require_once('./path.php');
require_once(ABSPATH.'includes/models/settings.php');
require_once(ABSPATH.'includes/models/data.php');

//Start the user's session
if(!(isset($_SESSION))){
    session_start();
}

//Fetch the settings
$set = new settings;
$settings = $set->fetch();

//Get the user's page request
if(isset($_REQUEST['p'])){
    $request = $_REQUEST['p'];
}else{
    $request = 'home';
}

//Run any optional plugins

/**
 * The run plugins feature has not been implemented yet
 * @TODO add run plugins support
 */

//Establish a connection with the database
$dbc = new db;
$dbc->connect();

//Sanitize inputs
$request = $dbc->sanitize($request);

//Look up the page being requested
$query = "SELECT * FROM pages WHERE `name` = '".$request."'";
$pages = $dbc->query($query);
var_dump($pages);

//Force loading of the first result
$page = $pages[0];

//Include the page
include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/menus/status.php');
