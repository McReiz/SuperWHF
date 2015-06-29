<?php 
function formLogin_WHF(){
    if(!(current_user_can('level_0'))){
        // el usuario comun debe pasar por todas las pautas para entrar
    }else{
        // el usuario wordpress no 
    }
}
function whf_register(){
    global $wpdb;
    $whf_client = $wpdb->prefix. "whf_client";

    if(isset($_POST['confirmar'])){
        $user = htmlentities($_POST['user']);
        $pass = htmlentities($_POST['pass-w']);
        $email = htmlentities($_POST['email']);
        $name = htmlentities($_POST['name']);
        $page = htmlentities($_POST['page']);
        $for_id = htmlentities($_POST['key-id']);

        $key2 = htmlentities($_POST['key']);

        $queryc = $wpdb->get_row("SELECT * FROM $whf_client WHERE jobs_client_user = $name", ARRAY_A);
        if($queryc){
            echo '<div class="notify-w error">the user name already exists</div>';
        }else{
            $enviar = $wpdb->insert($whf_client, array(
                'jobs_client_user' => $user,
                'jobs_client_pass' => $pass,
                'jobs_client_page' => $page,
                'jobs_client_name' => $name,
                'jobs_client_email' => $email,
                'jobs_for_id' => $for_id
            ));
            if($enviar){
                echo "enviado";
            }else{
                echo "no nviado";
            }
        }
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
                    <?php whf_register(); ?>
                    <form action="" method="post">
                        Usuarios:
                        <input type="text" name="user"><br>
                        Email:
                        <input type="email" name="email"><br>
                        Clave:
                        <input type="password" name="pass-w"><br>
                        Confirmar clave:
                        <input type="password" name="pass-w-clave1"><br>
                        Nombre:
                        <input type="text" name="name"><br>

                        <input type="hidden" name="key-id" value="<?= $key_id ?>">
                        <input type="hidden" name="key" value="<?= $key ?>">
                        <input type="hidden" name="page" value="<?= $page ?>">
                        
                        <input type="hidden" name="confirmar">
                        <input type="submit" value="Enviar">


                    </form>
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
            <input type="text" name="key" placeholder="xD">
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