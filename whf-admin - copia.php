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
                'jobs_pages' => $page,
                'jobs_used' => 0,
                'jobs_herramientas' => $tools
                ), array('%s','%d') );
        ?>
            <div id="notifiy">El fichero: <?= $key ?> ha sido añadida, pag: <?= $page ?></div>
        <?php
    }
}
function superWHF_admin(){
    global $wpdb;
    ?>
    <div id="s-whf">
        <header id="main-header"><h1>Super WhiteHatFirm Plugin</h1></header>
        <main id="main-content">
            <div class="comandos"><a href="#whf-keys" class="boton primario open-modal">Nuevo fichero</a>
            <?php
                whf_confirmar();
            ?>
            </div>
            <div id="whf-keys" class="modal-r">
                <div class="center">
                    <form class="modal-content" action="" method="post" enctype="multipart/form-data">
                        <div class="whf-inputs">
                            <label><p>Generar llaves:</p>
                            <input type="text" name="jobs_keys" value="<?= rand() ?>" readonly="readonly"></label>
                        </div>
                        <div class="whf-inputs">
                            <label><p>Sitio web: http://</p>
                            <input type="text" name="jobs_page"></label>
                        </div>
                        <div class="whf-inputs">
                            <label><p>recursos:</p>
                            <textarea name="jobs_resource"></textarea></label>
                            <p>Separalas con comas(,) ejemplo: http://comindwork.com,http://otrosrecursos.com</p>
                        </div>
                        <input type="hidden" name="check">
                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <?php
}
function swhf_interface(){
    include('interface/todo.php');
}
function superWHF_jobs(){
    echo "probando";
    echo DB_USER;
}
?>