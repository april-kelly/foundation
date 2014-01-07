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
 * Name:        launch_system_plugins.php
 * Description: Launches optional plugins
 * Date:        12/29/13
 * Programmer:  Liam Kelly
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

//Scan the hooks dir for plugins
$plugins = scandir(ABSPATH.'/includes/hooks/optional');

//Get rid of the . and ..
unset($plugins[0]);
unset($plugins[1]);

//Start loading plugins
foreach($plugins as $plugin){

    //Ensure this is a php file
    if(pathinfo($plugin, PATHINFO_EXTENSION) == 'php'){

        //Call each plugin hook
        include_once(ABSPATH.'/includes/hooks/optional/'.$plugin);


    }

}