<?php

add_action('wp_ajax_pl', array('pl_front_action_index', 'SubmitFirstStep'));
add_action('wp_ajax_nopriv_pl', array('pl_front_action_index', 'SubmitFirstStep'));
add_action('wp_ajax_pl-second', array('pl_front_action_index', 'SubmitSecondStep'));
add_action('wp_ajax_nopriv_pl-second', array('pl_front_action_index', 'SubmitSecondStep'));

class pl_front_action_index {

    public static function SubmitFirstStep() {

        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }
        
        foreach ($_REQUEST as $key => $value){
            $$key = (string) trim($value);
        }

        $crud = new pl_crud_index();
        $refid = $crud->ajout();

        foreach($_REQUEST as $key => $value){
            if(!in_array($key,['security','action'])){
                $crud->ajout_v2($refid,$key,$value);
            }
        }

        print $refid;
        exit;
    }

    public static function SubmitSecondStep() {

        check_ajax_referer('ajax_nonce_security', 'security');

        global $wpdb;

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $crud = new pl_crud_index();
        $userid = $_REQUEST['id'];
        
        foreach($_REQUEST as $key => $value){

            if(!in_array($key,['security','action'])){

                $crud->ajoutChoix($userid,$value);

            }
        }

        exit;
    }

}

?>