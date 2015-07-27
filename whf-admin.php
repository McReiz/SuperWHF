<?php 


function whf_confirmar(){
    global $wpdb;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    $for_id = $_GET['jobs-id'];
    
    if(isset($_POST['check'])){
        $key = $_POST['jobs_keys'];
        $page = htmlentities($_POST['jobs_page']);

        $wpdb->insert($whf_jobs, array(
            'jobs_page' => $page,
            'jobs_client_id' => $for_id
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
            <?php 
            if(isset($_GET['jobs-id'])){
                if(isset($_GET['jobs-page-id'])){
                    inc_e('jobs-profile');
                }else{
                    inc_e('jobs-list');
                }
            }else{
                inc_e('jobs-client-list');
            }
            ?>
        </main>
    </div>
    <?php
}
?>