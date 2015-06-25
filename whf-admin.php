<?php 
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
function superWHF_admin(){
    if(isset($_POST['whf_keys'])){
        $key = $_POST['whf_keys'];
        ?>
            <div id="notifiy">La key:<?= $key ?> ha sido añadida</div>
        <?php
    }else{
        ?>
            <form id="whf-keys" action="" method="post" enctype="multipart/form-data">
                <div class="whf-inputs">
                    <label>
                        <span>Generar llaves:</span>
                        <input type="text" name="whf_keys" placeholder="Keys">
                    </label>
                </div>
                <?php submit_button(); ?>
            </form>
        <?php
    }
}
function superWHF_jobs(){
    echo "probando";
}
?>