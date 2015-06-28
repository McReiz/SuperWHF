<?php 
function formLogin_WHF(){
    if(!(current_user_can('level_0'))){
        // el usuario comun debe pasar por todas las pautas para entrar
    }else{
        // el usuario wordpress no 
    }
}
function formRegister_WHF(){
    global $wp_session;
    ?>
    <form action="" method="get">
        <input type="text" name="prueba" placeholder="xD">
        <input type="submit" value="enviar">
    </form>
    <?php
    if(isset($_GET['prueba'])){
        $prueba = $_GET['prueba'];
        $wp_session['prueba'] = $prueba;
        echo $wp_session['prueba'];
    }
}
function formR(){
    global $wp_session;
    echo $wp_session['prueba'];
}
add_shortcode( 'fooo', 'formR' );
add_shortcode( 'formLogin', 'formLogin_WHF' );
add_shortcode( 'formRegister', 'formRegister_WHF' );
?>