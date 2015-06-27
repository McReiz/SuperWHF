
<form id="whf-keys" class="modal-r" action="" method="post" enctype="multipart/form-data">
	<div class="whf-inputs">
	    <label><span>Generar llaves:</span>
	    <input type="text" name="whf_keys" value="<?= rand() ?>"></label>
	</div>
	<div class="whf-inputs">
	    <label>Sitio web: http://<span></span>
	    <input type="text" name="whf_page"></label>
	</div>
	<div class="whf-inputs">
	    <label><span>recursos:</span>
	    <textarea name="herramientas"></textarea></label>
	    <span>Separalas con comas(,) ejemplo: http://comindwork.com,http://otrosrecursos.com</span>
	</div>
	<?php submit_button(); ?>
</form>