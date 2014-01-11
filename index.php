<?php

/**
 * Copyright 2013 William Caleb Kelly
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Name:        index.php
 * Programmer:  Liam Kelly
 * Description: Handles requests for views.
 * Date:        12/24/13
 */

$start_time = microtime(true);

//Includes
require_once('./path.php');
require_once(ABSPATH.'includes/models/settings.php');
require_once(ABSPATH.'includes/models/protected_settings.php');
require_once(ABSPATH.'includes/models/users.php');
require_once(ABSPATH.'includes/models/groups.php');
require_once(ABSPATH.'includes/models/pages.php');
require_once(ABSPATH.'includes/models/debug.php');

//Start the user's session
if(!(isset($_SESSION))){
    session_start();
}

//Setup the non database requiring system classes
$debug = new debug;
$set   = new settings;

//Setup the database
$dbc   = new db;

//Fetch the settings
$settings = $set->fetch();

//Include the theme config
require_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/config/theme_config.php');
$theme  = new theme_config;

//Make sure database connection did not fail
if($dbc->fail == true){

    //It failed, send user to 505 page
    include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/errors/505.php');

}else{


//Setup up the database dependant classes
$users = new users($dbc);
$pages = new pages($dbc);

//Check for login
if(!(isset($_SESSION['user_id']))){

    //User is NOT logged in, use anonymous user instead
    $test = $users->login_anon();
    $users->setup_session();

}

//Get the user's page request
if(isset($_REQUEST['p']) && !(empty($_REQUEST['p']))){
    $request = $_REQUEST['p'];
}else{
    $request = 'home';
}


//Run system plugins
include_once(ABSPATH.'includes/controllers/launch_system_plugins.php');


//Run any optional plugins
if($settings['plugins'] == true){

    include_once(ABSPATH.'includes/controllers/launch_optional_plugins.php');

}


//Look up the page
$page = $pages->lookup($request);

//Check the user's clearance
$auth = $users->clearance_check($_SESSION['user_id'], $page['group_id']);

//Start output buffering
ob_start();

    //Verify user is cleared to see the requested page
    if($auth == true){

        //Make sure the page's path is valid
        if(isset($page['path']) && file_exists(ABSPATH.'includes/views/themes/'.$settings['theme'].'/'.$page['path'])){

            //Include the requested page
            include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/main.template.php');

        }else{

            //Page does not exist or database error

            //Use, the 404 page instead
            include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/errors/404.php');

        }

    }else{

        //DO NOT include the requested page

        //Use, the 404 page instead
        include_once(ABSPATH.'includes/views/themes/'.$settings['theme'].'/errors/404.php');

    }

//Time Debugging
$end_time = microtime(true);
$time = $end_time - $start_time;
echo 'Page built in: '.$time.' sec.';

//Conclude output buffer
$ob = ob_get_contents();
ob_end_clean();

//Send user the page
echo $ob;

//End of db fail test
}