<?php
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