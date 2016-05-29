$(document).ready(function(){
	$(document).on('click', '.server', function()
	{
		var $this 				= $(this);
		var id_server 			= $this.attr('data-id');

		window.location.href	= '/configuration/' + id_server;
	});
});
