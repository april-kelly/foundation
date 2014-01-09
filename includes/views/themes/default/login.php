<?php

/**
 * Copyright 2014 William Caleb Kelly
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
 * Name:        Login Receiver
 * Description: Receives user login info and logs a user in
 * Date:        1/6/14
 * Programmer:  Liam Kelly
 */

//Setup a session
if(!(isset($_SESSION))){
    session_start();
}

//Includes
if(!(defined('ABSPATH'))){
    require_once('./path.php');
}
require_once(ABSPATH.'includes/models/pdo.php');
require_once(ABSPATH.'includes/models/users.php');

//Setup users class
$users = new users;

//Check a submitted login
if(isset($_REQUEST['username']) && $_REQUEST['password']){

    $user = $users->login($_REQUEST['username'], $_REQUEST['password']);

    if($user == true){

        //Success
        $users->setup_session();

        //Send user to home page
        header('location: ./');

    }else{

        //Failure

        //Send the user back to the login form
        //header('location: '.$_SESSION['last_page']);

        echo 'failed';

    }

}else{

    //User did not send both fieldss
    echo 'Invalid request.';

}

//Logout
if(isset($_REQUEST['logout'])){

    session_destroy();

}