<?php

class pl_crud_index {

    public function ajout(){

        global $wpdb;
        
        $wpdb->insert($wpdb->prefix . PL_BASENAME . '_users',['id'=>0]);
        $lastid = $wpdb->insert_id;
        
        return $lastid;

    }

    public function ajout_v2($refId, $key_of_value, $key_value){
        global $wpdb;
        $table_name_sub_newsletter = $wpdb->prefix . PL_BASENAME . '_users_data';

        $wpdb->insert(
            $table_name_sub_newsletter,
            array(
                'id' => $refId,
                'cle' => $key_of_value,
                'valeur' => $key_value,
                'index' => NULL,
            )
        );

        return true;
    }

    public function ajoutChoix($iduser, $idpays){

        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME .'_users_pays';

        $request = $wpdb->insert($db, array('iduser' => $iduser, 'idpays' => $idpays));

        if($request){

            return "Choix ajouté !";

        }

        return "Error";

    }

    public function supp($id){
        global $wpdb;

        if($id == null){
            return;
        }
        
        if($wpdb->delete($wpdb->prefix . PL_BASENAME . '_users_data',['id'=>$id])){
            if($wpdb->delete($wpdb->prefix . PL_BASENAME . '_users',['id'=>$id])){
                    return "La suppression s'est bien effectué !";
            }
        }
        else{
            return "Veuillez envoyez un 'id' étant dans la BDD.";
        }
    }

    static public function getPays(){
        
        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME .'_pays';

        $sql = "SELECT * FROM $db";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    static public function updateMajeur($id, $valeur){

        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME .'_pays';

        $request = $wpdb->update($db, array('majeur' => $valeur), ['id' => $id]);

        if($request){

            return "Mise à jour faite !";

        }

        return "Error";
    }

    static public function updateNote($id, $valeur){

        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME .'_pays';

        $request = $wpdb->update($db, array('note' => $valeur), ['id' => $id]);

        if($request){

            return "Mise à jour faite !";

        }

        return "Error";
    }

    static public function resetActiveCountries(){

        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME .'_pays';

        $sql = "SELECT * FROM $db";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        foreach ($result as $UnPays) 
        {

            $request = $wpdb->update($db, array('isactive' => 0), ['id' => $UnPays['id']]);

        }

        if($request){

            return "Reset !";

        }

        return "Error";
    }

    static public function updateActiveCountries($idpays){

        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME .'_pays';

        $request = $wpdb->update($db, array('isactive' => 1), ['id' => $idpays]);

        if($request){

            return "Mise à jour faite !";

        }

        return "Error";
    }

    static public function getUsers(){

        global $wpdb;

        $db_first = $wpdb->prefix . PL_BASENAME .'_users';
        $db_second = $wpdb->prefix . PL_BASENAME .'_users_data';

        $sql_data =
        "SELECT A.*, 
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='firstname' LIMIT 1) AS 'firstname', 
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='email' LIMIT 1) AS 'email',
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='lastname' LIMIT 1) AS 'lastname',
        (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='code_postal' LIMIT 1) AS 'code_postal'
        FROM `$db_first` A ";

        if (!empty($_REQUEST['orderby'])) {
			$sql_data .= ' ORDER BY `'. esc_sql($_REQUEST['orderby']) .'`';
			$sql_data .= ! empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $result = $wpdb->get_results($sql_data, 'ARRAY_A');

        if($result){

            return "Voici, voilà !";

        }

        return "Error";
    }

}

?>