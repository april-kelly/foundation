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
 * Name:        status.php
 * Description: Shows the status of the server
 * Date:        12/27/13
 * Programmer:  Liam Kelly
 */


?>

<h3>Status</h3>
<p>

    Welcome to <?php echo $settings['product_name']; ?>
    <?php echo $settings['version']; ?>
    <?php echo $settings['version_type']; ?>!
    <br />

</p>
<hr />
<p class="info">
    Powered by The <?php echo $settings['foundation_product_name']; ?>
    version <?php echo $settings['foundation_version']; ?>
    <?php echo $settings['foundation_version_type']; ?>.
    <br />
    Copyright (c) 2013-<?php echo date('Y'); ?> William Caleb Kelly<br />
    see the LINCENSE.md file for more information
</p>