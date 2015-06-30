<?php 
function formLogin_WHF(){
    if(!(current_user_can('level_0'))){
        // el usuario comun debe pasar por todas las pautas para entrar
    }else{
        // el usuario wordpress no 
    }
}

/*
    //
    // Registrarse:
    //
*/

function form_register($key_id, $key, $page){
    ?>
    <form action="" method="post">
        Usuarios:
        <input type="text" name="w-user"><br>
        Email:
        <input type="email" name="w-email"><br>
        Clave:
        <input type="password" name="pass-w"><br>
        Confirmar clave:
        <input type="password" name="pass-w-clave1"><br>
        Nombre:
        <input type="text" name="w-name"><br>

        <input type="hidden" name="key-id" value="<?= $key_id ?>">
        <input type="hidden" name="key" value="<?= $key ?>">
        <input type="hidden" name="page" value="<?= $page ?>">
        
        <input type="hidden" name="confirmn">
        <input type="submit" value="Enviar">
    </form>
    <?php
}
function whf_register($key_id, $used, $page){
    global $wpdb;
    $whf_client = $wpdb->prefix. "whf_client";
    $whf_jobs = $wpdb->prefix. "whf_jobs";

    if(isset($_POST['confirmn'])){
        $w_user = htmlentities($_POST['w-user']);
        $w_pass = htmlentities($_POST['pass-w']);
        $w_email = htmlentities($_POST['w-email']);
        $w_name = htmlentities($_POST['w-name']);
        $w_page = htmlentities($_POST['page']);
        $for_id = htmlentities($_POST['key-id']);

        $key2 = htmlentities($_POST['key']);

        $queryc = $wpdb->get_row("SELECT * FROM $whf_client WHERE jobs_client_user = '$w_user' or jobs_client_email = '$w_email'", ARRAY_A);
        echo $queryc['jobs_client_user'];
        echo $queryc['jobs_client_email'];
        echo $w_name;
        if($queryc['jobs_client_user'] == $w_user or $queryc['jobs_client_email'] == $w_email){
            ?>
                <div class="notify-w error">the user name or email already exists</div>

            <?php
            form_register($for_id,$key2,$w_page);
        }else{
            $enviar = $wpdb->insert($whf_client, array(
                'jobs_client_user' => $w_user,
                'jobs_client_pass' => $w_pass,
                'jobs_client_page' => $w_page,
                'jobs_client_name' => $w_name,
                'jobs_client_email' => $w_email,
                'jobs_for_id' => $for_id
            ));
            $wpdb->update($whf_jobs, array(
                'jobs_used' => 1,
                'jobs_cliente' => $w_name
            ), array(
                'jobs_id' => $for_id
            ));
            if($enviar){
                echo "enviado";
            }else{
                form_register($for_id,$key2,$w_page);
            }
        }
    }else{
        form_register($key_id, $used, $page);
    }
}
function formRegister_WHF(){
    global $wpdb;
    global $wp_session;
    $whf_jobs = $wpdb->prefix. "whf_jobs";

    if(isset($_GET['key'])){
        $key = htmlentities($_GET['key']);

        $queryj = $wpdb->get_row("SELECT * FROM $whf_jobs WHERE jobs_keys = $key", ARRAY_A);
        $key_id = $queryj['jobs_id'];
        $used = $queryj['jobs_used'];
        $page = $queryj['jobs_page'];
        $key_check = $queryj['jobs_keys'];

        if($queryj){
            if($used == 0){
                ?>
                    <?php whf_register($key_id,$key_check,$page) ?>
                <?php
            }else{
                echo "the key was already used";
            }
        }else{
            echo "the entered key does not exist";
        }
    }else{
        ?>
        <form action="" method="get">
            <input type="text" name="key" placeholder="Introdusca tu key">
            <input type="submit" value="enviar">
        </form>
        <?php
    }
}
function limpiar_session(){
    global $wp_session;
    unset($wp_session['prueba']);
}
add_shortcode( 'fooo', 'formR' );
add_shortcode( 'formLogin', 'formLogin_WHF' );
add_shortcode( 'formRegister', 'formRegister_WHF' );
?>