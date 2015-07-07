<?php
    global $wpdb;
    global $wp_session;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    $for_id = $_GET['jobs-id'];

    $queryj = $wpdb->get_row("SELECT * FROM $whf_jobs WHERE jobs_id = '$for_id'", ARRAY_A);
    $my_id = $wp_session['w-my-id'];
?>
<div>
    <h2 class="w-page-title">Your websites</h2>
    
    <div class="sec list-page">
        <div class="w-list-page">
            <div class="head">
                <div class="w-t-website">Website:</div>
                <div class="w-t-progress">Progress:</div>
                <div class="w-t-view"></div>
            </div>
            
                <?php 
                $query = $wpdb->get_results("SELECT * FROM $whf_jobs WHERE jobs_client_id = $my_id ORDER BY jobs_id DESC", ARRAY_A);
                foreach($query as $row){
                ?>
            <div class="item">
                <div class="w-t-website"><?= $row['jobs_page'] ?></div>
                <div class="w-t-progress"><?= $row['jobs_progress'] ?>%</div>
                <div class="w-t-view">
                    <a href="<?= get_option('whf_config_red') ?>?jobs-id=<?= $row['jobs_id'] ?>">View progress</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>