<?php

add_shortcode('FORMULAIRE_SELECT', array('PL_shortcode_select', 'display'));

class PL_shortcode_select {

    static function display($atts) {

        return "
        <form id=\"formulaire-select\" method=\"POST\">
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
                    <select id=\"voyage-1\" style=\"display: block\" required>
                        <option value=\"--- SELECT ---\">--- SELECT ---</option>
                    </select>
                    <select id=\"voyage-2\" style=\"display: block\" disabled>
                        <option value=\"--- SELECT ---\">--- SELECT ---</option>
                    </select>
                    <select id=\"voyage-3\" style=\"display: block\" disabled>
                        <option value=\"--- SELECT ---\">--- SELECT ---</option>
                    </select>
                    <select id=\"voyage-4\" style=\"display: block\" disabled>
                        <option value=\"--- SELECT ---\">--- SELECT ---</option>
                    </select>
                    <select id=\"voyage-5\" style=\"display: block\" disabled>
                        <option value=\"--- SELECT ---\">--- SELECT ---</option>
                    </select>
                </fieldset>
            <button id=\"submit\" type=\"submit\">Submit</button>
        </form>
        ";
    }
}

?>