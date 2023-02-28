<?php

class PL_Install {

    public function __construct() {

        add_action( 'admin_init', array( $this, 'setup' ) );
        return;

    }

    public function setup() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH .'wp-admin/includes/upgrade.php');

    if(!$this->isTableBaseAlreadyCreated('_users')){
        $sql_users = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . PL_BASENAME . '_users' .'` (
                `id` INT(11) AUTO_INCREMENT NOT NULL,
                `date` DATETIME DEFAULT now() NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_users);
    }

    if(!$this->isTableBaseAlreadyCreated('_users_data')){
        $sql_users_data = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . PL_BASENAME . '_users_data` (
                `index` INT(11) AUTO_INCREMENT NOT NULL,
                `valeur` VARCHAR(255) NOT NULL,
                `cle` VARCHAR(255) NOT NULL,
                `id` INT(11) NOT NULL,
                PRIMARY KEY (`index`),
                FOREIGN KEY (`id`) REFERENCES `'. $wpdb->prefix . PL_BASENAME . '_users`(id)
            ) ENGINE=InnoDB '. $charset_collate;

            dbDelta($sql_users_data);
    }

    if(!$this->isTableBaseAlreadyCreated('_pays')){
        $sql_pays = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . PL_BASENAME . '_pays' .'` (
                `id` INT(11) AUTO_INCREMENT NOT NULL,
                `nom` VARCHAR(255) NULL,
                `codeiso` VARCHAR(255) NULL,
                `note` INT(11) NULL,
                `majeur` BOOLEAN NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_pays);
    }

    if(!$this->isTableBaseAlreadyCreated('_users_pays')){
        $sql_users_pays = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . PL_BASENAME . '_users_pays' .'` (
                `index` INT(11) AUTO_INCREMENT NOT NULL,
                `iduser` INT(11) NULL,
                `idpays` INT(11) NULL,
                PRIMARY KEY (`index`),
                FOREIGN KEY (`iduser`) REFERENCES `'. $wpdb->prefix . PL_BASENAME . '_users`(id),
                FOREIGN KEY (`idpays`) REFERENCES `'. $wpdb->prefix . PL_BASENAME . '_pays`(id)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_users_pays);
    }

}

    public function isTableBaseAlreadyCreated($table) {

        global $wpdb;

        $sql = 'SHOW TABLES LIKE \'%'. $wpdb->prefix . PL_BASENAME . $table .'%\'';
        return $wpdb->get_var($sql);

    }
}

?>