<?php

add_shortcode('FORMULAIRE_FINAL', array('PL_shortcode_final', 'display'));

class PL_shortcode_final {

    static function display($atts) {

        global $wpdb;
        
        if (!$_GET['id']){

            header('Location: choix-voyage');
            
        }else{
            
            $userid = $_GET['id'];

        }
        
        $db_pays = $wpdb->prefix . PL_BASENAME . '_pays';
        $db_users_datas = $wpdb->prefix . PL_BASENAME . '_users_data';
        $db_voeux = $wpdb->prefix . PL_BASENAME . '_users_pays';
    
        $sql =
        "SELECT A.*, 
        (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='nom' LIMIT 1) AS 'nom',
        (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='sexe' LIMIT 1) AS 'sexe',
        (SELECT C.`nom` FROM `$db_pays` C WHERE C.`id`=A.`idpays` LIMIT 1) AS 'nompays',
        (SELECT C.`note` FROM `$db_pays` C WHERE C.`id`=A.`idpays` LIMIT 1) AS 'notepays'
        FROM `$db_voeux` A
        WHERE A.`iduser`=$userid";

        $result = $wpdb->get_results($sql, 'ARRAY_A');
    
        $allChoix = "";
        $nom = "";
        
        foreach ($result as $valeur) {

            $notes = "";
            $restenote = 5 - intval($valeur['notepays'],10);
            $nom = "";

            for ($i = 0;$i<=$valeur['notepays'];$i++){

                $notes .= "<i class='fa-sharp fa-solid fa-star'></i>";

            }

            if ($restenote > 0){

                for ($i = 1;$i<$restenote;$i++){

                    $notes .= "<i class='fa-sharp fa-regular fa-star'></i>";
    
                }

            }

            $allChoix .= "<tr><td value=" . $valeur['nompays'] . ">" . $notes . " <th>". $valeur['nompays'] ."</th></td></tr>";

            $Helper = new PL_Helper_Index();
            $valeur['sexe'] = $Helper->SexeToGender($valeur['sexe']);

            $nom .= $valeur['sexe'] . " " . $valeur['nom'];
        
        }

        $html = "";

        $html .= "<form id=\"formulaire-final\" method=\"POST\">
            <fieldset>
                    <h1>". $nom ."</h1>
                    <table>
                        <tr><h2>Liste de vos choix</h2></tr>
                        ". $allChoix . "
                    </table>
                    <button id=\"submit\" type=\"submit\" class=\"btnSub\">Oui, je valide mes choix</button>
                </fieldset>
        </form>";

        return $html;
    }
}

?>