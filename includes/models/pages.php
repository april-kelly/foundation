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

class pages{

    //Define class properties

        //Page
        public $page_id;
        public $name;
        public $path;

        //Control
        public $dbc;


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

    }

    //Lookup a page
    public function lookup($name){


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



    }

    //Add a page
    public function add_page(){

    }

    //Change a page
    public function change_page(){

    }

    //Delete a page
    public function delete_page(){

    }

}