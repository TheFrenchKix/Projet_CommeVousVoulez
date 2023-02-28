<?php 

class PL_Front{

    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'addjs'), 0);
        // add_action('init', array($this,"PremiereRoute"),0);
        // add_filter('query_vars',array($this,"VariableCustom"));
        // add_action('wp_loaded', array($this, "LeBordel"));
        add_action('init', array($this, 'jedeclaredesroutes'), 0);
        add_filter('query_vars', array($this, 'jajouteunevariablecustom'));
        add_action('wp_loaded', array($this, 'prendencomptelebordel'));
        return;

    }

    // static public function PremiereRoute(){
    //     add_rewrite_rule(
    //         PL_URL.'/id/([^/]*)/?$',
    //         'index.php?pagename='.PL_URL.'&mavariabletest=$match[1]',
    //         'top'
    //     );
    // }

    // static public function VariableCustom($query_vars){
    //     $query_vars[] = 'mavariabletest';
    //     return $query_vars;
    // }

    // static public function LeBordel(){
    //     global $wpdb_rewrite;
    //     return $wpdb_rewrite->flush_rules();

    // }

    static public function jedeclaredesroutes() {
        add_rewrite_rule(
            PL_URL .'/id/([^/]*)/?$',
            'index.php?pagename='.PL_URL.'&mavariabletest=$matches[1]',
            'top'
        );
        return;
    }
    
    static public function jajouteunevariablecustom( $query_vars ) {
        $query_vars[] = 'mavariabletest';
        return $query_vars;
    }
    
    static public function prendencomptelebordel() {
        global $wp_rewrite;
        return $wp_rewrite->flush_rules();
    }


    public function addjs(){

        wp_register_script('insset', plugins_url(PL_PLUGIN_NAME .'/assets/js/PL_Front.js'), array('jquery-new'), PL_VERSION, true);
        wp_enqueue_script('insset');
        wp_localize_script('insset', 'inssetscript', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('ajax_nonce_security')
        ));
        return;
    }

}

?>