<?php

/**
 * Copyright 2014 William Caleb Kelly
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
 * Name:        Foundation installer
 * Description: Installs foundation
 * Date:        1/8/14
 * Programmer:  Liam Kelly
 */

//Inlcudes
if(!(defined('ABSPATH'))){

    require_once('../../path.php');

}
require_once(ABSPATH.'includes/models/pdo.php');

function build_tables(){

    //Setup database connection
    $dbc = new db;

    //Make sure connection was a success
    if($dbc->fail == false){

    //Create groups table
    $dbc->query("
    CREATE TABLE IF NOT EXISTS `groups` (
      `group_id` int(11) NOT NULL AUTO_INCREMENT,
      `name` text NOT NULL,
      `description` text NOT NULL,
      PRIMARY KEY (`group_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
    ");


        //Create pages table
        $dbc->query("CREATE TABLE IF NOT EXISTS `pages` (
      `page_id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `path` varchar(255) NOT NULL,
      `div_id` varchar(255) NOT NULL,
      PRIMARY KEY (`page_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
    ");

        //Create pages-groups
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `pages-groups` (
      `page_id` int(11) NOT NULL,
      `group_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    ");

        //Create users table
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `users` (
      `user_id` int(11) NOT NULL AUTO_INCREMENT,
      `firstname` varchar(255) NOT NULL,
      `lastname` varchar(255) NOT NULL,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `login_count` varchar(255) NOT NULL,
      `last_ip` varchar(255) NOT NULL,
      PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
    ");

        //Create users-groups table
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `users-groups` (
      `user_id` int(11) NOT NULL,
      `group_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    ");
        //Setup database connection
        $dbc = new db;

        //Create groups table
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `groups` (
      `group_id` int(11) NOT NULL AUTO_INCREMENT,
      `name` text NOT NULL,
      `description` text NOT NULL,
      PRIMARY KEY (`group_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
    ");

        //Create pages table
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `pages` (
      `page_id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `path` varchar(255) NOT NULL,
      `div_id` varchar(255) NOT NULL,
      PRIMARY KEY (`page_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
    ");

        //Create pages-groups
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `pages-groups` (
      `page_id` int(11) NOT NULL,
      `group_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    ");

        //Create users table
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `users` (
      `user_id` int(11) NOT NULL AUTO_INCREMENT,
      `firstname` varchar(255) NOT NULL,
      `lastname` varchar(255) NOT NULL,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `login_count` varchar(255) NOT NULL,
      `last_ip` varchar(255) NOT NULL,
      PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
    ");

        //Create users-groups table
        $dbc->query("
    CREATE TABLE IF NOT EXISTS `users-groups` (
      `user_id` int(11) NOT NULL,
      `group_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    ");


    }else{

        echo 'The connection to the database failed, please ensure it exists and that your connection credentials are correct.';

    }


}
