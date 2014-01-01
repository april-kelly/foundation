<?php

 /**
 * Name:        Debug Tools
 * Description: Handles debug output and catches errors
 * Date:        12/31/13
 * Programmer:  Liam Kelly
 */

class debug{

    //Object Properties
    public $exception_buffer;
    public $debug_buffer;

    //Constructor
    public function __construct(){

    }

    //Add an exception
    public function add_exception($exception){

        $this->exception_buffer[count($this->exception_buffer)] = $exception;

    }

    //Add a debug message
    public function add_message($message){

        //Start output buffering
        ob_start();

        //Add the message

        echo '<pre>';
        echo $message;
        echo '</pre>';

        echo '<hr />';

        //End output buffering
        $this->debug_buffer = $this->debug_buffer.ob_get_flush();

    }

    //Destructor
    public function __destruct(){

        //Cast properties to null
        $this->exception_buffer = null;
        $this->debug_buffer     = null;

    }

}