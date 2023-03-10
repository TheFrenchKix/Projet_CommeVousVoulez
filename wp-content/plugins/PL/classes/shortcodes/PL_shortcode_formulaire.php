<?php

add_shortcode('FORMULAIRE', array('PL_shortcode_formulaire', 'display'));

class PL_shortcode_formulaire {

    static function display($atts) {

        if (!$_GET['id']){

            return "
                <form id=\"formulaire\" method=\"POST\">
                    <fieldset>
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
            
        }else{
            
            $userid = $_GET['id'];

            $db_pays = $wpdb->prefix . PL_BASENAME . '_pays';
            $db_users_datas = $wpdb->prefix . PL_BASENAME . '_users_data';
            $db_voeux = $wpdb->prefix . PL_BASENAME . '_users_pays';

            $sql =
            "SELECT A.*, 
            (SELECT C.`nom` FROM `$db_pays` C WHERE C.`id`=A.`idpays` LIMIT 1) AS 'nompays',
            (SELECT C.`iso` FROM `$db_pays` C WHERE C.`id`=A.`idpays` LIMIT 1) AS 'iso'
            FROM `$db_voeux` A
            WHERE A.`iduser`=$userid";

            $result = $wpdb->get_results($sql, 'ARRAY_A');

            return "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
            <script type='text/javascript'>
              google.charts.load('current', {
                'packages':['geochart'],
              });
              google.charts.setOnLoadCallback(drawRegionsMap);
        
              function drawRegionsMap() {
                var data = google.visualization.arrayToDataTable([
                  ['Germany', 200],
                  ['United States', 300],
                  ['Brazil', 400],
                  ['Canada', 500],
                  ['France', 600],
                  ['RU', 700]
                ]);
        
                var options = {};
        
                var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        
                chart.draw(data, options);
              }
            </script>
            <div id='regions_div' style='width: 900px; height: 500px;'></div>";

        }

    }
}

?>