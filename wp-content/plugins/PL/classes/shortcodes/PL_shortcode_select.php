<?php

add_shortcode('FORMULAIRE_SELECT', array('PL_shortcode_select', 'display'));

class PL_shortcode_select {

    static function display($atts) {

        global $wpdb;

        if (!$_GET['id']){

            header('Location: choix-voyage');
            
        }else{
            
            $userid = $_GET['id'];

        }

        $db = $wpdb->prefix . PL_BASENAME . '_pays';

        $sql_data = "SELECT id, nom FROM `$db` WHERE isactive = 1;";

        $result = $wpdb->get_results($sql_data, 'ARRAY_A');

        $allCountries = "";
        
        foreach ($result as $valeur) {

            $allCountries .= "<option value=" . $valeur['id'] . ">" . $valeur['nom'] . "</option>";
        
        }

        $html = "";

        $html .= "<form id=\"formulaire-select\" method=\"POST\">
            <fieldset>
                    <h3>Liste des pays</h3>
                    <select id=\"1\" style=\"display: block\" required>
                        <option value='defaut'>--- SELECT ---</option>
                        ". $allCountries ."
                    </select>
                    <select id=\"2\" style=\"display: block\" disabled>
                        <option value='defaut'>--- SELECT ---</option>
                        ". $allCountries ."
                    </select>
                    <select id=\"3\" style=\"display: block\" disabled>
                        <option value='defaut'>--- SELECT ---</option>
                        ". $allCountries ."
                    </select>
                    <select id=\"4\" style=\"display: block\" disabled>
                        <option value='defaut'>--- SELECT ---</option>
                        ". $allCountries ."
                    </select>
                    <select id=\"5\" style=\"display: block\" disabled>
                        <option value='defaut'>--- SELECT ---</option>
                        ". $allCountries ."
                    </select>
                    <button id=\"submit\" type=\"submit\" class=\"btnSub\" disabled='disabled'>Submit</button>
                </fieldset>
        </form>";

        return $html;
    }
}

?>