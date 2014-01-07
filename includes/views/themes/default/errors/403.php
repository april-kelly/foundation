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
 * Name:        403.php
 * Description: 403 error page.
 * Date:        12/29/13
 * Programmer:  Liam Kelly
 */

//Send error header
header($_SERVER['SERVER_PROTOCOL'].'403 Forbidden');

?>

<h3>403, Forbidden</h3>
<p>
    You are unauthorized to access this resource. Sorry about that.
</p>