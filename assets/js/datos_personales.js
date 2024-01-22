$(document).ready(function(){
  var funcion = "";
  var id_usuario = $('#id_usuario').val();
  var template =  '';

  dato_usuario(id_usuario);

  function dato_usuario(dato){
    funcion = 'dato_usuario';
    $.post('../controllers/usuario.php', { dato, funcion }, (response) => {
        template='';
        const datos = JSON.parse(response);
          const usuario = datos[0];
          template +=`
          <h1 class="titulo">DATOS PERSONALES</h1>              
          <div class="personal-info">
            <h2>DATOS</h2>
            <img src="../uploads/avatar/${usuario.avatar}">
            <ul>
              <li><b style="color:#0b7300">NOMBRES:</b><a id="nombre"></a> ${usuario.nombres}</li>
              <li><b style="color:#0b7300">APELLIDOS:</b><a id="apelllido"></a> ${usuario.apellidos}</li>
              <li><b style="color:#0b7300">EDAD:</b><a id="edad"></a> ${usuario.edad}</li>
              <li><b style="color:#0b7300">C.I: </b><a id="ci"></a>${usuario.ci}</li>
              <li>
                <b style="color:#0b7300">TIPO DE USUARIO:</b>
                <span id="us_tipo">${usuario.nombre_tipo}</span>
              </li>
              <li><button class="inline-button btn-avatar">CAMBIAR AVATAR</button></li>
            </ul>
          </div>
            `

          $('#datos_personales').html(template)
        
        

    })
  }



  var modal_cambiar_avatar = $("#modal-cambiar-avatar");
  $('#datos_personales').on('click', '.btn-avatar', function () {
    //   Tu código para mostrar el modal aquí
      funcion = 'buscar_avatar_usuario';
      $.post('../controllers/usuario.php', {
          funcion
        }, (response) => {
          template = '';
          template += `
        <img src="../uploads/avatar/${response}">
        `;

          $('.vista-previa').html(template)

      })
      modal_cambiar_avatar.css("display", "block");
  });

  $('#form-avatar').submit(e => {
      let formData = new FormData($('#form-avatar')[0]);
      formData.append('funcion', 'cambiar_avatar');
      // Verificar si se seleccionó un archivo
      $.ajax({
          url: '../controllers/usuario.php',
          type: 'POST',
          data: formData,
          processData: false, // Evita que jQuery procese los datos
          contentType: false, // Evita que jQuery configure el tipo de contenido
          cache: false, // Evita el almacenamiento en caché de la solicitud
      }).done(function (response) {
          const json = JSON.parse(response);
          if (json.alert == 'edit') {
              $('#edit').hide('slow');
              $('#edit').show(1000);
              $('#edit').hide(2000);
              $('#form-avatar').trigger('reset');
              dato_usuario(id_usuario);
          } else {
              $('#noedit').hide('slow');
              $('#noedit').show(1000);
              $('#noedit').hide(2000);
              $('#form-photo').trigger('reset');
          }

      });
      e.preventDefault();

  })


  

  var btn_cer_cam_av = $('.cerrar-cambiar-avatar');
  btn_cer_cam_av.click(function () {

      let input_avatar = $('#avatar');

      // Restablece el campo de entrada de archivo a un estado vacío
      input_avatar.val(''); // Esto establecerá el valor del campo a una cadena vacía
      modal_cambiar_avatar.css("display", "none");

  })


  // mostrar img
  var input_avatar = $('#avatar');
  input_avatar.change(mostrarImagen);

  function mostrarImagen() {
      var input_avatar = $('#avatar')[0]; // Accede al elemento HTML subyacente
      var vista_previa = $('.vista-previa');

      // Verificar si se seleccionó un archivo
      if (input_avatar.files.length > 0) {
          var imagen_seleccionada = input_avatar.files[0];

          // Verificar si el archivo es una imagen
          if (imagen_seleccionada.type.startsWith('image/')) {
              var imagen = new Image();
              imagen.src = URL.createObjectURL(imagen_seleccionada);
              imagen.style.maxWidth = '100%';
              vista_previa.empty(); // Limpiar vista previa anterior
              vista_previa.append(imagen);
          } else {
              alert('El archivo seleccionado no es una imagen.');
              input_avatar.value = ''; // Limpiar la selección
          }
      } else {
          vista_previa.empty(); // Limpiar vista previa si no se selecciona ningún archivo
      }
  }




})
