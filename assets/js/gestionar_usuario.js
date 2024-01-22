$(document).ready(function(){
  cargar_usuario();
  var funcion;
  function cargar_usuario(consulta) {
    funcion = 'buscar_usuarios';
    $.post('../controllers/usuario.php', {
     consulta,
     funcion
    }, (response) => {
    const usuarios = JSON.parse(response);
    let template = '';
    usuarios.forEach(usuario => {
      template += `
        <div class="card" usuarioId="${usuario.id_us}">
          <div class="card-body">
            <h1 style="background-color: #1783db; color: white; font-size: 15px; display: inline-block; border-radius: 5px;">${usuario.nombre_tipo}</h1>
            <img src="../uploads/avatar/${usuario.avatar}">
            <h2 style="color: #0b7300; font-size: 20px; display: block; height: 60px; text-align: center;">${usuario.nombres} ${usuario.apellidos}</b></h2>
              <ul style="text-decoration: none; list-style-type: none;">
                <li style="margin-top: 10px;"><span><i class="fas fa-lg fa-id-card" style="color: #6c757d;"></i></span> C.I: ${usuario.ci}</li>
                <li style="margin-top: 10px;"><span><i class="fas fa-lg fa-at" style="color: #6c757d;"></i></span> Correo: ${usuario.correo}</li>
              </ul>
            </div>
            `
      if (usuario.tipo_us_id != 1) {
        template += `
            <div class="card-footer">
            `
        if (usuario.nombre_estado_us == "Habilitado") {
          template += `
                <button type="button" class="inline-button-eliminar deshabilitar-usu">
                  <i  class="fas fa-ban"></i> Deshabilitar
                </button>
                `
        }
        if (usuario.nombre_estado_us == "Deshabilitado") {
          template += `
                <button type="button" class="inline-button habilitar-usu">
                  <i class="fas fa-check-circle"></i> Habilitar
                </button>
                `
        }
        template += `
                <button type="button" class="inline-button-eliminar" id="btn-confirmar-eliminar">
                  <i class="fas fa-window-close mr-1"></i> Eliminar
                </button>
        
                `
      }


      template += `
            </div>
        </div>
            `
    });

    $('.usuarios-card').html(template);

   });
  }

// cuando se tecle se ejecuta una funcion de calban
$(document).on('keyup','#buscar',function(){
    // cojo el valor id
    let valor = $(this).val();
    if(valor != ""){
        // console.log(valor);
        cargar_usuario(valor)

    }else{
        cargar_usuario();

    }
})



  //crear usuario 
  var modal_crear_usuario = $("#modal-crear-usuario");
  var btn_crear_usuario = $("#crear-usuario");


  // btn_crear_usuario
  btn_crear_usuario.click(function() {
  modal_crear_usuario.css("display", "block");
  
  });



  function borrar__dt_cre_usu(){
    $("#nombre-usu").val("");
    $("#apellido-usu").val("");
    $("#select-sexo").val("SEXO");
    $("#fecha-nacimiento").val("");
    $("#ci").val("");
    $("#correo").val("");
    $("#contrasena").val("");
  }
  // cerrar modal de usuario
  var btn_cerrar_modal_agregar_usu = $("#btn-cerrar-modal-agregar-usu");
  btn_cerrar_modal_agregar_usu.click(function(){
      if (modal_crear_usuario.length) {
        borrar__dt_cre_usu()
        modal_crear_usuario.css("display", "none");
      }
  }) 


  // Validaciones de datos cliente
  // ci
  $("#ci").on("input", function(e) {
    var inputValue = e.target.value;
    // Eliminar caracteres no numéricos con exprecion regulares
    inputValue = inputValue.replace(/[^\d]/g, '');
    // Validar cedula con 10 caracteres
    if (inputValue.length > 10) {
     inputValue = inputValue.slice(0, 10);
    }
    // Asignar el valor modificado de vuelta al campo de entrada
    e.target.value = inputValue;
  });

  function validacion_nombres(id) {
    $(id).on("input", function(e) {
        e.preventDefault();

        var inputValue = e.target.value;
        // Mantener solo letras, espacios, ñ y tildes en el valor del campo
        inputValue = inputValue.replace(/[^A-Za-zñÑáéíóúÁÉÍÓÚ\s]/g, '');

        // Dividir el valor en palabras
        var palabras = inputValue.split(' ');

        // Capitalizar solo la primera letra de la primera palabra
        if (palabras.length > 0) {
            palabras[0] = palabras[0].charAt(0).toUpperCase() + palabras[0].slice(1).toLowerCase();
        }

        // Capitalizar la primera letra de cada palabra (excepto la primera)
        for (var i = 1; i < palabras.length; i++) {
            palabras[i] = palabras[i].toLowerCase(); // Convertir la palabra completa a minúsculas
            palabras[i] = palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1);
        }

        // Unir las palabras de nuevo con espacios
        var resultado = palabras.join(' ');

        // Asignar el valor modificado de vuelta al campo de entrada
        $(this).val(resultado);
    });
  }

  // nombre
  validacion_nombres("#nombre-usu");
  // nombre
  validacion_nombres("#apellido-usu");

 //insertar usuario
  $('#form-crear').submit(function(e) {
    e.preventDefault();
    let nombre_usuario = $('#nombre-usu').val();
    let apellido_usuario = $('#apellido-usu').val();
    let fecha_nacimiento = $('#fecha-nacimiento').val();
    let ci = $('#ci').val();
    let correo = $('#correo').val();
    let contrasena = $('#contrasena').val();
    // obtener value option
    let select_tip = $('#select-tipo option:selected')
    var select_tipo = $(select_tip).attr('value');
  
    let data = {
      funcion: 'crear_usuario',
      nombre_usuario: nombre_usuario,
      apellido_usuario: apellido_usuario,
      fecha_nacimiento: fecha_nacimiento,
      ci: ci,
      correo: correo,
      contrasena: contrasena,
      select_tipo: select_tipo
    };
    console.log(data);
    $.post('../controllers/usuario.php', data, function(response) {
      response = response.trim();
      if (response == "add") {
        $('#add').hide('slow');
        $('#add').show(1000);
        $('#add').hide(2000);
        $('#form-crear').trigger('reset');
        cargar_usuario();
      } else if (response == "noadd") {
        $('#noadd').hide('slow');
        $('#noadd').show(1000);
        $('#noadd').hide(2000);
      
      }else {
        const errores = JSON.parse(response);
        for (const clave in errores){
          const valor = errores[clave];
          // console.log(`La clave es ${clave} y el valor es ${valor}`);
          $('#'+clave).hide('slow');
          $('#'+clave).show(1000);
          $('#'+clave).hide(7000);
        }
      
      }
    
    });
  });



  // deshabilitar usuario
  $(document).on('click', '.deshabilitar-usu', (e) => {
    $("#modal-confirmar-deshabilitar-usu").css("display", "block");
    // coger elemento der card id de usuario
    const elemento = $(this)[0].activeElement.parentElement.parentElement;
    // cojo el elemento
    const id = $(elemento).attr('usuarioId');
    funcion = 'deshabilitar-usu';
    $('#id_deshabilitar').val(id);
    $('#funciondes').val(funcion);
  });

  $('#form-confirmar-deshabilitacion').submit(e => {
    let pass = $('#input-deshabilitar-usu').val();
    let id_usuario = $('#id_deshabilitar').val();
    funcion = $('#funciondes').val();
    // console.log(pass,id_usuario,funcion)
    // 11 2 borrar-usuario
    $.post('../controllers/usuario.php', {
      pass,
      id_usuario,
      funcion
    }, (response) => {
    // console.log(response);
    response = response.trim();
    if (response == 'deshabilitado') {
      $('#confirmar-deshabilitacion').hide('slow');
      $('#confirmar-deshabilitacion').show(1000);
      $('#confirmar-deshabilitacion').hide(2000);
      $('#form-confirmar-deshabilitacion').trigger('reset');
    } else {
      $('#rechazar-deshabilitacion').hide('slow');
      $('#rechazar-deshabilitacion').show(1000);
      $('#rechazar-deshabilitacion').hide(2000);
      $('#form-confirmar-deshabilitacion').trigger('reset');
    }
    cargar_usuario();

    });
    // no se recargue la pagina
    e.preventDefault();
  })


  // Habilitar usuario
  $(document).on('click', '.habilitar-usu', (e) => {
  $("#modal-confirmar-habilitar-usu").css("display", "block");
  // coger elemento der card id de usuario
  const elemento = $(this)[0].activeElement.parentElement.parentElement;
  // cojo el elemento
  const id = $(elemento).attr('usuarioId');
  // console.log(id)
  funcion = 'habilitar-usu';
  $('#id_habilitar').val(id);
  $('#funcionha').val(funcion);
  });

  $('#form-confirmar-habilitacion').submit(e => {
  let pass = $('#input-confirmar-habilitar').val();
  let id_usuario = $('#id_habilitar').val();
  funcion = $('#funcionha').val();
  // console.log(pass,id_usuario,funcion)
  // 11 2 borrar-usuario
  $.post('../controllers/usuario.php', {
    pass,
    id_usuario,
    funcion
  }, (response) => {
    response = response.trim();
    // console.log(response)
    if (response == 'habilitado') {
      $('#confirmar-habilitacion').hide('slow');
      $('#confirmar-habilitacion').show(1000);
      $('#confirmar-habilitacion').hide(2000);
      $('#form-confirmar-habilitacion').trigger('reset');
    } else {
      $('#rechazar-habilitacion').hide('slow');
      $('#rechazar-habilitacion').show(1000);
      $('#rechazar-habilitacion').hide(2000);
      $('#form-confirmar-habilitacion').trigger('reset');
    }
    cargar_usuario();

  });
  // no se recargue la pagina
  e.preventDefault();
  })



  // borrar usuario
  $(document).on('click', '#btn-confirmar-eliminar', (e) => {
  $("#modal-confirmar-eliminar").css("display", "block");
  // coger elemento der card id de usuario
  const elemento = $(this)[0].activeElement.parentElement.parentElement;
  // cojo el elemento
  const id = $(elemento).attr('usuarioId');
  funcion = 'borrar-usuario';
  $('#id_user').val(id);
  $('#funcion').val(funcion);

  });




  $('#form-confirmar').submit(e => {
  let pass = $('#input-confirmar-eliminacion').val();
  let id_usuario = $('#id_user').val();
  funcion = $('#funcion').val();
  // console.log(pass,id_usuario,funcion)
  // 11 2 borrar-usuario
  $.post('../controllers/usuario.php', { pass, id_usuario, funcion }, (response) => {
      response = response.trim();
      if (response == 'borrado') {
          $('#confirmarr').hide('slow');
          $('#confirmarr').show(1000);
          $('#confirmarr').hide(2000);
          $('#form-confirmar').trigger('reset');
          cargar_usuario();
      } else {
          $('#rechazar').hide('slow');
          $('#rechazar').show(1000);
          $('#rechazar').hide(2000);
          $('#form-confirmar').trigger('reset');
      }
  });
  // no se recargue la pagina
  e.preventDefault();
  })    









})