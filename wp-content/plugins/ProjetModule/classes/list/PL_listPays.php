<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH .'wp-admin/includes/screen.php');
    require_once(ABSPATH .'wp-admin/includes/class-wp-list-table.php');
}

class pl_listPays extends WP_List_Table {

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

        $columns['id'] = __('id');
        $columns['nom'] = __('Nom Pays');
        $columns['codeiso'] = __('Code ISO');
        $columns['note'] = __('Note');
        $columns['majeur'] = __('Majeur O/N');
        
        return $columns;
    }

    public function get_hidden_columns($default = array()) {

        return $default;

    }

    public function get_sortable_columns($sortable = array()) {
        global $wpdb;
        
        $db_pays = $wpdb->prefix . PL_BASENAME .'_users_pays';

        $sql = "SELECT * FROM $db_pays";
        $result = $wpdb->get_results($sql, 'ARRAY_A');

        $sortable['id'] = array('id', true);
        $sortable['nom'] = array('nom', true);
        $sortable['codeiso'] = array('codeiso', true);
        $sortable['note'] = array('note', true);
        $sortable['majeur'] = array('majeur', true);

        return $sortable;

    }

    public function table_data($per_page=10, $page_number=1, $orderbydefault=false) {

        global $wpdb;

        $db_pays = $wpdb->prefix . PL_BASENAME .'_users_pays';

		// $sql = 'SELECT * FROM `'. $db_first . "WHERE 1";
		// écrivez toute votre requête croisée pour afficher id + nom + prenom + email + date

        $sql_data = "SELECT * FROM `$db_pays`";

        if (!empty($_REQUEST['orderby'])) {
			$sql_data .= ' ORDER BY `'. esc_sql($_REQUEST['orderby']) .'`';
			$sql_data .= ! empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $result = $wpdb->get_results($sql_data, 'ARRAY_A');

        return $result;

    }

    public function column_default( $item, $column_name ) {

        return @$item[$column_name];

    }

}