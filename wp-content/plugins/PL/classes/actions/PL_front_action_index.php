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
                var_dump($value);
                $crud->ajout_v2($refid,$key,$value);
            }
        }

        print $lastid;
        exit;
    }

    public static function SubmitSecondStep() {

        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $crud = new pl_crud_index();
        
        foreach($_REQUEST as $key => $value){

            if(!in_array($key,['security','action'])){

                var_dump($value);
                $crud->ajoutChoix(5,$value); // A FAIRE, CHANGE LE 5 PAR L'ID DE UTILISATEUR CONNECTE

            }
        }

        exit;
    }

}

?>