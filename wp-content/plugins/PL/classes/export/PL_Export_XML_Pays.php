<?php

    $path = __DIR__;
    preg_match('/(.*)wp\-content/i', $path, $dir);
    require_once(end($dir). 'wp-load.php');

    global $wpdb;

    $db = $wpdb->prefix . PL_BASENAME .'_pays';

    $sql = "SELECT * FROM $db";

    $result = $wpdb->get_results($sql, 'ARRAY_A');
    
    ob_start();

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Controle: must-revalidate, post-check=0, precheck=0');
    header('Cache-Control: private', false);

    $xml = new SimpleXMLElement('<Liste/>');
    foreach ($result as $pays) :

        $event = $xml->addChild('Pays');
        $event->addChild('Id',$pays['id']);
        $event->addChild('Nom',$pays['nom']);
        $event->addChild('CodeISO',$pays['codeiso']);
        $event->addChild('Note',$pays['note']);
        $event->addChild('Majeur',$pays['majeur']);
        $event->addChild('Isactive',$pays['isactive']);

    endforeach;
    
    print $xml->asXML();

    $filename = sprintf('PL_Export_XML_Pays_%s.xml', date('d-m-Y_His'));
    header('Content-Disposition: attachment; filename="'. $filename. '";');
    header('Content-Transfer-Encoding: binary');
    ob_end_flush();

?>