<?php
/*
Plugin Name: Super WhiteHatFirm
Description: Mejoras para WhiteHatFirm, para hacer que el cliente este mas cerca de los procesos de creacion.
Version: alpha 0.5.11
Author: McReiz
Author URI: http://fb.com/elReiz
*/
?>
<?php
    global $version_whf;
    $version_whf = "alpha 0.9.11"; 
    define('STYLE', plugins_url('SuperWHF/estilos/'));
    define('SCRIPT', plugins_url('SuperWHF/scripts/'));
    define('URLADMIN', admin_url('admin.php?page=super-whf&'));

    function superWHF_install(){
        global $wpdb;
        global $version_whf;

        $version_whf_db = get_option('version_whf');
        $whf_jobs = $wpdb->prefix. "whf_jobs";
        $whf_client = $wpdb->prefix. "whf_client";
        $whf_jobs_comment = $wpdb->prefix. "whf_jobs_comment";
        
        if($version_whf_db != $version_whf){
            $sql = "CREATE TABLE $whf_jobs (
                    jobs_id INT NOT NULL AUTO_INCREMENT,
                    jobs_keys VARCHAR(10) NOT NULL,
                    jobs_used INT NOT NULL,
                    jobs_page VARCHAR(40) NOT NULL,
                    jobs_cliente VARCHAR(40) NOT NULL,
                    jobs_herramientas TEXT NOT NULL,
                    jobs_progress INT NOT NULL,
                    PRIMARY KEY ( jobs_id ));";
            $wpdb->query($sql);
            $sql = "CREATE TABLE $whf_client (
                    jobs_client_id INT NOT NULL AUTO_INCREMENT,
                    jobs_client_user VARCHAR(10) NOT NULL,
                    jobs_client_pass VARCHAR(100) NOT NULL,
                    jobs_client_page VARCHAR(40) NOT NULL,
                    jobs_client_name VARCHAR(50) NOT NULL,
                    jobs_client_email VARCHAR(40) NOT NULL,
                    jobs_client_descri TEXT NOT NULL,
                    jobs_for_id INT NOT NULL,
                    PRIMARY KEY ( jobs_client_id ));";
            $wpdb->query($sql);
            $sql = "CREATE TABLE $whf_jobs_comment (
                    jobs_comment_id INT NOT NULL AUTO_INCREMENT,
                    jobs_comment_text TEXT NOT NULL,
                    jobs_comment_author VARCHAR(20) NOT NULL,
                    jobs_for_id INT NOT NULL,
                    PRIMARY KEY ( jobs_comment_id ));";
            $wpdb->query($sql);

            update_option('version_whf', $version_whf);
        }else{
            add_option('version_whf', $version_whf);
        }
    }

    add_action('plugins_loaded', 'superWHF_install');

    include('whf-admin.php');/* administracion */
    include('login-and-register.php'); /* page */
?>