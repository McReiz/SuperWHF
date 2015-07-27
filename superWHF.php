<?php
/*
Plugin Name: Super WhiteHatFirm
Description: Mejoras para WhiteHatFirm, para hacer que el cliente este mas cerca de los procesos de creacion. Requiere WP SESSION MANAGER para funcionar.
Version: beta 2.8
Author: McReiz
Author URI: http://fb.com/elReiz
*/
?>
<?php
    global $version_whf;
    //global $reg;
    //$reg = "";
    $version_whf = "beta 2.8"; 
    define('STYLE', plugins_url('SuperWHF/estilos/'));
    define('SCRIPT', plugins_url('SuperWHF/scripts/'));
    define('IMG', plugins_url('SuperWHF/images/'));
    define('URLADMIN', admin_url('admin.php?page=super-whf&'));

    //  PLUGIN WP_SESSION_MANAGER
    // let users change the session cookie name
    if( ! defined( 'WP_SESSION_COOKIE' ) )
        define( 'WP_SESSION_COOKIE', '_wp_session' );

    if ( ! class_exists( 'Recursive_ArrayAccess' ) ) {
        include( plugin_basename('/session/class-recursive-arrayaccess.php') );
    }

    // Only include the functionality if it's not pre-defined.
    if ( ! class_exists( 'WP_Session' ) ) {
        include( plugin_basename('/session/class-wp-session.php') );
        include( plugin_basename('/session/wp-session.php') );
    }


    function superWHF_install(){
        global $wpdb;
        global $version_whf;

        $version_whf_db = get_option('version_whf');
        $whf_jobs = $wpdb->prefix. "whf_jobs";
        $whf_client = $wpdb->prefix. "whf_client";
        $whf_jobs_comment = $wpdb->prefix. "whf_jobs_comment";
        $whf_jobs_resource = $wpdb->prefix. "whf_jobs_resource";
        $whf_rank_list = $wpdb->prefix. "whf_rank_list";
        
        if($version_whf_db != $version_whf){
            /* crear la tabla del fichero */
            $sql = "CREATE TABLE $whf_jobs (
                    jobs_id INT NOT NULL AUTO_INCREMENT,
                    jobs_page VARCHAR(40) NOT NULL,
                    jobs_client_id INT NOT NULL,
                    jobs_progress INT NOT NULL,
                    PRIMARY KEY ( jobs_id ));";
            $wpdb->query($sql);
            
            /* Crear la tabla del usuario */
            $sql = "CREATE TABLE $whf_client (
                    jobs_client_id INT NOT NULL AUTO_INCREMENT,
                    jobs_client_user VARCHAR(10) NOT NULL,
                    jobs_client_pass VARCHAR(100) NOT NULL,
                    jobs_client_name VARCHAR(50) NOT NULL,
                    jobs_client_email VARCHAR(40) NOT NULL,
                    jobs_client_rank VARCHAR(10) NOT NULL,
                    jobs_client_descri TEXT NOT NULL,
                    jobs_for_id INT NOT NULL,
                    PRIMARY KEY ( jobs_client_id ));";
            $wpdb->query($sql);
            
            /* crear la tabla de los comentarios */
            $sql = "CREATE TABLE $whf_jobs_comment (
                    jobs_comment_id INT NOT NULL AUTO_INCREMENT,
                    jobs_comment_text TEXT NOT NULL,
                    jobs_comment_author VARCHAR(20) NOT NULL,
                    jobs_comment_date VARCHAR(30) NOT NULL,
                    jobs_for_id INT NOT NULL,
                    PRIMARY KEY ( jobs_comment_id ));";
            $wpdb->query($sql);
            
            /* crear la tabla de los recursos */
            $sql = "CREATE TABLE $whf_jobs_resource (
                    jobs_res_id INT NOT NULL AUTO_INCREMENT,
                    jobs_res_name VARCHAR(20) NOT NULL,
                    jobs_res_link VARCHAR(40) NOT NULL,
                    jobs_for_id INT NOT NULL,
                    PRIMARY KEY ( jobs_res_id ));";
            $wpdb->query($sql);

            /* crear tabla de rangos */
            $sql = "CREATE TABLE $whf_rank_list (
                   jobs_rank_id INT NOT NULL AUTO_INCREMENT,
                   jobs_rank_name VARCHAR(10) NOT NULL,
                   jobs_rank_permission TEXT NOT NULL,
                   PRIMARY KEY ( jobs_rank_id ));";
            $wpdb->query($sql);

            update_option('version_whf', $version_whf);
        }else{
            add_option('version_whf', $version_whf);
            //add_option('whf_config_red', $reg);
        }
    }
    add_action('plugins_loaded', 'superWHF_install');
    
    function whf_ins_session(){
        global $wp_session;
        $wp_session = WP_Session::get_instance();
    }
    add_action('init', 'whf_ins_session');

    function inc_e($arch){
        include(plugin_basename('/interface/admin/'.$arch.'.php'));
    }
    function inc_c($arch){
        include(plugin_basename('/interface/client/'.$arch.'.php'));
    }
    
    /* script y styles */ 
    function admin_styles_script(){
        wp_register_style('WHFStyle', STYLE. 'admin.css', array(), '1.0');
        wp_enqueue_style('WHFStyle');
        wp_enqueue_script('jQuery', SCRIPT. 'jquery-1.11.0.min.js', array(), '1.11.0');
        wp_enqueue_script('globalScript', SCRIPT. 'globalScript.js', array(), '1.0');
    }
    add_action('admin_enqueue_scripts', 'admin_styles_script');

    function client_style_script(){
        wp_register_style('WHFStyle', STYLE. 'style.css', array(), '1.0');
        wp_enqueue_style('WHFStyle');
    }
    add_action('wp_enqueue_scripts','client_style_script');
    /* MENUS */
    function superWHF_menu(){
        add_menu_page('Super WHF', 'Super WHF >>', 'manage_options', 'super-whf', 'superWHF_admin'); /* principal*/
        add_submenu_page('super-whf', 'Config','Config','manage_options', 'whf_config_form','whf_config_form');
        add_menu_page('Live Chat Support', 'Live Chat>>', 'manage_options', 'livechat', 'livech_wp');
    }
    add_action('admin_menu','superWHF_menu');
    
    include('whf-admin.php');/* administracion */
    include('login-and-register.php'); /* page */
    include('whf-config.php');/* Configuracion global */

?>