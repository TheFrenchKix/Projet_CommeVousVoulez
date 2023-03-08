<?php

    $path = __DIR__;
    preg_match('/(.*)wp\-content/i', $path, $dir);
    require_once(end($dir). 'wp-load.php');

    global $wpdb;

    $db_pays = $wpdb->prefix . PL_BASENAME . '_pays';
    $db_users_datas = $wpdb->prefix . PL_BASENAME . '_users_data';
    $db_voeux = $wpdb->prefix . PL_BASENAME . '_users_pays';

    $sql =
    "SELECT A.*, 
    (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='nom' LIMIT 1) AS 'nom', 
    (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='prenom' LIMIT 1) AS 'prenom',
    (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='sexe' LIMIT 1) AS 'sexe',
    (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='mail' LIMIT 1) AS 'mail',
    (SELECT B.`valeur` FROM `$db_users_datas` B WHERE B.`id`=A.`iduser` AND B.`cle`='mail' LIMIT 1) AS 'age',
    (SELECT C.`codeiso` FROM `$db_pays` C WHERE C.`id`=A.`idpays` LIMIT 1) AS 'iso'
    FROM `$db_voeux` A ";

    $voeux = $wpdb->get_results($sql,'ARRAY_A');
    
    ob_start();

    $heads = array(
        'Sexe',
        'Nom',
        'Prenom',
        'Email',
        'Age',
        'Code ISO'
    );
    print '"'.implode('"; "', $heads)."\"\n";

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Controle: must-revalidate, post-check=0, precheck=0');
    header('Cache-Control: private', false);
    header('Content-Type: text/csv; charset=UTF-8');

    foreach($voeux as $sign){
        $sign = array_map('trimming', $sign);

        if ($sign['sexe'] == "H") {
            $sign['sexe'] = "M";
        } else if($sign['sexe'] == "F") {
            $sign['sexe'] = "MME";
        }

        $fields = array(
            (string) $sign['sexe'],
            (string) $sign['nom'],
            (string) $sign['prenom'],
            (string) $sign['mail'],
            (string) $sign['age'],
            (string) $sign['iso'], // A MODIFIER AVEC LE CODE ISO
        );

        print '"'.implode('"; "', $fields)."\"\n";
    }

    $filename = sprintf('PL_Export_CSV_Voeux_%s.csv', date('d-m-Y_His'));
    header('Content-Disposition: attachment; filename="'. $filename. '";');
    header('Content-Transfer-Encoding: binary');
    ob_end_flush();

    function trimming($val){
        return trim($val);
    }

?>