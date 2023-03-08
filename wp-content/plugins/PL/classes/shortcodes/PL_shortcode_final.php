<?php

add_shortcode('FORMULAIRE_FINAL', array('PL_shortcode_final', 'display'));

class PL_shortcode_final {

    static function display($atts) {

        return "
        <form id=\"formulaire-final\" method=\"POST\">
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
                    <h1>Liste de vos choix</h1>
                    <ul>
                        <li value='Choix1'>Choix 1</li>
                        <li value='Choix2'>Choix 2</li>
                        <li value='Choix3'>Choix 3</li>
                        <li value='Choix4'>Choix 4</li>
                        <li value='Choix5'>Choix 5</li>
                    </ul>
                </fieldset>
            <button id=\"submit\" type=\"submit\">Submit</button>
        </form>
        ";
    }
}

?>