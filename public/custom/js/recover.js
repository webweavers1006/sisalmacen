$(document).on('change', '#email',function(e){
	let texto = $("#email").val();
	if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(texto)){
		$("button[type=submit]").removeClass('is-valid');
		$("#email").addClass('is-invalid');
		$("button[type=submit]").attr('disabled', 'true');
	}
	else if(texto.lenght < 5){
		$("#email").removeClass('is-invalid');
		$("#email").removeClass('is-valid');
		$("button[type=submit]").removeAttr('disabled');
	}
	else{
		$("#email").removeClass('is-invalid');
		$("#email").addClass('is-valid');
		$("button[type=submit]").removeAttr('disabled');	
	}
});
//Generacion de correo de recuperacion
$(document).on('submit', '#recover-pass', function(e){
	e.preventDefault();
	let datos = { "email": $("#email").val()}
	$.ajax({
		url:"/sendEmail",
		method:"POST",
		data: {data:btoa(JSON.stringify(datos))},
		dataType:"JSON",
		beforeSend:function(){
			$("button[type=submit]").attr('disabled',"true");
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
		$("button[type=submit]").removeAttr('disabled');
	}).catch((request) => {
		Swal.fire({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			type: 'error',
			title: request.message,
		});
		$("button[type=submit]").removeAttr('disabled');
	});
});