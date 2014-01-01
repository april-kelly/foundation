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
    public $description;

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

        //Setup debugging
        $this->debug = new debug;

    }

    //Lookup a group
    public function lookup($group_id){

        try{

            //Look up the group being requested
            $query = "SELECT * FROM groups WHERE `group_id` = :group_id";
            $handle= $this->dbc->setup($query);
            $groups = $this->dbc->fetch_assoc($handle, array('group_id' => $group_id));

            //Make sure there were results
            if(!(empty($groups)) && !($groups == false)){

                //Insert results into object
                $this->group_id       = $groups[0]["group_id"];
                $this->name           = $groups[0]["name"];
                $this->description    = $groups[0]["description"];

                //return the first result only
                return $groups[0];

            }else{

                //Nothing to send, return false
                return false;

            }

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_exception('An error was encountered in the groups class, add_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Add a group
    public function add_group($name, $description){

        try{

            //Setup Insert
            $query = "INSERT INTO groups VALUES(:group_id, :name, :description)";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                'group_id'       => null,
                'name'           => $name,
                'description'    => $description,
            );

            //Run Insert
            $groups = $this->dbc->fetch_assoc($handle, $parameters);

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_exception('An error was encountered in the groups class, add_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Change a group
    public function update_group($group_id, $name, $description){

        //Handle empty parameters
        if(empty($name)){

            $name = $this->name;

        }

        if(empty($description)){

            $description = $this->description;

        }

        try{

            //Setup Insert
            $query = "UPDATE groups SET `name` = :name, `description` = :description WHERE `group_id` = :group_id ";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                'group_id'       => $group_id,
                'name'           => $name,
                'description'    => $description,
            );

            //Run Insert
            $groups = $this->dbc->fetch_assoc($handle, $parameters);

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_exception('An error was encountered in the groups class, update_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Delete a group
    public function delete_group($group_id){

        try{

            //Setup Insert
            $query = "DELETE FROM groups WHERE `group_id` = :group_id";
            $handle= $this->dbc->setup($query);
            $groups = $this->dbc->fetch_assoc($handle, array('group_id' => $group_id));

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the groups class, delete_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

}