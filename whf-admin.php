<?php 
/* scripts */
function styles_script(){
    wp_register_style('WHFStyle', STYLE. 'style.css', array(), '1.0');
    wp_enqueue_style('WHFStyle');
    wp_enqueue_script('jQuery', SCRIPT. 'jquery-1.11.0.min.js', array(), '1.11.0');
    wp_enqueue_script('globalScript', SCRIPT. 'globalScript.js', array(), '1.0');
}
add_action('admin_enqueue_scripts', 'styles_script');
/* MENUS */
function superWHF_menu(){
    add_menu_page('Super WHF', 'Super WHF >>', 'manage_options', 'super-whf', 'superWHF_admin'); /* principal*/
    add_submenu_page('super-whf', 'trabajos','Trabajo','manage_options', 'super-whf-jobs','superWHF_jobs');
}
add_action('admin_menu','superWHF_menu');

/* REGISTRAR 
function register_superWHF_admin(){
    register_setting('swhf_setting','whf_keys');
}
add_action('admin_init', 'register_superWHF_admin');

<?= get_option('whf_keys'); ?>
*/
/* KEYS */
function whf_confirmar(){
    global $wpdb;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    
    if(isset($_POST['check'])){
        $key = $_POST['jobs_keys'];
        $page = htmlentities($_POST['jobs_page']);
        $tools = $_POST['jobs_resource'];
        $wpdb->insert($whf_jobs, array(
                'jobs_keys' => $key,
                'jobs_used' => 0,
                'jobs_page' => $page
                ), array('%s','%d') );
        ?>
            <div id="notifiy">File: <?= $key ?> has been added, site: <?= $page ?></div>
        <?php
    }
}
function superWHF_admin(){
    global $wpdb;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    ?>
    <div id="s-whf">
        <header id="main-header"><h1>Super WhiteHatFirm Plugin</h1></header>
        <main id="main-content">
            <?php if(isset($_GET['jobs-id'])){
                inc_e('jobs-profile');
            }else{
                inc_e('jobs-list');
            }
            ?>
        </main>
    </div>
    <?php
}
?>