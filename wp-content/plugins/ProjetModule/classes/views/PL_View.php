<?php

class PL_View {

    public function __construct() {

        return;

    }

//Display de notre onglet listant les inscrits
    public function display() {

        global $wpdb;
        $WP_PL_ListPays = new PL_listPays('`'.$wpdb->prefix . PL_BASENAME .'_users_pays`');

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        $toolbar = $this->toolbar();
        ?>
            <div class="wrap">
                <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
                <hr class="wp-header-end" />
                <div class="notice notice-info notice-alt is-dismissible hide delete-confirmation">
                    <p><?php _e('Mise à jour effectuée !'); ?></p>
                </div>
                <?php //if (sizeof($toolbar)) self::toolbar($toolbar); ?>
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
            <div>
        <?php
        
    }

    private function toolbar() {
        ?>
        <div>

            <form action="<?php print admin_url('admin-post.php'); ?>" method="post">
                <table>
                    <tbody>
                        <tr>
                            <?php if(defined('PL_PLUGIN_NAME')): ?>
                            <td>
                                <a class="button button-secondary" href="<?php print plugins_url(PL_PLUGIN_NAME.'/classes/export/PL_Export_CSV.php'); ?>">
                                    <i class="fas fa-save"></i>&nbsp;CSV 
                                </a>
                            </td>
                            <td>
                                <a class="button button-secondary" href="<?php print plugins_url(PL_PLUGIN_NAME.'/classes/export/PL_Export_JSON.php'); ?>">
                                    <i class="fas fa-save"></i>&nbsp;JSON 
                                </a>
                            </td>
                            <td>
                                <a class="button button-secondary" href="<?php print plugins_url(PL_PLUGIN_NAME.'/classes/export/PL_Export_XML.php'); ?>">
                                    <i class="fas fa-save"></i>&nbsp;XML
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <hr class="wp-header-end">
        <?php
    }
}