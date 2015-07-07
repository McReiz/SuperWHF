<?php
    global $wpdb;
    global $wp_session;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    $for_id = $_GET['jobs-id'];

    $queryj = $wpdb->get_row("SELECT * FROM $whf_jobs WHERE jobs_id = '$for_id'", ARRAY_A);
    $jobs_id_check = $queryj['jobs_client_id'];
    if($jobs_id_check == $wp_session['w-my-id']){
    
?>
    <h2 class="w-page-title"><?= $queryj['jobs_page'] ?></h2>

    <!-- PROGRESS --->
    <div class="sec w-progress">
        <h3>Page progress: </h3>
        <div class="marco">
            <div class="w-progress-i" style="width: <?= $queryj['jobs_progress'] ?>%"><img src="<?= IMG ?>logi.png" class="icon" width="50px" height="35px"></div>
            <div class="w-progress-t"><?= $queryj['jobs_progress'] ?>%</div>
        </div>
    </div>
    <!-- RESOURCE -->
    <div class="sec resource">
        <h3 class="w-tittle">Resource</h3>
        <div>
            <?php
            $whf_jobs_resource = $wpdb->prefix. "whf_jobs_resource";
            $query = $wpdb->get_results("SELECT * FROM $whf_jobs_resource WHERE jobs_for_id = $for_id ORDER BY jobs_res_id DESC", ARRAY_A);
                foreach($query as $row){
                ?>
                    <div class="rest">
                        <a href="<?= $row['jobs_res_link'] ?>" target="_blank"><?= $row['jobs_res_name'] ?></a>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
    <!-- LOG -->
    <div class="sec log">
        <h3 class="w-title">daily:</h3>
        <div id="comments">
            
            <?php
            $jobs_comment = $wpdb->prefix. "whf_jobs_comment";
            $query = $wpdb->get_results("SELECT * FROM $jobs_comment WHERE jobs_for_id = $for_id ORDER BY jobs_comment_id DESC", ARRAY_A);

            foreach($query as $row){
                ?>
                    <div class="w-comment">
                        <div class="contenido"><?= $row['jobs_comment_text']; ?></div>
                        <div class="datos">
                            <div class="author">Author: <?= $row['jobs_comment_author'] ?></div>
                            <div class="date">Date: <?= $row['jobs_comment_date'] ?></div>
                        </div>
                    </div>
                <?
            }

            ?>
        </div>
    </div>
<?php
}else{
    echo "Esto no es para ti";
}
?>
