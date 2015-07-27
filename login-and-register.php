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

            <input type="submit" value="Submit"> 
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
        $w_pass = md5($_POST['w-pass']);

        if(empty($w_user) || empty($w_pass)){
            ?>
                <div class="notify-w error">Please fill out all the forms</div>
            <?php
            form_login();
        }else{
            $queryc = $wpdb->get_row("SELECT * FROM $whf_client WHERE jobs_client_user = '$w_user' AND jobs_client_pass = '$w_pass'", ARRAY_A);
            $w_my_id = $queryc['jobs_client_id'];
            $w_for_id = $queryc['jobs_for_id'];
            $w_user_check = $queryc['jobs_client_user'];
            $w_pass_check = $queryc['jobs_client_pass'];
            
            if($w_user == $w_user && $w_pass_check == $w_pass){
                ?><div class="notify-w success">You are connected</div><?
                $wp_session['connet'] = 1;
                $wp_session['w-my-id'] = $w_my_id;
                $wp_session['w-user'] = $w_user_check;
                $wp_session['for-id'] = $w_for_id;
                
                echo $wp_session['w-user'];
                
                $redirigir = get_option('whf_config_red');
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

        global $wp_session;

        if(isset($wp_session['connet'])){
            $my_id = $wp_session['w-my-id'];
            $w_usuario = $wp_session['w-user'];
            $for_id = $wp_session['for-id'];
            
            if(isset($_GET['jobs-id'])){
                inc_c('jobs-profile-client');
            }else{
                inc_c('jobs-list-client');
            }
        }else{
            form_login_set();
        }
    ?>
    </div>
    <?php
}
/*
    //
    // Registrarse:
    //
*/

function form_register(){
    ?>
    <form action="" method="post">
        <div class="inputs">
            <label>
                <span>Users:</span>
                <input type="text" name="w-user">
            </label>
        </div>

        <div class="inputs">
            <label>
                <span>Email:</span>
                <input type="email" name="w-email">
            </label>
        </div>
        <div class="inputs">
            <label>
                <span>Password:</span>
                <input type="password" name="pass-w">
            </label>
        </div>
        <div class="inputs">
            <label>
                <span>Confirm Password:</span>
                <input type="password" name="pass-w-clave1">
            </label>
        </div>
        <div class="inputs">
            <label>
                <span>Name:</span>
                <input type="text" name="w-name">
            </label>
        </div>
        
        <input type="hidden" name="confirmn">
        <input type="submit" value="Submit">
    </form>
    <?php
}
function whf_register(){
    global $wpdb;
    $whf_client = $wpdb->prefix. "whf_client";
    $whf_jobs = $wpdb->prefix. "whf_jobs";

    if(isset($_POST['confirmn'])){
        $w_user = htmlentities($_POST['w-user']);
        $w_pass = md5(htmlentities($_POST['pass-w']));
        $w_pass_check = md5(htmlentities($_POST['pass-w-clave1']));
        $w_email = htmlentities($_POST['w-email']);
        $w_name = htmlentities($_POST['w-name']);

        if(empty($w_user) or empty($w_pass) or empty($w_email) or empty($w_name)){
            ?><div class="notify-w error">Please fill out all the forms</div><?php
            form_register();
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
                    form_register();
                }else{
                    $enviar = $wpdb->insert($whf_client, array(
                        'jobs_client_user' => $w_user,
                        'jobs_client_pass' => $w_pass,
                        'jobs_client_name' => $w_name,
                        'jobs_client_email' => $w_email,
                        'jobs_client_rank' => 'rank_c'
                    ));
                    if($enviar){
                        ?>
                            <div class="notify-w success">Successful Registration</div>
                            <a href="<?= get_option('whf_config_red') ?>">It runs! log in</a>
                        <?php
                        $to = get_option('whf_email');
                        $subject = '[WhiteHatFirm] new registered user';
                        $body = 'User: {$w_user} <br>Name: {$w_name} <br> Email: {$w_mail}<br>';
                        $headers = array('Content-Type: text/html; charset=UTF-8');

                        wp_mail( $to, $subject, $body, $headers );
                    }else{
                        ?>ERROR INESPERADO DE LA BASE DE DATOS<?php
                    }
                }
            }
        }
    }else{
        form_register();
    }
}
function limpiar_session(){
    global $wp_session;

    unset($wp_session['connect']);
    unset($wp_session['w-user']);

    wp_session_unset();
}
add_shortcode( 'session-exit', 'limpiar_session' );
add_shortcode( 'formLogin', 'formLogin_WHF' );
add_shortcode( 'formRegister', 'whf_register' );
?>