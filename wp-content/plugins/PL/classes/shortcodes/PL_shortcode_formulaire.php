<?php

add_shortcode('FORMULAIRE', array('PL_shortcode_formulaire', 'display'));

class PL_shortcode_formulaire {

    static function display($atts) {

        return "
        <form id=\"formulaire\" method=\"POST\">
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
                    <input type=\"text\" id=\"nom\" name=\"nom\" placeholder=\"Nom\" required>
                    <input type=\"text\" id=\"prenom\" name=\"prenom\" placeholder=\"Prenom\" required>
                    <input type=\"text\" id=\"email\" name=\"email\" placeholder=\"Email\" required>
                    <select id=\"sexe\" name=\"sexe\" style=\"display: block\" required>
                        <option value=\"H\">H</option>
                        <option value=\"F\">F</option>
                    </select>
                    <input type=\"date\" id=\"dateNaiss\" name=\"dateNaiss\" placeholder=\"Date de Naissance\" required>
                    <button id=\"submit\" type=\"submit\" class=\"btnSub\">Submit</button>
                </fieldset>
        </form>
        ";
    }
}

?>