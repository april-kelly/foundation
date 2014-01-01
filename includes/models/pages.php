<?php
/**
 * Name:        Pages Class
 * Description: Handles code interactions with pages
 * Date:        12/30/13
 * Programmer:  Liam Kelly
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH.'includes/models/pdo.php');
require_once(ABSPATH.'includes/models/debug.php');

class pages{

    //Define class properties

        //Page
        public $page_id;
        public $name;
        public $path;

        //Control
        public $dbc;
        public $debug;


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

        //Setup debugging
        $this->debug = new debug;

    }

    //Lookup a page
    public function lookup($name){

        try{

            //Look up the page being requested
            $query = "SELECT * FROM pages WHERE `name` = :name";
            $handle= $this->dbc->setup($query);
            $pages = $this->dbc->fetch_assoc($handle, array('name' => $name));

            //Make sure there were results
            if(!(empty($pages)) && !($pages == false)){

                //Insert results into object
                $this->page_id = $pages[0]["page_id"];
                $this->name    = $pages[0]["name"];
                $this->path    = $pages[0]["path"];

                //return the first result only
                return $pages[0];

            }else{

                //Nothing to send, return false
                return false;

            }

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Add a page
    public function add_page($name, $path){

        try{

            //Setup Insert
            $query = "INSERT INTO pages VALUES(:page_id, :name, :path)";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                 'page_id' => null,
                 'name'    => $name,
                 'path'    => $path,
            );

            //Run Insert
            $pages = $this->dbc->fetch_assoc($handle, $parameters);

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Change a page
    public function update_page($page_id, $name, $path){

        //Handle empty parameters
        if(empty($name)){

            $name = $this->name;

        }

        if(empty($path)){

            $path = $this->path;

        }

        try{

            //Setup Insert
            $query = "UPDATE pages SET `name` = :name, `path` = :path WHERE `page_id` = :page_id ";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                'page_id' => $page_id,
                'name'    => $name,
                'path'    => $path,
            );

            //Run Insert
            $pages = $this->dbc->fetch_assoc($handle, $parameters);

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Delete a page
    public function delete_page($page_id){

        try{

            //Setup Insert
            $query = "DELETE FROM pages WHERE `page_id` = :page_id";
            $handle= $this->dbc->setup($query);
            $pages = $this->dbc->fetch_assoc($handle, array('page_id' => $page_id));

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);

            }

            //Indicate failure by returning false
            return false;

        }

    }

}