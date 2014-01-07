<?php

/**
 * Name:        index.php
 * Programmer:  Liam Kelly
 * Description: Handles requests for views.
 * Date:        12/24/13
 */

//Includes
require_once('./path.php');
//require_once(ABSPATH.'includes/models/pdo.php');
require_once(ABSPATH.'includes/models/settings.php');
require_once(ABSPATH.'includes/models/protected_settings.php');
require_once(ABSPATH.'includes/models/users.php');
//require_once(ABSPATH.'includes/models/groups.php');
require_once(ABSPATH.'includes/models/pages.php');
//require_once(ABSPATH.'includes/models/debug.php');

//Start the user's session
if(!(isset($_SESSION))){
    session_start();
}

$_SESSION['user_id'] = 1;

//Setup the non database requiring system classes
//$debug = new debug;
$set   = new settings;
$dbc   = new db;

//Setup up the database dependant classes
$users = new users($dbc);
$pages = new pages($dbc);
//$groups = new groups;

//Fetch the settings
$settings = $set->fetch();

//Get the user's page request
if(isset($_REQUEST['p']) && !(empty($_REQUEST['p']))){
    $request = $_REQUEST['p'];
}else{
    $request = 'home';
}

/*

//Run system plugins
include_once(ABSPATH.'includes/controllers/launch_system_plugins.php');


//Run any optional plugins
if($settings['plugins'] == true){

    include_once(ABSPATH.'includes/controllers/launch_optional_plugins.php');

}
 */
//Look up the page
$page = $pages->lookup($request);

//Check the user's clearance
$auth = $users->clearance_check($_SESSION['user_id'], '1');

//Always allow display (debugging) *REMOVE BEFORE PRODUCTION*
//$auth = true;

//Start output buffering
ob_start();

    //Verify user is cleared to see the requested page
    if($auth == true){

        //Make sure the page's path is valid
        if(isset($page['path']) && file_exists(ABSPATH.'includes/views/themes/'.$settings['theme'].'/'.$page['path'])){

            //Include the requested page
            include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/'.$page['path']);

        }else{

            //Page does not exist or database error

            //Use, the 404 page instead
            include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/errors/404.php');

        }

    }else{

        //DO NOT include the requested page

        //Use, the 403 page instead
        include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/errors/403.php');

    }

//Conclude output buffer
$ob = ob_get_contents();
ob_end_clean();

//Send user the page
echo $ob;