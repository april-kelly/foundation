<?php
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

    //Call each plugin hook
    include_once(ABSPATH.'/includes/hooks/optional/'.$plugin);

}