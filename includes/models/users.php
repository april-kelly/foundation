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
 * Name:        User Abstraction Layer
 * Description: Creates an abstraction between the database and user data
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH.'includes/models/pdo.php');
require_once(ABSPATH.'includes/models/debug.php');
require_once(ABSPATH.'includes/models/protected_settings.php');

class users {

    //Define variables

        //User data
            public $user_id       = null;
            public $firstname   = '';
            public $lastname    = '';
            public $username    = '';
            public $password    = '';
            public $login_count = '0';
            public $last_ip     = '0.0.0.0';

        //Control variables
            public $debug       = true;
            public $dbc;
            public $protected_settings;

    //Constructor
    public function __construct($dbc = null){

        //Check to see if we have been passed a database object to use
        if(!(is_null($dbc))){

            //Object passed
            $this->dbc = $dbc;

        }else{

            //No Object Passed
            $this->dbc = new db;
            $this->dbc->connect();

        }

        //Setup Debugging
        $this->debug = new debug;

        //Setup Protected Settings
        $this->protected_settings = new protected_settings;

    }

    //Login anonymous user
    public function login_anon(){

        return $this->login($this->protected_settings->anon_user, $this->protected_settings->anon_pass);

    }

    public function setup_session(){

        //Start the user's session
        if(!(isset($_SESSION))){
            session_start();
        }

        $_SESSION['user_id'] = $this->user_id;
        $_SESSION['name']    = $this->firstname;

    }

    //Login function
    public function login($username, $password){

        try{

            //Look up the user being requested
            $query = "SELECT * FROM  `users` WHERE  `username` =  :username AND `password` =  :password";
            $handle= $this->dbc->setup($query);
            $users = $this->dbc->fetch_assoc($handle, array(
                'username' => $username,
                'password' => hash('SHA512', $password.$this->protected_settings->salt)
            ));


            //Make sure there were results
            if(!(empty($users)) && !($users == false)){

                //Count rows returned
                if(count($users) == '1'){

                    $this->user_id     = $users[0]['user_id'];
                    $this->firstname   = $users[0]['firstname'];
                    $this->lastname    = $users[0]['lastname'];
                    $this->username    = $users[0]['username'];
                    $this->password    = $users[0]['password'];
                    $this->login_count = $users[0]['login_count'];
                    $this->last_ip     = $users[0]['last_ip'];


                    return true;

                }else{

                    //Bad login, return false
                    return false;

                }

            }else{

                //Nothing to send, return false
                return false;

            }

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the users class, add_user() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Check user clearance
    public function clearance_check($user_id, $group_id){


        try{

            //Look up the user being requested
            $query = "SELECT * FROM  `users-groups` WHERE  `user_id` =  :user_id AND  `group_id` =  :group_id";
            $handle= $this->dbc->setup($query);
            $users = $this->dbc->fetch_assoc($handle, array('user_id' => $user_id, 'group_id' => $group_id));

            //Make sure there were results
            if(!(empty($users)) && !($users == false)){

                //User checked out
                return true;

            }else{

                //Nothing to send, return false
                return false;

            }

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the users class, add_user() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Lookup a user
    public function lookup($user_id){

        try{

            //Look up the user being requested
            $query = "SELECT * FROM users WHERE `user_id` = :user_id";
            $handle= $this->dbc->setup($query);
            $users = $this->dbc->fetch_assoc($handle, array('user_id' => $user_id));

            //Make sure there were results
            if(!(empty($users)) && !($users == false)){

                //Insert results into object
                $this->user_id      = $users[0]["user_id"];
                $this->firstname    = $users[0]["firstname"];
                $this->lastname     = $users[0]["lastname"];
                $this->username     = $users[0]["username"];
                $this->password     = $users[0]["password"];
                $this->login_count  = $users[0]["login_count"];
                $this->last_ip      = $users[0]["last_ip"];

                //return the first result only
                return $users[0];

            }else{

                //Nothing to send, return false
                return false;

            }

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the users class, add_user() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Add a user
    public function add_user($firstname, $lastname, $username, $password, $login_count, $last_ip){

        try{

            //Setup Insert
            $query = "INSERT INTO `users` VALUES(:user_id, :firstname, :lastname, :username, :password, :login_count, :last_ip)";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                'user_id'      => null,
                'firstname'    => $firstname,
                'lastname'     => $lastname,
                'username'     => $username,
                'password'     => hash('SHA512', $password.$this->protected_settings->salt),
                'login_count'  => $login_count,
                'last_ip'      => $last_ip,
            );

            //Run Insert
            $users = $this->dbc->fetch_assoc($handle, $parameters);

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the users class, add_user() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Update a user
    public function update_user($user_id, $firstname, $lastname, $username, $password, $login_count, $last_ip){

        try{

            //Setup Insert
            $query = "UPDATE `users` SET `firstname` = :firstname, `lastname` = :lastname, `username` = :username, `password` = :password, `login_count` = :login_count, `last_ip` = :last_ip WHERE `user_id` = :user_id";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                'user_id'      => $user_id,
                'firstname'    => $firstname,
                'lastname'     => $lastname,
                'username'     => $username,
                'password'     => hash('SHA512', $password.$this->protected_settings->salt),
                'login_count'  => $login_count,
                'last_ip'      => $last_ip,
            );

            //Run Insert
            $users = $this->dbc->fetch_assoc($handle, $parameters);

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the users class, add_user() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Delete a user
    public function delete_user($user_id){

        try{

            //Setup Insert
            $query = "DELETE FROM users WHERE `user_id` = :user_id";
            $handle= $this->dbc->setup($query);
            $users = $this->dbc->fetch_assoc($handle, array('user_id' => $user_id));

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the users class, delete_user() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

}