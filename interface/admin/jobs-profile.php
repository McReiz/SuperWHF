<?php 
    global $wpdb;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    $client_id = $_GET['jobs-id'];
    $jobsid = $_GET['jobs-page-id'];
    $queryj = $wpdb->get_row("SELECT * FROM $whf_jobs WHERE jobs_id = '$jobsid'", ARRAY_A);
    date_default_timezone_set('UTC');

    function confirm_form(){
        global $wpdb;
        $jobs = $wpdb->prefix . 'whf_jobs_comment';
        $whf_jobs = $wpdb->prefix. "whf_jobs";
        $whf_jobs_resource = $wpdb->prefix. "whf_jobs_resource";
        $jobsid = $_GET['jobs-page-id'];
        /* insertar comentarios */
        if(isset($_POST['crea'])){
            $commend = $_POST['log'];
            $author = $_POST['author'];
            $fecha = $_POST['fecha'];
            
            $prueba = $wpdb->insert($jobs, array(
                'jobs_comment_text' => $commend,
                'jobs_comment_author' => $author,
                'jobs_comment_date' => $fecha,
                'jobs_for_id' => $jobsid
            ));
            if(!$prueba){
                ?> <div id="notifiy">Error</div> <?php
            }else{
                ?> <div id="notifiy">Success post update</div> <?php
            }
        }
        /* actualizar la barra de progreso */
        if(isset($_POST['progress'])){
            $progress = $_POST['progress-value'];
            
            $prueba = $wpdb->update($whf_jobs, 
            array(
                'jobs_progress' => $progress
            ),array(
                'jobs_id' => $jobsid
            ));
            
            if(!$prueba){
                echo "algun error $progress y $jobsid";
            }else{
                ?> <div id="notifiy">updated progress bar</div><?php
            }
        }
        if(isset($_POST['resource'])){
            $resource = $_POST['resource'];
            if($resource == "add"){
                $name = $_POST['nombre'];
                $link = $_POST['link'];
                $query = $wpdb->insert($whf_jobs_resource, array(
                    'jobs_res_name' => $name,
                    'jobs_res_link' => $link,
                    'jobs_for_id' => $jobsid
                ));
                if($query){
                    ?><div id="notifiy">Resource successfully added</div><?php
                }else{
                    ?><div id="notifiy">Error inesperado</div><?php
                }
            }
            if($resource == "del"){
                $id = $_POST['id'];
                $del = $wpdb->delete($whf_jobs_resource, array(
                    'jobs_res_id' => $id
                ));
                if($del){
                    ?>
                        <div id="notifiy">The resource to deleted</div>
                    <?php
                }else{
                    ?>
                        <div id="notifiy">Error inesperado</div>
                    <?php
                }
            }
        }
    }
?>
<div class="comandos"><a href="<?= URLADMIN ?>jobs-id=<?= $client_id ?>">&#171; Back to the list</a><?php confirm_form(); ?></div>
<section class="profile">
    <header>
        <h1><?= $queryj['jobs_page'] ?></h1>
    </header>
    <h2>Post Update:</h2>
    <form class="form-log" action="" method="post">
        <?php $user_info = get_userdata(get_current_user_id()); ?>
        <textarea name="log" placeholder="Post an update of the status of the project"></textarea>
        
        <input type="hidden" name="author" value="<?= $user_info->user_login ?>">
        <input type="hidden" name="fecha" value="<?= date('d M, o') ?>">
        <input type="hidden" name="crea" value="crea">
        <input class="button button-primary" type="submit" value="Post">
    </form>
    
    <div id="comments">
        <?php
        $jobs_comment = $wpdb->prefix. "whf_jobs_comment";
        $query = $wpdb->get_results("SELECT * FROM $jobs_comment WHERE jobs_for_id = $jobsid ORDER BY jobs_comment_id DESC", ARRAY_A);

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
</section>
<aside class="sidebar">
    <div id="box">
        <form action="" method="post" id="up-progress">
            <div id="cd" class="actualiza">
                <h3>Progress <span class="value-progess"></span>%</h3><input class="button button-primary" type="submit" value="Update">
            </div>
            <input name="progress-value" type="range" min="0" max="100" step="1" value="<?= $queryj['jobs_progress'] ?>">
            <input type="hidden" name="progress" value="reizestuboaqui">
        </form>
    </div>
    <div id="box">
        
            <h3>Resource:</h3>
            
            <form action="" method="post">
                <div id="resource">
                    <div>
                        <input type="text" name="nombre" placeholder="resource">
                        <input type="text" name="link" placeholder="http://resource.com">
                        <input type="hidden" name="resource" value="add">

                    </div>
                    <input class="button button-primary" type="submit" value="add">
                </div>
            </form>
            
            <div id="resource-2">
                <?php 
                    $whf_jobs_resource = $wpdb->prefix. "whf_jobs_resource";
                    $query = $wpdb->get_results("SELECT * FROM $whf_jobs_resource WHERE jobs_for_id = $jobsid ORDER BY jobs_res_id DESC", ARRAY_A);
                    foreach($query as $row){
                    ?>
                        <div class="rest">
                            <a href="<?= $row['jobs_res_link'] ?>" target="_blank"><?= $row['jobs_res_name'] ?></a>
                            <form action="" method="post">
                                <input type="submit" class="button button-primary" value="Delete">
                                <input type="hidden" name="id" value="<?= $row['jobs_res_id'] ?>">
                                <input type="hidden" name="resource" value="del">
                            </form>
                        </div>
                    <?
                    }
                ?>
            </div>
        
    </div>
</aside>