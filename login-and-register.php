<?php 

/* 
    //
    // Login
    //

*/
function form_login(){
    ?>
        <form action="" method="post">
            <div>
                <label>
                    <span>User:</span>
                    <input type="text" name="w-user">
                </label>
            </div>
            <div>
                <label>
                    <span>pass:</span>
                    <input type="password" name="w-pass">
                </label>
            </div>

            <input type="hidden" name="confirm">

            <input type="submit" value="Entrar"> 
        </form>
    <?php
}
function form_login_set(){
    global $wpdb;
    global $wp_session;

    $whf_client = $wpdb->prefix. "whf_client";
    $whf_jobs = $wpdb->prefix. "whf_jobs";

    if(isset($_POST['confirm'])){
        $w_user = $_POST['w-user'];
        $w_pass = $_POST['w-pass'];

        if(empty($w_user) || empty($w_pass)){
            ?>
                <div class="notify-w error">Please fill out all the forms</div>
            <?php
            form_login();
        }else{
            $queryc = $wpdb->get_row("SELECT * FROM $whf_client WHERE jobs_client_user = '$w_user' AND jobs_client_pass = '$w_pass'", ARRAY_A);
            $w_for_id = $queryc['jobs_for_id'];
            $w_user_check = $queryc['jobs_client_user'];
            $w_pass_check = $queryc['jobs_client_pass'];
            
            if($w_user == $w_user && $w_pass_check == $w_pass){
                ?><div class="notify-w success">You are connected</div><?
                $wp_session['connet'] = 1;
                $wp_session['w-user'] = $w_user_check;
                $wp_session['for-id'] = $w_for_id;

                $redirigir = "http://localhost/wordpress/login-2/";
                ?><a href="<?= $redirigir ?>">To panel</a><?php
            }else{
                ?><div class="notify-w error">invalid user or password</div><?php
                form_login();
            }
        }
    }else{
        form_login();
    }
}
function formLogin_WHF(){
    ?>
    <div class="content-w">
    <?php
    //if(!(current_user_can('level_0'))){
        global $wp_session;

        if(isset($wp_session['connet'])){
            $w_usuario = $wp_session['w-user'];
            $for_id = $wp_session['for-id'];
            
            inc_c('jobs-i-client');
        }else{
            form_login_set();
        }
    /*}else{
       // el usuario wordpress
    }*/
    ?>
    </div>
    <?php
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
        $w_pass_check = htmlentities($_POST['pass-w-clave1']);
        $w_email = htmlentities($_POST['w-email']);
        $w_name = htmlentities($_POST['w-name']);
        $w_page = htmlentities($_POST['page']);
        $for_id = htmlentities($_POST['key-id']);

        $key2 = htmlentities($_POST['key']);

        if(empty($w_user) or empty($w_pass) or empty($email) or empty($name)){
            ?><div class="notify-w error">Please fill out all the forms</div><?php
            form_register($key_id, $used, $page);
        }else{
            if($w_pass != $w_pass_check){
                ?><div class="notify-w error">password do not match</div><?php
            }else{
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
                        ?><div class="notify-w success">successful registration</div><?php
                    }else{
                        form_register($for_id,$key2,$w_page);
                    }
                }
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

    unset($wp_session['connect']);
    unset($wp_session['w-user']);

    wp_session_unset();
}
add_shortcode( 'fooo', 'limpiar_session' );
add_shortcode( 'formLogin', 'formLogin_WHF' );
add_shortcode( 'formRegister', 'formRegister_WHF' );
?>