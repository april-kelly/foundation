<?php
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