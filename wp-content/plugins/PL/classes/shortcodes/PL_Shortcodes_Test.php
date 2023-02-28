<?php

add_shortcode('PL_TEST', array('PL_Shortcodes_Test', 'test'));

class PL_Shortcodes_Test {
    static public function test() {
        var_dump(get_query_var('mavariabletest'));
    }
}

?>