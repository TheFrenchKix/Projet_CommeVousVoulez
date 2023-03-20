<?php

add_action('wp_ajax_pl', array('pl_front_action_index', 'SubmitFirstStep'));
add_action('wp_ajax_nopriv_pl', array('pl_front_action_index', 'SubmitFirstStep'));
add_action('wp_ajax_pl-second', array('pl_front_action_index', 'SubmitSecondStep'));
add_action('wp_ajax_nopriv_pl-second', array('pl_front_action_index', 'SubmitSecondStep'));
add_action('wp_ajax_pl-json', array('pl_front_action_index', 'GetJSON'));
add_action('wp_ajax_nopriv_pl-json', array('pl_front_action_index', 'GetJSON'));


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

    public static function GetJSON(){
        
        global $wpdb;

        $userid = $_REQUEST['id'];
        
        $db_pays = $wpdb->prefix . PL_BASENAME . '_pays';
        $db_users_datas = $wpdb->prefix . PL_BASENAME . '_users_data';
        $db_voeux = $wpdb->prefix . PL_BASENAME . '_users_pays';
    
        $sql =
        "SELECT
        (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='nom' LIMIT 1) AS 'nom',
        (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='prenom' LIMIT 1) AS 'prenom',
        (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='sexe' LIMIT 1) AS 'sexe'
        FROM `$db_voeux` A
        WHERE A.`iduser`=$userid
        LIMIT 1";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        $Helper = new PL_Helper_Index();
        $result[0]['sexe'] = $Helper->SexeToGender($result[0]['sexe']);

        print json_encode($result);
        exit;
    }

}

?>