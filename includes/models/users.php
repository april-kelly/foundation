<?php
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
require_once(ABSPATH.'includes/models/data.php');

class users {

    //Define variables

        //User data
            public $index       = null;
            public $firstname   = '';
            public $lastname    = '';
            public $username    = '';
            public $password    = '';
            public $login_count = '0';
            public $last_ip     = '0.0.0.0';
            public $admin       = false;

        //Control variables
            public $debug       = true;

    //Login function
    public function login($username, $password){

        /**
         * This Function logs a user in.
         */

        $this->username = $username;
        $this->password = $password;

        //Setup database connection
        $dbc = new db;
        $dbc->connect();

        //sanitize inputs
        //$this->username = $dbc->sanitize($this->username);
        $this->password = hash('SHA512', $this->password);

        //look for user in database
        $query = "SELECT * FROM users WHERE `username` = '".$this->username."' AND `password` = '".$this->password."'";
        $results = $dbc->query($query);

        //Make sure the database returned good results
        if(isset($results[0][0]['index'])){

            //Count rows returned
            if(count($results) == '1'){
                $this->index       = $results[0][0]['index'];
                $this->firstname   = $results[0][0]['firstname'];
                $this->lastname    = $results[0][0]['lastname'];
                $this->username    = $results[0][0]['username'];
                $this->password    = $results[0][0]['password'];
                $this->login_count = $results[0][0]['login_count'];
                $this->last_ip     = $results[0][0]['last_ip'];
                $this->admin       = $results[0][0]['admin'];

                return true;

            }else{

                //Bad login, return false
                return false;

            }

        }else{

            //Bad login or error message
            return false;

        }

    }

    public function clearance_check($user_id, $group_id){


        //Setup database connection
        $dbc = new db;
        $dbc->connect();

        //Sanitize inputs
        $user_id = $dbc->sanitize($user_id);
        $group_id = $dbc->sanitize($group_id);

        //look for user in database
        $query = "SELECT * FROM  `users-groups` WHERE  `user_id` = '".$user_id."' AND  `group_id` = '".$group_id."'";
        echo $query;
        $results = $dbc->query($query);

        //Make sure the database returned good results
        if(isset($results[0]['user_id'])){

            //Count rows returned
            if(count($results) == '1'){

                //Cleared
                return true;

            }else{

                //SPY!?!
                return false;

            }

        }else{

            //Bad login or error message
            return false;

        }



    }

    //Update function
    public function update(){

        /**
         * This function updates and existing user.
         */

    }

    //Delete function
    public function delete(){

        /**
         * This function deletes a user.
         */

    }

    //Create function
    public function create(){

        /**
         * This Function creates a new user.
         */

    }

}