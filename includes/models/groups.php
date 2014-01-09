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
                $this->debug->add_message('An error was encountered in the groups class, lookup() function.');

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
                $this->debug->add_message('An error was encountered in the groups class, add_group() function.');

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
                $this->debug->add_message('An error was encountered in the groups class, update_group() function.');

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


    //Add a user to a group
    public function add_user_into_group($user_id, $group_id){

        try{

            //Setup Insert
            $query = "INSERT INTO `users-groups` VALUES(:user_id, :group_id)";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                'user_id'        => $user_id,
                'group_id'       => $group_id,
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
                $this->debug->add_message('An error was encountered in the groups class, add_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Remove a user from a group
    public function delete_user_from_group($user_id){

        try{

            //Setup Insert
            $query = "DELETE FROM `users-groups` WHERE `user_id` = :user_id";
            $handle= $this->dbc->setup($query);
            $users = $this->dbc->fetch_assoc($handle, array('user_id' => $user_id));

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the groups class, delete_user_from_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

    //Remove a page from a group
    public function delete_page_from_group($page_id){

        try{

            //Setup Insert
            $query = "DELETE FROM `pages-groups` WHERE `page_id` = :page_id";
            $handle= $this->dbc->setup($query);
            $pages = $this->dbc->fetch_assoc($handle, array('page_id' => $page_id));

            //If everything worked, let's return true
            return true;

        }catch(PDOException $e){

            //Ok, something went wrong, let's handle it

            //Let the debugger now about this (if enabled)
            if(isset($settings['debug']) && $settings["debug"] == true){

                $this->debug->add_exception($e);
                $this->debug->add_message('An error was encountered in the groups class, delete_page_from_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }



    //Add a page to a group
    public function add_page_into_group($page_id, $group_id){

        try{

            //Setup Insert
            $query = "INSERT INTO `pages-groups` VALUES(:page_id, :group_id)";
            $handle= $this->dbc->setup($query);

            //Define Parameters
            $parameters = array(
                'page_id'        => $page_id,
                'group_id'       => $group_id,
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
                $this->debug->add_message('An error was encountered in the groups class, add_group() function.');

            }

            //Indicate failure by returning false
            return false;

        }

    }

}