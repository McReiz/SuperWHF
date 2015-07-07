<?php
function whf_config_option(){
    if(isset($_POST['w-enviar'])){
        $reg = $_POST['reg'];
        $reg_whf = get_option('whf_config_red');
        if($reg != $reg_whf){
            add_option('whf_config_red', $reg);
            update_option('whf_config_red', $reg);
            ?>
                <div class="notifiy success">Changes saved successfully</div>
            <?php
        }else{
            ?><div class="notifiy error">It has not done any change</div><?php
        }
    }
    
    if(isset($_POST['w-ch-enviar'])){
        $reg = $_POST['reg'];
        $reg_whf = get_option('whf_livech_link');
        if($reg != $reg_whf){
            add_option('whf_livech_link', $reg);
            update_option('whf_livech_link', $reg);
            ?>
                <div class="notifiy success">Changes saved successfully</div>
            <?php
        }else{
            ?><div class="notifiy error">It has not done any change</div><?php
        }
    }
}

function whf_config_form(){
    ?>
        <div id="s-whf">
            <header id="main-header"><h1>Super WhiteHatFirm Plugin</h1></header>
            <main id="main-content">
                <div class="comandos"><?php whf_config_option() ?></div>
                <form action="" method="post">
                    Where do redirecional then register or connect?
                    <input type="text" name="reg" value="<?= get_option('whf_config_red') ?>">
                    <input type="hidden" name="w-enviar">
                    <input type="submit" class="boton primario">
                </form>
                <form action="" method="post">
                    Insert the live chat link
                    <input type="text" name="reg" value="<?= get_option('whf_livech_link') ?>">
                    <input type="hidden" name="w-ch-enviar">
                    <input type="submit" class="boton primario">
                </form>
                <div>
                    <h3>Short code: </h3>
                    <b style="font-weight:bold;">Register: </b>[formRegister] <br>
                    <b style="font-weight:bold;">Log in: </b>[formLogin] <br>
                    <b style="font-weight:bold;">Log out: </b>[session-exit] <br>
                </div>
            </main>
    <?php
}
function livech_wp(){
    ?>
        <iframe class="livecht-w" src="<?= get_option('whf_livech_link') ?>"></iframe>        
    <?php
}
?>
