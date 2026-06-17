//Verificacion que las contraseñas sean iguales
$(document).on('keyup', "#confirmpass", function(e){
	e.preventDefault();
	let pass = $("#confirmpass").val();
	if(pass === $("#newpass").val()){
		$("#newpass").removeClass('is-invalid');
		$("#confirmpass").removeClass('is-invalid');
		$("#newpass").addClass('is-valid');
		$("#confirmpass").addClass('is-valid');
		$("button[type=submit]").removeAttr('disabled');
	}
	else if($("#newpass").val().length < 1 || $("#confirmpass").val().length < 1){
		$("#newpass").removeClass('is-invalid');
		$("#confirmpass").removeClass('is-invalid');
		$("#newpass").removeClass('is-valid');
		$("#confirmpass").removeClass('is-valid');
		$("button[type=submit]").removeAttr('disabled');
	}
	else{
		$("#newpass").addClass('is-invalid');
		$("#confirmpass").addClass('is-invalid');
		$("button[type=submit]").attr('disabled', 'true');
	}
});

$(document).on("submit", '#recoverPassword', function(e){
	e.preventDefault();
	$.ajax({
		url:"/changepassword",
		method:"POST",
		data:{data:btoa(JSON.stringify({
			"username":$("#username").val(),
			"newpass" :$("#newpass").val()
		}))},
		beforeSend: function(){
			$("button[type=submit]").attr('disabled', 'true');		
		}
	}).then((response) =>{
		Swal.fire({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			type: 'success',
        	title: response.message,
		});
		window.location = '/';
	}).catch((request) => {
		Swal.fire({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			type: 'warning',
        	title: request.message,
		});
	});
});