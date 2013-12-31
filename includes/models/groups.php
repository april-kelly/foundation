<?php
/**
 * Name:        Groups
 * Description: Handles the creation and management of groups
 * Date:        12/30/13
 * Programmer:  Liam Kelly
 */

class groups{

    //Define class properties

    //Group
    public $group_id;
    public $name;
    public $descriptions;

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

}