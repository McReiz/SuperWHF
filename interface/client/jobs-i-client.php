<?php
    global $wpdb;
    global $wp_session;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    $for_id = $wp_session['for-id'];

    $queryj = $wpdb->get_row("SELECT * FROM $whf_jobs WHERE jobs_id = '$for_id'", ARRAY_A);

?>
    <h2 class="w-page-title"><?= $queryj['jobs_page'] ?></h2>

    
    <div class="sec w-progress">
        <h3>Page progress: </h3>
        <div class="marco">
            <div class="w-progress-i" style="width: <?= $queryj['jobs_progress'] ?>%"></div>
            <div class="w-progress-t"><?= $queryj['jobs_progress'] ?>%</div>
        </div>
    </div>

    <div class="sec log">
        <h3 class="w-title">daily:</h3>
        <div id="comments">
            
            <?php
            $jobs_comment = $wpdb->prefix. "whf_jobs_comment";
            $query = $wpdb->get_results("SELECT * FROM $jobs_comment WHERE jobs_for_id = $for_id ORDER BY jobs_comment_id DESC", ARRAY_A);

            foreach($query as $row){
                ?>
                    <div class="comment">
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
