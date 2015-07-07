
function modal(){
	$('.open-modal').on('click',function(){
		var revela = $(this).attr('href');
		var oculta = $('.center .modal-content');
		$(revela).show(300);

		oculta.off('click', function(){
			$(revela).hide(300);
		});
	});
}
function progress(){
    valor = $('input[name="progress-value"]').val();
    $('.value-progess').text(valor);
}
function submitform(){
    $('#up-progress').submit();
    $('#up-progress').submit(function(event){
		event.preventDefault();
        var url = $(this).attr('action');
		var dataVa = $(this).serialize();
        
        $.ajax({
			url: url,
			type: 'POST',
			data: dataVa,
			success: function (mensaje) {
				
			}
		});
        return false;
	});
}
$(document).ready( function(){
	modal();
    progress();
    $('input[name="progress-value"]').on('input', function(){
        progress();
        //submitform();
        return false;
    });
    $('#notifiy').fadeOut(7000);
});
