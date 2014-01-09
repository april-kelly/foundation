<?php

    //Load the theme configuration
    include_once(dirname(__FILE__).'/config/theme_config.php');
    $theme = new theme_config;

?>
<html>

    <head>

        <title><?php echo $settings['page_title']; ?></title>

        <style>

            <?php

                echo file_get_contents(ABSPATH.'includes/views/themes/'.$theme->dir_name.'/styles/styles.css');

            ?>

        </style>

    </head>

    <body>

        <div id="nav">

            <?php

                include_once(ABSPATH.'includes/views/themes/'.$theme->dir_name.'/nav.php');

            ?>

        </div>

        <div id="main">

            <?php

                include_once(ABSPATH.'includes/views/themes/'.$theme->dir_name.'/'.$page['path']);

            ?>

        </div>

        <div id="footer">
            <?php

                include_once(ABSPATH.'includes/views/themes/'.$theme->dir_name.'/footer.php');

            ?>
        </div>


    </body>

</html>