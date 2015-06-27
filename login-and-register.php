<?php 
function formLogin_WHF(){
    if(!(current_user_can('level_0'))){
        wp_login_form();
    }else{
        $user_info = get_userdata(get_current_user_id());
        echo 'Usuario: ' . $user_info->user_login . "\n";
        echo 'User roles: ' . implode(', ', $user_info->roles) . "\n";
        echo 'User ID: ' . $user_info->ID . "\n";
    }
}
function formRegister_WHF(){
    //wp_register_form();

}
add_shortcode( 'formLogin', 'formLogin_WHF' );
add_shortcode( 'formRegister', 'formRegister_WHF' );
?>