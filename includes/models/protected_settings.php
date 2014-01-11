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
 * Name:        Protected Settings
 * Description: Holds settings which are sensitive, such as the salt
 * Date:        11/27/13
 * Programmer:  Liam Kelly
 */

class protected_settings{

    //Define settings
    public $salt               = 'a21fe803207b7c41957d5f9856355038e9168e6ff9ece47f008aade2113f4e657547101ce4c917d27e8a9ddc1d561c20251ba74692dac4f3c612a9a3093f5161'; //Salt for hashing passwords
    public $db_user            = 'root';
    public $db_pass            = 'kd0hdf';
    public $db_host            = 'localhost';
    public $db_name            = 'foundation2';

    //Anonymous user login
    public $anon_user          = 'local';
    public $anon_pass          = 'password';

    //Fetch Settings
    public function fetch(){

        //Return the settings
        return (array) $this;

    }

}