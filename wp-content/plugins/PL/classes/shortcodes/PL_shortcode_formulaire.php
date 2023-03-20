<?php

add_shortcode('FORMULAIRE', array('PL_shortcode_formulaire', 'display'));

class PL_shortcode_formulaire {

    static function display($atts) {

        global $wpdb;

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
            (SELECT B.`nom` FROM `$db_pays` B WHERE B.`id`=A.`idpays` LIMIT 1) AS 'nompays',
            (SELECT B.`codeiso` FROM `$db_pays` B WHERE B.`id`=A.`idpays` LIMIT 1) AS 'iso'
            FROM `$db_voeux` A
            WHERE A.`iduser`=$userid";

            $result = $wpdb->get_results($sql, 'ARRAY_A');

            $codes = json_decode(file_get_contents('http://country.io/iso3.json'), true);
            $names = json_decode(file_get_contents('http://country.io/names.json'), true);
            $iso3_to_name = array();
            foreach($codes as $iso2 => $iso3) {
                $iso3_to_name[$iso3] = $names[$iso2];
            }

            $listepays = "";
            $index = 0;

            foreach ($result as $valeur) {

                // var_dump($iso3_to_iso2($valeur['iso']));

                $index += 1;
        
                if ($index == count($result))
                {

                    $listepays .= "['" . $iso3_to_name[$valeur['iso']] . "']";

                }else{

                    $listepays .= "['" . $iso3_to_name[$valeur['iso']] . "'],\n";
                }


            }

            $carte = '';

            $carte .= '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
              google.charts.load("current", {
                "packages":["geochart"],
              });
              google.charts.setOnLoadCallback(drawRegionsMap);
        
              function drawRegionsMap() {
                var data = google.visualization.arrayToDataTable([
                  ["Country"],
                  '. $listepays .'
                ]);
        
                var options = {};
        
                var chart = new google.visualization.GeoChart(document.getElementById("regions_div"));
        
                chart.draw(data, options);
              }
            </script>
          </head>
          <body>
            <h1> Carte récapitulative </h1>

            <div id="regions_div" style="width: 900px; height: 500px;"></div>
          </body>';

            return $carte;

        }

    }
}

?>