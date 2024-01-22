$(document).ready(function(){


//  modal
 var modal_cambiar_contrasena = $("#modal-cambiar-contraseña");
 // Obtén el botón que abre el modal
var btn_cambiar_contrasena = $(".cambiar-contrasena");

// Cuando el usuario hace clic en el botón, abre el modal
btn_cambiar_contrasena.click(function() {
  modal_cambiar_contrasena.css("display", "block");
});

// cambiar la contraseña
$('#form-pass').submit(e => {
  let oldpass = $('#oldpass').val();
  let newpass = $('#newpass').val();
  funcion = 'cambiar_contra';
  $.post('../controllers/usuario.php', {
      funcion,
      oldpass,
      newpass
  }, (response) => {
      // console.log(response)
      response = response.trim();
      if (response == 'update') {
          $('#update').hide('slow');
          $('#update').show(1000);
          $('#update').hide(2000);
          $('#form-pass').trigger('reset');

      } else {
          $('#noupdate').hide('slow');
          $('#noupdate').show(1000);
          $('#noupdate').hide(2000);
          $('#form-pass').trigger('reset');

      }


  })
  e.preventDefault();

})



$("#btn-cerrar-modal-cambir-pass").click(function(){
  modal_cambiar_contrasena.css("display", "none");
})


// Obtén el elemento <span> que cierra el modal
var cerrar = $(".close");
cerrar.click(function() {
  let modal_cambiar_avatar = $("#modal-cambiar-avatar");
  let modal_crear_usuario = $("#modal-crear-usuario");
  let modal_confirmar_deshabilitar_usu = $("#modal-confirmar-deshabilitar-usu");
  let modal_confirmar_habilitar_usu = $("#modal-confirmar-habilitar-usu");
  let modal_confirmar_eliminar = $("#modal-confirmar-eliminar");
  let modal_crear_eje = $("#modal-crear-eje");
  let modal_cambiar_logo_eje = $("#modal-cambiar-logo-eje");
  let modal_confirmar_deshabilitar_eje =$("#modal-confirmar-deshabilitar-eje");
  let modal_confirmar_habilitar_eje = $("#modal-confirmar-habilitar-eje");
  let modal_edi_eje = $("#modal-edi-eje");
    // cerrar modal de usuario <span> (x)
    if (modal_cambiar_contrasena.length) {
      modal_cambiar_contrasena.css("display", "none");
    }

    if(modal_cambiar_avatar.length){
      // Obtén el elemento del campo de entrada de archivo
      let input_avatar = $('#avatar');

      // Restablece el campo de entrada de archivo a un estado vacío
      input_avatar.val(''); // Esto establecerá el valor del campo a una cadena vacía
      modal_cambiar_avatar.css("display", "none");
      

    }

    if(modal_crear_usuario.length){
        $("#nombre-usu").val("");
        $("#apellido-usu").val("");
        $("#fecha-nacimiento").val("");
        $("#select-sexo").val("SEXO");
        $("#ci").val("");
        $("#correo").val("");
        $("#contrasena").val("");
      modal_crear_usuario.css("display", "none");
    }
    if(modal_confirmar_deshabilitar_usu.length){
      $("#input-confirmar-deshabilitar-usu").val("");
      modal_confirmar_deshabilitar_usu.css("display", "none");
    }

    if(modal_confirmar_habilitar_usu.length){
      $("#input-confirmar-habilitar").val("");
      modal_confirmar_habilitar_usu.css("display", "none");
    }

    if(modal_confirmar_eliminar.length){
      modal_confirmar_eliminar.css("display", "none");
    }

    if(modal_crear_eje.length){
      modal_crear_eje.css("display", "none");
    }

    if(modal_cambiar_logo_eje.length){
      modal_cambiar_logo_eje.css("display", "none");
    }

    if(modal_confirmar_deshabilitar_eje.length){
      modal_confirmar_deshabilitar_eje.css("display", "none");
    }

    if(modal_confirmar_habilitar_eje.length){
      modal_confirmar_habilitar_eje.css("display", "none");
    }

    if(modal_edi_eje.length){
      modal_edi_eje.css("display", "none");
    }

    
});


// Agregar un controlador de eventos al documento para detectar clics fuera del modal
$(window).click(function(event) {
  
   if(event.target === modal_cambiar_contrasena[0]){
     modal_cambiar_contrasena.css("display", "none");
   }

   let modal_cambiar_avatar = $("#modal-cambiar-avatar");
  if (event.target === modal_cambiar_avatar[0]) {
     // Obtén el elemento del campo de entrada de archivo
     let input_avatar = $('#avatar');

     // Restablece el campo de entrada de archivo a un estado vacío
     input_avatar.val(''); // Esto establecerá el valor del campo a una cadena vacía
     modal_cambiar_avatar.css("display", "none");
   }

  let modal_crear_usuario = $("#modal-crear-usuario");
  if (event.target == modal_crear_usuario[0]) {
    $("#nombre-usu").val("");
    $("#apellido-usu").val("");
    $("#fecha-nacimiento").val("");
    $("#select-sexo").val("SEXO");
    $("#ci").val("");
    $("#correo").val("");
    $("#contrasena").val("");
    modal_crear_usuario.css("display", "none");
  }

  let modal_confirmar_deshabilitar_usu = $("#modal-confirmar-deshabilitar-usu");
  if(event.target === modal_confirmar_deshabilitar_usu[0]){
    $("#input-confirmar-deshabilitar-usu").val("");
    modal_confirmar_deshabilitar_usu.css("display", "none");
  }

  let modal_confirmar_habilitar_usu = $("#modal-confirmar-habilitar-usu");
  if(event.target === modal_confirmar_habilitar_usu[0]){
    $("#input-confirmar-habilitar").val("");
    modal_confirmar_habilitar_usu.css("display", "none");
  }
  let modal_confirmar_eliminar = $("#modal-confirmar-eliminar");
  if(event.target === modal_confirmar_eliminar[0]){
    modal_confirmar_eliminar.css("display", "none")
  }
  let modal_crear_eje = $("#modal-crear-eje");
  if(event.target == modal_crear_eje[0]){
    modal_crear_eje.css("display", "none")
  }
  let modal_cambiar_logo_eje = $("#modal-cambiar-logo-eje");
  if(event.target == modal_cambiar_logo_eje[0]){
    modal_cambiar_logo_eje.css("display", "none")
  }

  let modal_confirmar_deshabilitar_eje =$("#modal-confirmar-deshabilitar-eje")
  if(event.target == modal_confirmar_deshabilitar_eje[0]){
    modal_confirmar_deshabilitar_eje.css("display", "none");
  }

  let modal_confirmar_habilitar_eje = $("#modal-confirmar-habilitar-eje")
  if(event.target == modal_confirmar_habilitar_eje[0]){
    modal_confirmar_habilitar_eje.css("display", "none");
  }

  let modal_edi_eje = $("#modal-edi-eje");
  if(event.target == modal_edi_eje[0]){
    modal_edi_eje.css("display", "none")
  }

 });

    

})