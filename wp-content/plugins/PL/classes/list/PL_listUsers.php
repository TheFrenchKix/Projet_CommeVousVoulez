<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH .'wp-admin/includes/screen.php');
    require_once(ABSPATH .'wp-admin/includes/class-wp-list-table.php');
}

class PL_listUsers extends WP_List_Table {

    public $_tablename = '';
    public $_program;
    public $_screen;

    public function __construct($tb, $program = NULL) {

        $this->_program = $program;

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        if ($tb)
            $this->_tablename = $tb;

        parent::__construct( [
            'singular' => __('Item', 'sp'),
            'plural'   => __('Items', 'sp'),
            'ajax'     => false
        ]);

    }

    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $data = $this->table_data();
        $currentPage = $this->get_pagenum();

        $perPage = 10;
        $this->set_pagination_args(array(
            'total_items' => count($data),
            'per_page'    => $perPage
        ));

        $data = array_slice($data, (($currentPage-1)*$perPage), $perPage);

        $this->items = $data;

    }

    public function get_columns($columns = array()) {

        // global $wpdb;        
        // $db_first = $wpdb->prefix . PL_BASENAME .'_users';
        // $db_second = $wpdb->prefix . PL_BASENAME .'_users_data';

        // $sql = "SELECT DISTINCT `cle` FROM $db_second WHERE `cle` != ''";

        // $result = $wpdb->get_results($sql, 'ARRAY_A');

        $columns['identite'] = __('Identite');
        $columns['nbVoeux'] = __('Nombre de voeux');
        
        return $columns;

    }

    public function get_hidden_columns($default = array()) {

        return $default;

    }

    public function get_sortable_columns($sortable = array()) {
        // global $wpdb;
        
        // $db_first = $wpdb->prefix . PL_BASENAME .'_users';
        // $db_second = $wpdb->prefix . PL_BASENAME .'_users_data';

        // $sql = "SELECT DISTINCT `cle` FROM `$db_second` WHERE `cle` != '' ";
        // $result = $wpdb->get_results($sql, 'ARRAY_A');

        // foreach($result as $value){
        //     $sortable[$value["cle"]] = array($value["cle"], true);
        // }

        $sortable['identite'] = array('identite', true);
        $sortable['nbVoeux'] = array('nbVoeux', true);

        return $sortable;

    }

    public function table_data($per_page=10, $page_number=1, $orderbydefault=false) {

        global $wpdb;

        $db_first = $wpdb->prefix . PL_BASENAME . '_users';
        $db_second = $wpdb->prefix . PL_BASENAME . '_users_data';

		// $sql = 'SELECT * FROM `'. $db_first . "WHERE 1";
		// écrivez toute votre requête croisée pour afficher id + nom + prenom + email + date

        $sql_data =
        "SELECT A.*, 
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='nom' LIMIT 1) AS 'nom', 
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='prenom' LIMIT 1) AS 'prenom',
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='sexe' LIMIT 1) AS 'sexe',
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='dateNaiss' LIMIT 1) AS 'dateNaiss'
        FROM `$db_first` A ";

        if (!empty($_REQUEST['orderby'])) {
			$sql_data .= ' ORDER BY `'. esc_sql($_REQUEST['orderby']) .'`';
			$sql_data .= ! empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $result = $wpdb->get_results($sql_data, 'ARRAY_A');

        return $result;

    }

    public function column_default( $item, $column_name ) {

        $Helper = new PL_Helper_Index();
        $item['sexe'] = $Helper->SexeToGender($item['sexe']);

        if (preg_match('/identite/i', $column_name)){
            return self::getIdentity($item);
        }

        if (preg_match('/nbVoeux/i', $column_name)){
            return self::getNbVoeux($item);
        }

        return @$item[$column_name];

    }

    private function getIdentity($data){
        return sprintf(
            '%s', 
            $data['sexe'] . ' ' . $data['nom'] . ' ' . $data['prenom'],
            );
    }

    private function getNbVoeux($data){

        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME . '_users_pays';
        $id = $data['id'];

        $sql_data = "SELECT COUNT(*) AS 'voeux' FROM `$db` WHERE iduser = $id;";

        $result = $wpdb->get_results($sql_data, 'ARRAY_A');

        return sprintf(
            '%s', 
            $result[0]['voeux'],
            );
    }

}