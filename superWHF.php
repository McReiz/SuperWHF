<?php
/*
Plugin Name: Super WhiteHatFirm
Description: Mejoras para WhiteHatFirm, para hacer que el cliente este mas cerca de los procesos de creacion.
Version: alpha 0.5.104
Author: McReiz
Author URI: http://fb.com/elReiz
*/
?>


<?php
    global $version_whf;
    $version_whf = "alpha 0.5.105";
    
   
    function superWHF_install(){
        global $wpdb;
        global $version_whf;
        
        $version_whf_db = get_option('version_whf');
        $whf_keys = $wpdb->prefix. "whf_keys";
        
        //$check = $wpdb->get_var("SHOW TABLES LIKE '".$whf_keys."'");
        
        //if($check != $whf_keys ||  $version_whf_db != $version_whf ) {
        if($version_whf_db != $version_whf){  
            $sql = "CREATE TABLE {$whf_keys} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            key text NOT NULL,
            use text NOT NULL,
            PRIMARY KEY (id)
            )";
            
            require_once(ABSPATH.'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            
            update_option('version_whf', $version_whf);
        }else{
            add_option('version_whf', $version_whf);
        }
    }
    register_activation_hook(__FILE__, 'superWHF_install');

    include('whf-admin.php');/* administracion */
    include('login-and-register.php'); /* page */
?>