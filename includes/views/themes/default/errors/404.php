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
 * Name:        
 * Description: 
 * Date:        12/29/13
 * Programmer:  Liam Kelly
 */

//Send error header
header($_SERVER['SERVER_PROTOCOL'].'403 Forbidden');

?>
<html>

<head>

    <title>Error 404 | <?php echo $settings['page_title']; ?></title>

    <link href="./includes/views/themes/<?php echo $theme->dir_name ?>/styles/styles.css" rel="stylesheet"/>

</head>

<body>

<h1>404, Resource does not exist</h1>
<p>

<h3>The file or page you requested does not exist or you are not authorized to access it. </h3>
<img src="./includes/views/themes/<?php echo $theme->dir_name; ?>/images/404.jpg" alt="This 404 page, now 20% cooler" title="Rainbow Dash" />

</p>

</body>

</html>
