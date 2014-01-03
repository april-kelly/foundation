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
require_once(ABSPATH.'includes/models/pdo.php');
require_once(ABSPATH.'includes/models/debug.php');

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

        //Control variables
            public $debug       = true;
            public $dbc         = null;

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

    }

    //Login function
    public function login($username, $password){

        /**
         * This Function logs a user in.
         */

        $this->username = $username;
        $this->password = $password;

        //sanitize inputs
        //$this->username = $this->dbc->sanitize($this->username);
        $this->password = hash('SHA512', $this->password);

        //look for user in database
        $query = "SELECT * FROM users WHERE `username` = '".$this->username."' AND `password` = '".$this->password."'";
        $results = $this->dbc->query($query);

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

        //Sanitize inputs
        $user_id  = $this->dbc->sanitize($user_id);
        $group_id = $this->dbc->sanitize($group_id);

        //look for user in database
        $query = "SELECT * FROM  `users-groups` WHERE  `user_id` = '".$user_id."' AND  `group_id` = '".$group_id."'";
        echo $query;
        $results = $this->dbc->query($query);

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
                'password'     => $password,
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

}