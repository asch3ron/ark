$(document).ready(function(){
	$(document).on('change', 'input', function()
	{
		var $this 				= $(this);
		var $parent 			= $this.parents('tr');
		var id_server 			= $('table[data-server-id]').attr('data-server-id');
		var id_configuration 	= $parent.attr('data-id');
		var value 				= $this.val();

		ajax( $parent, id_server, id_configuration, value );
	});

	$(document).on('change', 'select', function()
	{
		var $this 				= $(this);
		var $parent 			= $this.parents('tr');
		var id_server 			= $('table[data-server-id]').attr('data-server-id');
		var id_configuration 	= $parent.attr('data-id');
		var value 				= $this.val();

		ajax( $parent, id_server, id_configuration, value );
	});
});

function ajax( $parent, id_server, id_configuration, value )
{
	$.ajax({
		url 	: '/configuration/save/' + id_server + '/' + id_configuration + '/' + value,
		type 	: 'POST',
		dataType: 'json',
		data 	: {
			_token : $('input[name=_token]').val()
		},
		success : function(result)
		{
			if (result.success)
				success( $parent );
			else
				error( $parent );
		},
		error 	: function()
		{
			error( $parent );
		}
	});
}

function error( $parent )
{
	$parent.addClass('error')

	window.setTimeout(function(){
		$parent.removeClass('error');
	}, 1000);
}

function success( $parent )
{
	$parent.addClass('success')

	window.setTimeout(function(){
		$parent.removeClass('success');
	}, 1000);
}
