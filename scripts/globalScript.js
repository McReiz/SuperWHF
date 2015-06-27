
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
$(document).ready( function(){
	modal();
});