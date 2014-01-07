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
    public $message_buffer;

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
        $this->message_buffer[count($this->message_buffer)] = $this->message_buffer.ob_get_contents();
        ob_end_clean();

    }

    //Dump it
    public function dump(){

        //Start output buffering
        ob_start();

        echo '<h1>Debugging Information: </h1>'."\r\n";

        echo '<h3>Message(s): </h3>'."\r\n";

        echo count($this->message_buffer).' Message(s) were reported.<br />'."\r\n";

        $i = 0;
        foreach($this->message_buffer as $message){

            echo '<br />'."\r\n";
            echo 'Message '.$i.': <br />'."\r\n";
            echo $message;
            echo "<br /> \r\n";
            $i++;

            if(!($i == count($this->message_buffer))){

                echo '<hr />';

            }

        }

        echo '<h3>Exception(s): </h3>'."\r\n";

        echo count($this->exception_buffer).' Exception(s) were reported.<br />'."\r\n";

        $i = 0;
        foreach($this->exception_buffer as $exception){

            echo '<br />'."\r\n";
            echo 'Exception '.$i.': <br />'."\r\n";

            //For pdo errors
            if(isset($exception->errorInfo[2])){
                echo $exception->errorInfo[2];
            }


            echo "<br /> \r\n";
            $i++;

            if(!($i == count($this->exception_buffer))){

                echo '<hr />';

            }

        }

        //Uncomment the following to see a dump of the exceptions

        /*
        echo '<pre>'."\r\n";

            var_dump($this->exception_buffer);

        echo '</pre>'."\r\n";
        //*/


        echo '<hr />'."\r\n";

        //End output buffering
        ob_end_flush();

    }

    //Destructor
    public function __destruct(){

        //Cast properties to null
        $this->exception_buffer = null;
        $this->message_buffer     = null;

    }

}