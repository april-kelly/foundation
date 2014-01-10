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
 * Name:        CloudBurst pdo based crud
 * Description: Handles requests for the database
 * Date:        11/16/13
 * Programmer:  Liam Kelly
 */

//Includes
require_once(ABSPATH.'includes/models/debug.php');
require_once(ABSPATH.'includes/models/protected_settings.php');

class db{

    //Login
    public $db_name = '';
    public $db_host = '';
    public $db_user = '';
    public $db_pass = '';

    //Control
    public $dbc = '';
    public $results = '';
    public $fail = false;
    public $prepared = false;
    public $errors = '';
    public $debug;
    public $settings;

    public function __construct(){

        //Setup the settings
        $set = new protected_settings();
        $this->settings = $set->fetch();

        //Setup Debugging
        $this->debug = new debug;

        //Setup the database credentials
        $this->db_name = $this->settings['db_name'];
        $this->db_host = $this->settings['db_host'];
        $this->db_user = $this->settings['db_user'];
        $this->db_pass = $this->settings['db_pass'];

        //Connect to the database
        $status = $this->connect();

        //If connection failed
        if($status == false){

            return false;

        }else{

            return true;

        }

    }

    public function connect(){

        //Attempt to connect to the database
        try {

            $this->dbc = new PDO('mysql:host=localhost;dbname='.$this->db_name, $this->db_user, $this->db_pass);
            $this->dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){

            if(!(is_object($e))){

                //Connection to db failed
                $this->fail = true;
                return false;
            }

            $this->errors = $this->errors."\r\n".$e->getMessage();
            $this->fail = true;

            //Foundation debugging
            $this->debug->add_exception($e);
            $this->debug->add_message('Connection to database has failed.');

        }

    }

    public function sanitize($data){

        //Make sure we have not failed
        if($this->fail == false){

            return $this->dbc->quote($data);

        }else{

            return false;

        }

    }

    public function insert($query){

        /**
         * Name:        insert
         * Description: for compatibility with data.php (will be deprecated)
         */

        $this->query($query);

    }

    public function query($query){

        //Make sure we have not failed
        if($this->fail == false){

            //Attempt to query the database
            try{

                $this->results =  $this->dbc->query($query);

            }catch(PDOException $e){

                $this->errors = $this->errors.$e->getMessage();
                $this->fail = true;

                //Foundation debugging
                $this->debug->add_exception($e);
                $this->debug->add_message('Query to the database has failed.');


            }

            if($this->fail == false){

                if(is_object($this->results)){

                    while($row = $this->results->fetchALL()) {	//fetch assoc array
                        $array[] = $row;
                    }

                }else{

                    return false;

                }

                if(!(empty($array))){

                    return $array;	//return results

                }else{

                    return false;

                }

            }else{

                return false;

            }

        }else{

            return false;

        }

    }

    public function execute($handle, $array){

        //Make sure a prepared statement has been defined
        if($this->prepared == true){

            //Make sure we have not failed
            if($this->fail == false){

                //Attempt to execute
                try{

                    $handle->execute($array);

                }catch(PDOException $e){

                    $this->errors = $this->errors.$e->getMessage();
                    $this->fail = true;

                    //Foundation debugging
                    $this->debug->add_exception($e);
                    $this->debug->add_message('Excution of prepare statement has failed.');

                }

                //Check for failure
                if($this->fail == false){

                    if(is_object($handle)){

                        while($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                            $array[] = $row;
                        }


                        return $array;	//return results

                    }else{

                        return false;

                    }

                }else{

                    return false;

                }

            }else{

                return false;

            }

        }else{

            return false;

        }

    }

    //Prepared statements
    public function prepare_media(){

        //Make sure we have not failed
        if($this->fail == false){

            //Prepare the query
            $handle = $this->dbc->prepare('SELECT * FROM `cloudburst`.`media` WHERE `index` = :id');

            //Let the excute function know that we have defined a query
            $this->prepared = true;

            //Return the handle
            return $handle;

        }else{

            //We failed earlier so return false
            return false;

        }

    }

    public function setup($query){

        //Make sure we have not failed
        if($this->fail == false){

            //Prepare the query
            $handle = $this->dbc->prepare($query);

            //Let the excute function know that we have defined a query
            $this->prepared = true;

            //Return the handle
            return $handle;

        }else{

            //We failed earlier so return false
            return false;

        }

    }

    public function fetch_assoc($handle, $parameters){

        //Ensure the user has sent everything
        if(isset($handle, $parameters) && is_object($handle)){

            $handle->execute($parameters);

            while($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }

            if(isset($array)){

                return $array;

            }else{

                return false;

            }

        }else{

            return false;

        }

    }

    public function close(){

        //Make sure we have not failed
        if($this->fail == false){

            //Destroy the connection
            $this->dbc = null;

            //Return
            return true;

        }else{

            //We can't close so, return false
            return false;

        }

    }

    public function get_errors(){

        /**
         * Name:         get_errors
         * Description:  Echos out any error messages saved in $this->errors
         */

        //Check for errors
        if(!(empty($this->errors))){

            //Spit out any error messages
            echo "<br />".$this->errors."<br />";

        }

    }

    public function __destruct(){

        /**
         * Name:        __destruct
         * Description: Closes the database connection on destruct.
         */

        //Destroy the database connection
        $this->close();

    }

}
