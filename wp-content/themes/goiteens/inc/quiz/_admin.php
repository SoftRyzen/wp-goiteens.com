<?php
defined( 'ABSPATH' ) || exit;

/**
 * Hide window Notice
 */
add_action('admin_footer','goiteens_quiz_admin_hide_notice', 1);
function goiteens_quiz_admin_hide_notice()
{
    global $pagenow;

    /**
     * enqueue styles only in the current page
     */
    if ( 'admin.php' === $pagenow && get_current_screen()->id == 'admin_page_mlw_quiz_options' )
    {

        ?>
        <style>
            .qsm-help-tab-dropdown-list {
                display: none !important;
            }
        </style>
        <?php

    }

}


