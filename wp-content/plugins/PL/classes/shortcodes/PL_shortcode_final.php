<?php

add_shortcode('FORMULAIRE_FINAL', array('PL_shortcode_final', 'display'));

class PL_shortcode_final {

    static function display($atts) {

        global $wpdb;

        $db_pays = $wpdb->prefix . PL_BASENAME . '_pays';
        $db_users_datas = $wpdb->prefix . PL_BASENAME . '_users_data';
        $db_voeux = $wpdb->prefix . PL_BASENAME . '_users_pays';
    
        $sql =
        "SELECT A.*, 
        (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='nom' LIMIT 1) AS 'nom',
        (SELECT C.`nom` FROM `$db_pays` C WHERE C.`id`=A.`idpays` LIMIT 1) AS 'nompays',
        (SELECT C.`note` FROM `$db_pays` C WHERE C.`id`=A.`idpays` LIMIT 1) AS 'notepays'
        FROM `$db_voeux` A
        WHERE A.`iduser`=5";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        // var_dump($result);
        // die;

        $allNotes = "";
        
        foreach ($result as $valeur) {

            $allNotes .= "<li value=" . $valeur['nompays'] . ">" . $valeur['nompays'] . " | Note : ". $valeur['notepays'] ."</li>";
            $nom = $valeur['nom'];
        
        }

        $html = "";

        $html .= "<form id=\"formulaire-final\" method=\"POST\">
            <fieldset>
                    <h3>Vos choix, ". $nom ."</h3>
                    <ul>
                        ". $allNotes ."
                    </ul>
                </fieldset>
            <button id=\"submit\" type=\"submit\">Submit</button>
        </form>";

        return $html;
    }
}

?>