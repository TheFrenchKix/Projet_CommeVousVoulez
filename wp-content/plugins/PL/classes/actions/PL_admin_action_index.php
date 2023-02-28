<?php

add_action('wp_ajax_remove', array('pl_admin_action_index', 'RemoveJob'));
add_action('wp_ajax_update', array('pl_admin_action_index', 'Update'));
add_action('wp_ajax_updatemajeur', array('pl_admin_action_index', 'UpdateMajeur'));
add_action('wp_ajax_updatenote', array('pl_admin_action_index', 'UpdateNote'));

class pl_admin_action_index{

    public static function RemoveJob(){

        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $crud = new pl_crud_index();
        $crud->supp($_REQUEST['id']);

        exit;
    }

    static public function Update(){
        check_ajax_referer('ajax_nonce_security', 'security');
        $crud = new pl_crud_index();

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        foreach($_REQUEST as $key => $valeur){
            if(!in_array($key, ['security','action'])){
                $$key = (string) trim($valeur);
                $crud->setConfig($key, $valeur);
            }
        }


        exit;
    }

    static public function UpdateNote(){
        check_ajax_referer('ajax_nonce_security', 'security');
        $crud = new pl_crud_index();

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $crud->UpdateNote($_REQUEST['id'], $_REQUEST['note']);

        exit;
    }

    static public function UpdateMajeur(){
        check_ajax_referer('ajax_nonce_security', 'security');
        $crud = new pl_crud_index();

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        var_dump($_REQUEST);

        $crud->UpdateMajeur($_REQUEST['id'], $_REQUEST['majeur']);

        exit;
    }

}

?>