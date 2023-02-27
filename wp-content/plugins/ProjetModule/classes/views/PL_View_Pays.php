<?php

class PL_View_Pays {

public function display() {

    $pays = pl_crud_index::getPays();
    
        global $wpdb;
        $WP_PL_ListPays = new PL_listPays('`'.$wpdb->prefix . PL_BASENAME .'_users_pays`');

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        $toolbar = $this->toolbar();
        ?>
        <div class="wrap" id="pl_param_update">
            <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
            <?php //if (!$msg): $msg = true; ?>
                <div class="notice notice-info notice-alt is-dismissible hide update-message">
                    <p><?php _e('Mise à jour effectué !'); ?></p>
                </div>
            <?php //endif; ?>
            <table class="wp-list-table widefat fixed striped">
                <tfoot>
                    <tr>
                        <th colspan="2">
                            <button id="btnUpdate" class="button button-primary left update">
                                <i class="fas fa-check"></i>
                                <?php _e('Update'); ?>
                            </button>
                        </th>
                    </tr>
                </tfoot>
                <!-- <div class="wrap" id="list-table">
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
                </div> -->
                <tbody>
                    <?php foreach ($pays as $unpays): ?>
                        <tr>
                            <th class="smallwidth" style="text-transform: capitalize;">
                                <?php print $unpays['id'] ?>
                            </th>
                            <td>
                                <span class="helper-text">
                                    <input id="<?php print $unpays['id'] ?>" type="text" value="<?php print $unpays['nom'] ?>" />
                                </span>
                            </td>
                            <td>
                                <span class="helper-text">
                                    <input id="<?php print $unpays['id'] ?>" type="text" value="<?php print $unpays['codeiso'] ?>" />
                                </span>
                            </td>
                            <td>
                                <span class="helper-text">
                                    <div class="slidecontainer">
                                        <input type="range" min="0" max="5" value="<?php print $unpays['note'] ?>" class="slider" id="<?php print $unpays['id'] ?>">
                                    </div>
                                </span>
                            </td>
                            <td>
                                <span class="helper-text">
                                    <?php if ($unpays['majeur'] != 0): ?>
                                        <input id="<?php print $unpays['id'] ?>" type="checkbox" class="majeur" value="<?php print $unpays['majeur'] ?>" checked/>
                                    <?php else: ?>
                                        <input id="<?php print $unpays['id'] ?>" type="checkbox" class="majeur" value="<?php print $unpays['majeur'] ?>"/>
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    
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

?>