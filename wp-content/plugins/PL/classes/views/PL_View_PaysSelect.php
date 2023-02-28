<?php

class PL_View_PaysSelect {

    public function __construct() {

        return;

    }

//Display de notre onglet listant les inscrits
    public function display() {

        global $wpdb;
        
        $db_pays = $wpdb->prefix . PL_BASENAME .'_pays';

        $sql = "SELECT * FROM $db_pays";
        $result = $wpdb->get_results($sql, 'ARRAY_A');

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        $toolbar = $this->toolbar();
        
        ?>
            <div class="wrap">
                <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
                <hr class="wp-header-end" />
                <div class="notice notice-info notice-alt is-dismissible hidden confirm-message">
                    <p><?php _e('Updated !'); ?></p>
                </div>
                <?php //if (sizeof($toolbar)) self::toolbar($toolbar); ?>
                <label for="pays">Choisissez vos pays :</label>
                <div class="wrap" id="list-table">
                    <select name="countries" id="countries" multiple>
                        <?php

                            foreach ($result as $pays) : 

                                if ($pays['isactive']){ ?>

                                    <option value=<?php echo $pays['id'] ?> selected><?php echo $pays['nom']?></option>

                                <?php } else { ?>
                                    
                                    <option value=<?php echo $pays['id'] ?>><?php echo $pays['nom'] ?></option> <?php }
                                
                            endforeach; ?>

                    </select>
                    <br><br>
                    <button id="btnUpdateCountry" class="button button-primary left update">
                        <i class="fas fa-check"></i>
                        <?php _e('Submit'); ?>
                    </button>                
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
                                <a class="button button-secondary" href="<?php print plugins_url(PL_PLUGIN_NAME.'/classes/export/PL_Export_XML_Pays.php'); ?>">
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