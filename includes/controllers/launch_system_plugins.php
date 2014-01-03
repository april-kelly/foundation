<?php
/**
 * Name:        launch_system_plugins.php
 * Description: Launches system plugins
 * Date:        12/29/13
 * Programmer:  Liam Kelly
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

//Scan the hooks dir for plugins
$plugins = scandir(ABSPATH.'/includes/hooks/system');

//Get rid of the . and ..
unset($plugins[0]);
unset($plugins[1]);

//Start loading plugins
foreach($plugins as $plugin){

    //Ensure this is a php file
    if(pathinfo($plugin, PATHINFO_EXTENSION) == 'php'){

        //Call each plugin hook
        include_once(ABSPATH.'/includes/hooks/system/'.$plugin);


    }

}