<?php 



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