$(document).ready(function () {
    opciones_busqueda();
    cargar_producto();
    var funcion;

    function opciones_busqueda() {
        funcion = "marca";
        $.post('../controllers/producto.php', {
            funcion
        }, (response) => {
            const marcas = JSON.parse(response);
            let template = "";
            template += `
            <option selected>MARCA</option>
            `
            marcas.forEach(marca => {
                template += `
                <option value="${marca.id_marca}">${marca.nombre_marca}</option>
                `
            })
            $('#marca').html(template);
        })
        funcion = "gama";
        $.post('../controllers/producto.php', {
            funcion
        }, (response) => {
            const gamas = JSON.parse(response);
            let template = "";
            template += `
            <option selected>GAMA</option>
            `
            gamas.forEach(gama => {
                template += `
                <option value="${gama.id_gama}">${gama.nombre_gama}</option>
                `
            })
            $('#gama').html(template);
        })



    }

    function cargar_producto(consulta, marca, gama) {
        funcion = "buscar_producto";
        $.post('../controllers/producto.php', {
            consulta,
            marca,
            gama,
            funcion
        }, (response) => {
            const productos = JSON.parse(response);
            let template = "";
            template += `
                <h1>Productos</h1>
            `;
            productos.forEach(producto => {
                template += `
                <div class="product">
                    <input type="hidden" value = "${producto.id_producto}">
                    <img src="../uploads/producto/${producto.imagen}"/>
                    <h2>${producto.nombre}</h2>
                    <p>POSPAGO SIN IVA <i class="fas fa-dollar-sign"></i> ${producto.precio}</p>
                    <p>POSPAGO INCL  IVA <i class="fas fa-dollar-sign"></i>${(producto.precio * 1.12).toFixed(2)}</p>
                    <p><i class="fas fa-info-circle"></i> ${producto.descripcion}.</p>
                    <p><i class="fas fa-cubes"></i> En stock: ${producto.stock} unidades</p>
                `
                if (producto.regalo_id != 1) {
                    template += `
                    <p>Recibe un ${producto.regalo} Hasta Agotar stock</p>
                    `
                } else {
                    template += `
                    <p>No hay regalo disponible en este momento</p>
                    `
                }
                template += `
                <!--<a href="" class="button pedir-bodega" style="font-size:20px"><i class="fas fa-warehouse"></i></a>-->
                
                </div>  
                `
            })
            $('#productos').html(template);
        })
    }

    // cuando se tecle se ejecuta la funcion
    $(document).on('keyup', '#buscar', function () {
        // Obtener el valor de búsqueda
        let txtbuscar = $(this).val();
        // Obtener el valor de marca
        let marca = $("#marca").val();
        // Obtener el valor de gama
        let gama = $("#gama").val();

        // Verificar si hay texto en el campo de búsqueda o se ha seleccionado una marca o una gama
        if (txtbuscar !== "" || marca !== "MARCA" || gama !== "GAMA") {
            // Si hay texto en el campo de búsqueda, o se ha seleccionado una marca o una gama, realizar la búsqueda
            cargar_producto(txtbuscar, marca, gama);
        } else {
            // Si no hay texto en el campo de búsqueda y no se ha seleccionado una marca o una gama, cargar todos los productos
            cargar_producto();
        }
    });


    $('#marca').off('click').on('change', function () {
        let txtbuscar = $('#buscar').val();
        let gama = $("#gama").val();
        let marca = $(this).val();
        cargar_producto(txtbuscar, marca, gama);

    });

    $('#gama').off('click').on('change', function () {
        let txtbuscar = $("#buscar").val();
        let marca = $("#marca").val();
        let gama = $(this).val();
        cargar_producto(txtbuscar, marca, gama)
    });



    // CREAR PROYECTO
    modal_crear_producto = $("#modal-crear-producto");
    // var btn_crear_producto = $("#crear-proyecto");

    // cerrar
    var cerrar = $(".close");
    // cerrar modal del contraseña con span
    cerrar.click(function () {
        if (modal_crear_producto.length) {
            modal_crear_producto.css("display", "none");
            // limpiarFormularioCrearProyecto()
        }

    })



    var btn_cerrar_modal = $("#btn-cerrar-modal");
    // btn_cerrar sesion
    btn_cerrar_modal.click(function () {
        // cerrar modal de contraseña
        modal_crear_producto.css("display", "none");
        // limpiarFormularioCrearProyecto()
        //    modal_crear_eje.val("");
    });



    //crear proyecto
    $(document).on("click", "#btn-crear-producto", (e) => {
        // Mostrar el modal para crear un producto
        modal_crear_producto.css("display", "block");

        // Definir la función que se va a enviar al servidor
        funcion = "categoria";

        // Realizar una solicitud POST al servidor
        $.post("../controllers/producto", {
            funcion: funcion
        }, function (response) {
            // Parsear la respuesta JSON del servidor
            const categorias = JSON.parse(response);

            // Inicializar la variable para almacenar el HTML de las opciones de categoría
            let template = "";

            // Agregar una opción por defecto
            template += `<option selected>CATEGORIA</option>`;

            // Iterar sobre las categorías recibidas del servidor y construir las opciones de categoría
            for (let i = 0; i < categorias.length; i++) {
                const categoria = categorias[i];
                template += `<option value="${categoria.id_categoria}">${categoria.nombre_categoria}</option>`;
            }

            // Actualizar el contenido del elemento con el ID select-categoria con las opciones de categoría construidas
            $("#select-categoria").html(template);
        });
        funcion = "marca";
        $.post('../controllers/producto.php', {
            funcion
        }, (response) => {
            const marcas = JSON.parse(response);
            let template = "";
            template += `
            <option selected>MARCA</option>
            `
            marcas.forEach(marca => {
                template += `
                <option value="${marca.id_marca}">${marca.nombre_marca}</option>
                `
            })
            $('#select-marca').html(template);
        });
        funcion = "regalo"
        $.post("../controllers/producto.php", {
            funcion: funcion
        }, (response) => {
            const regalos = JSON.parse(response);
            let template = "";
            template += `
            <option selected>REGALO</option>
            `
            regalos.forEach(regalo => {
                template += `
                <option value="${regalo.id_regalo}">${regalo.nombre_regalo}</option>
                `
            })
            $('#select-regalo').html(template);
        })

        funcion = "gama";
        $.post('../controllers/producto.php', {
            funcion
        }, (response) => {
            const gamas = JSON.parse(response);
            let template = "";
            template += `
            <option selected>GAMA</option>
            `
            gamas.forEach(gama => {
                template += `
                <option value="${gama.id_gama}">${gama.nombre_gama}</option>
                `
            })
            $('#select-gama').html(template);
        })
    })



    // mostrar imagen a enviar
    function mostrarImgen() {
        var input_img = $('#envimg')[0];
        var vista_previa = $('.vista-img');
        // Verificar si se seleccionó un archivo
        if (input_img.files.length > 0) {
            var imagen_seleccionada = input_img.files[0];
            // Verificar si el archivo es una imagen
            if (imagen_seleccionada.type.startsWith('image/')) {
                var imagen = new Image();
                imagen.src = URL.createObjectURL(imagen_seleccionada);
                imagen.style.maxWidth = '100%';
                vista_previa.empty(); // Limpiar vista previa anterior
                vista_previa.append(imagen);
                vista_previa.show();
            } else {
                input_img.value = ''; // Limpiar la selección
                vista_previa.hide();
            }
        } else {
            vista_previa.empty(); // Limpiar vista previa si no se selecciona ningún archivo
            vista_previa.hide();
        }

    }

    $(document).on('input', '#envimg', function () {
        mostrarImgen();
    })

    $("#form-crear").submit(function (e) {
        e.preventDefault();
        
        // Obtener los valores de los campos del formulario
        let cod_sap = $("#cod-sap").val();
        let categoria = $("#select-categoria").val();
        let marca = $("#select-marca").val();
        let nombre = $("#nombre").val();
        let descripcion = $("#descripcion").val();
        let precio = $("#precio").val();
        let stock = $("#stock").val();
        let regalo = $("#select-regalo").val();
        let gama = $("#select-gama").val();
        
         // Crear un objeto FormData para enviar los datos junto con la imagen
         let formData = new FormData($('#form-crear')[0]); // Use the entire form
        formData.append('funcion', 'crear_producto');
        formData.append('cod_sap', cod_sap);
        formData.append('categoria', categoria);
        formData.append('marca', marca);
        formData.append('nombre', nombre);
        formData.append('descripcion', descripcion);
        formData.append('precio', precio);
        formData.append('stock', stock);
        formData.append('regalo', regalo);
        formData.append('gama', gama);
    
        // Realizar la petición AJAX
        $.ajax({
            url: "../controllers/producto.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                response = response.trim();
                // console.log(response)
                if (response === "add") {
                    $('#add').hide('slow').show(1000).hide(2000);
                    $('#form-crear').trigger('reset');
                    var input_img = $('#envimg')[0];
                    var vista_previa = $('.vista-img');
                    input_img.value = ''; // Limpiar la selección
                    vista_previa.hide();
                    cargar_producto();
                    alertaCorrecto("Producto Ingresado con Exito");
                } else if (response === "codigoRepetido") {
                    $('#noadd').hide('slow').show(1000).hide(2000);
                    alertaError("Código ya ingresado");
                } else {
                    const errores = JSON.parse(response);
                    console.log(errores);
                    for (const clave in errores) {
                        const valor = errores[clave];
                        console.log(`La clave es ${clave} y el valor es ${valor}`);
                        $('#' + clave).hide('slow').show(1000).hide(7000);
                    }
                }
            }
        });
    });
    

    function alertaCorrecto(texto) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: 'success',
            title: texto
        })
    }

    function alertaError(texto) {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: texto 
            // footer: '<a href="https://chat.whatsapp.com/H4o1JZtsp4X3mFTrMf09xk">¿Unirme al Grupo Whatsapp?</a>'
        });
    }

})