<?php

add_shortcode('FORMULAIRE_SELECT', array('PL_shortcode_select', 'display'));

class PL_shortcode_select {

    static function display($atts) {

        global $wpdb;

        $db = $wpdb->prefix . PL_BASENAME . '_pays';

        $sql_data = "SELECT id, nom FROM `$db`;";

        $result = $wpdb->get_results($sql_data, 'ARRAY_A');

        $allCountries = "";
        
        foreach ($result as $valeur) {

            $allCountries .= "<option value=" . $valeur['id'] . ">" . $valeur['nom'] . "</option>";
        
        }

        $html = "";

        $html .= "<form id=\"formulaire-select\" method=\"POST\">
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
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
                </fieldset>
            <button id=\"submit\" type=\"submit\">Submit</button>
        </form>";

        return $html;
    }
}

?>