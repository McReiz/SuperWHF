<div class="comandos"><a href="#whf-keys" class="boton primario open-modal">New order</a>
<?php
    whf_confirmar();
?>
</div>
<div id="whf-keys" class="modal-r">
    <div class="center">
        <form class="modal-content" action="" method="post" enctype="multipart/form-data">
            <div class="whf-inputs">
                <label><p>Generate keys:</p>
                <input type="text" name="jobs_keys" value="<?= mt_rand() ?>" readonly="readonly"></label>
            </div>
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
    <?php global $wpdb;
    $whf_jobs = $wpdb->prefix. "whf_jobs";
    ?>
    <div class="head">
        <div class="administrar"></div>
        <div class="sitio">Website: </div>
        <div class="cliente">Customer: </div>
        <div class="key">Keys: </div>
        <div class="progreso">Progress: </div>
    </div>
    <?php
    
    $query = $wpdb->get_results("SELECT * FROM $whf_jobs ORDER BY jobs_id DESC", ARRAY_A);
        
        foreach($query as $row){
            ?> 
            <div class="items <?php if($row['jobs_used'] == 1){echo "used";}else{echo "no-use";} ?> <?php if($row['jobs_progress'] == 100){echo "terminado";} ?>">
                <div class="administrar"><a href="<?= URLADMIN ?>jobs-id=<?= $row['jobs_id'] ?>">Manager &#187;</a></div>
                <div class="sitio"><?= $row['jobs_page'] ?></div>
                <div class="cliente"><?= $row['jobs_cliente'] ?></div>
                <div class="key"><?= $row['jobs_keys'] ?> (<?php if($row['jobs_used'] == 1){echo "used";}else{echo "no use";} ?>)</div>
                <div class="progreso"><?= $row['jobs_progress'] ?></div>
            </div>
            <?php
        }
    ?>
</div>