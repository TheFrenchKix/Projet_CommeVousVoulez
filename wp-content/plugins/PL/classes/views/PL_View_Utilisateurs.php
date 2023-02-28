<?php

class PL_View_Utilisateurs {

public function display() {
    
    global $wpdb;
    $WP_PL_ListPays = new PL_listPays('`'.$wpdb->prefix . PL_BASENAME .'_users_pays`');

    $tempscreen = get_current_screen();
    $this->_screen = $tempscreen->base;

    $pays = pl_crud_index::getPays();

    ?>
    <div class="wrap" id="pl_param_update">
        <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
        <?php //if (!$msg): $msg = true; ?>
            <div class="notice notice-info notice-alt is-dismissible hidden update-message">
                <p><?php _e('Mise à jour effectué !'); ?></p>
            </div>
        <?php //endif; ?>
        <table class="wp-list-table widefat fixed striped">
            <div class="wrap" id="list-table">
                <form id="list-table-form" method="post">
                    <?php
                        $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
                        $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
                        printf('<input type="hidden" name="page" value="%s" />', $page);
                        printf('<input type="hidden" name="paged" value="%d" />', $paged);
                        $WP_PL_ListPays->prepare_items();
                        $WP_PL_ListPays->display();
                    ?>
                </form>
            </div>
        </table>
    </div>

    <?php

    }

}

?>