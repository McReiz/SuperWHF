<?php
    global $wpdb;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    $for_id = $_GET['jobs-id'];
    $query = $wpdb->get_results("SELECT * FROM $whf_jobs WHERE jobs_client_id = '$for_id' ORDER BY jobs_id DESC", ARRAY_A);

?>
<div class="comandos"><a href="#whf-keys" class="boton primario open-modal">New Page</a>
<?php
    whf_confirmar();
?>
</div>
<div id="whf-keys" class="modal-r">
    <div class="center">
        <form class="modal-content" action="" method="post" enctype="multipart/form-data">
            
            <div class="whf-inputs">
                <label><p>website: (Do not include http://)</p>
                <input type="text" name="jobs_page"></label>
            </div>
            <input type="hidden" name="check">
            <?php submit_button(); ?>
        </form>
    </div>
</div>
<div id="jobs">
    
    <div class="head">
        <div class="administrar"></div>
        <div class="sitio">Website: </div>
        <div class="progreso">Progress: </div>
    </div>
    <?php
        foreach($query as $row){
            ?> 
            <div class="items <?php if($row['jobs_used'] == 1){echo "used";}else{echo "no-use";} ?> <?php if($row['jobs_progress'] == 100){echo "terminado";} ?>">
                <div class="administrar"><a href="<?= URLADMIN ?>jobs-id=<?= $for_id ?>&jobs-page-id=<?= $row['jobs_id'] ?>">Manager &#187;</a></div>
                <div class="sitio"><?= $row['jobs_page'] ?></div>
                <div class="progreso"><?= $row['jobs_progress'] ?></div>
            </div>
            <?php
        }
    ?>
</div>