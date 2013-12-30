<?php
/**
 * Name:        Settings
 * Description: Saves application settings
 * Date:        11/27/13
 * Programmer:  Liam Kelly
 */

if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

class settings {

    //About (put your product's info here)
    public $product_name                            =   '';   //Your product name here
    public $version                                 =   '';   //Your version here
    public $version_type                            =   '';   //Your version type here

    //About Foundation Framework
    public $foundation_product_name                 =   'Foundation Framework';    //Defines the name of the foundation framework
    public $foundation_version                      =   '0.0.1';                   //Defines the foundation framework version
    public $foundation_version_type                 =   'pre-alpha';               //Defines the foundation type of release alpha, beta etc

    //Settings Definitions
    public $settings_path                           =   '';                        //Defines where the settings are stored (defined in the constructor)
    public $settings_filename                       =   'settings.json';           //Name of the settings save file

    //General Settings
    public $mlp                                     =   "\x61\x77\x65\x73\x6F\x6d\x65";   //Deal with it, ponies are awesome
    public $ponify                                  =   false;                     //Ponifys the application if implemented
    public $theme                                   =   'default';                 //Sets the theme
    public $plugins                                 =   true;                      //Enables optional plugins

    //Constructor
    public function __construct(){

        //Define where the settings file is
        $this->settings_path =  ABSPATH.'includes/data/'.$this->settings_filename;

        //Make sure the settings file exists
        if(!(file_exists($this->settings_path))){

            //The file does not exist, create it
            file_put_contents($this->settings_path, '');

        }

         //Handle any necessary updates to the settings file

         //Get the current settings
         $current_settings = (array) $this;

          //Get the file's version
          $settings_file = $this->fetch();

          //Check for difference
          if(!($current_settings == $settings_file)){

              //Settings file is out of date, update it
              $this->update($current_settings);

          }



    }

    //Fetch settings
    public function fetch(){

        //Read the settings file
        $file_contents = file_get_contents($this->settings_path);

        //Decode the results
        if(!(empty($file_contents))){

            $settings = json_decode($file_contents);

        }else{

            //There is nothing to fetch so return false
            return false;

        }

        //Return the results, as an array
        return (array) $settings;

    }

    //Update settings
    public function update($settings){

        //Encode the settings
        $file_contents = json_encode($settings);

        //Write the settings
        file_put_contents($this->settings_path, $file_contents);


    }

}