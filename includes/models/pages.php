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
require_once(ABSPATH.'includes/models/data.php');

class pages{

    //Define class properties

        //Page
        public $page_id;
        public $name;
        public $path;

        //Control
        public $dbc;


    //Constructor
    public function __construct(){

        //Establish a connection with the database
        $this->dbc = new db;
        $this->dbc->connect();

    }

    //Lookup a page
    public function lookup($name){

        //Sanitize inputs
        $request = $this->dbc->sanitize($name);

        //Look up the page being requested
        $query = "SELECT * FROM pages WHERE `name` = '".$request."'";
        $pages = $this->dbc->query($query);

        //Force loading of the first result
        return $pages[0];

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