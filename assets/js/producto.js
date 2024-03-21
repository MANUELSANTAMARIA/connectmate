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
                <div class="product" cod_producto="${producto.cod_producto}" nombre_producto="${producto.nombre}" precio_equipo="${producto.precio}">
                    <img src="../uploads/producto/${producto.imagen}"/>
                    <h2>${producto.nombre}</h2>
                    <p>POSPAGO SIN IVA:  ${formatearDinero(producto.precio)}</p>
                    <p>POSPAGO INCL  IVA: ${formatearDinero((producto.precio * 1.12).toFixed(2))}</p>
                    <p><i class="fas fa-info-circle"></i> ${producto.descripcion}.</p>
                    <p><i class="fas fa-cubes"></i> En stock: ${producto.stock} unidades</p>
                    <p><i class="fas">&#xf121;</i> Codigo:  sap-> ${producto.cod_producto} - smartflex-> ${producto.smartflex_cod}</p>
                
                    <a href="" class="button cotizar" style="font-size:20px"><i class="fas fa-calculator"></i>Cotizar</a>
                `
                console.log(producto.id_usuario)
                if (producto.id_usuario == 1 || producto.id_usuario == 2) {
                    template += `
                    <a href="" class="button editar-producto" style="font-size:20px"><i class="fas fa-edit"></i>Editar</a>
                    `
                }

                template += `
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



    // Modales
    var modal_crear_producto = $("#modal-crear-producto");
    var modal_editar = $("#modal-editar-producto");
    var modal_cotizador = $("#modal-cotizador");





    var btn_cerrar_modal = $("#btn-cerrar-modal");
    // btn_cerrar sesion
    btn_cerrar_modal.click(function () {
        // cerrar
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
        $.post("../controllers/producto.php", {
            funcion: funcion
        }, function (response) {
            // Parsear la respuesta JSON del servidor
            const categorias = JSON.parse(response);
            console.log(categorias);

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
        funcion = "smartflex"
        $.post("../controllers/producto.php", {
            funcion: funcion
        }, (response) => {
            const smartflexs = JSON.parse(response);
            let template = "";
            template += `
            <option selected>CODIGO SMARTFLEX</option>
            `
            smartflexs.forEach(smartflex => {
                template += `
                <option value="${smartflex.cod_smartflex}">${smartflex.cod_smartflex}->${smartflex.nombre_smartflex}</option>
                `
            })
            $('#select-smartflex').html(template);
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

        var input_img = $('#envimg')[0];
        var vista_previa = $('.vista-img');
        input_img.value = ''; // Limpiar la selección
        vista_previa.empty(); // Limpiar vista previa si no se selecciona ningún archivo
        vista_previa.hide();
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
        let smartflex = $("#select-smartflex").val();
        let gama = $("#select-gama").val();
        // Eliminar el formato de moneda y convertir a número decimal
        precio = parseFloat(precio.replace(/[^0-9.-]+/g, ""));
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
        formData.append('smartflex', smartflex);
        formData.append('gama', gama);
        console.log(formData);
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


    // EDITAR PRODUCTO
    $(document).on("click", ".editar-producto", (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement
        const cod_producto = $(elemento).attr('cod_producto');
        mostrarModalEditarProducto()

        // Llamar a obtenerDatosProducto y manejar los datos obtenidos
        // obtenerDatosProducto(cod_producto).then(datos => {
        // console.log("Datos del producto:", datos);
        // });

        obtenerDatosProducto(cod_producto)
            .then(dato_producto => {
                mostrarDatosProducto(dato_producto);
            })
            .catch(error => {
                console.error("Error al obtener datos del producto", error);
            });


    });


    function mostrarModalEditarProducto() {
        modal_editar.css("display", "block");

    }

    function obtenerDatosProducto(cod_producto) {
        const funcion = "dato_producto";
        return $.post('../controllers/producto.php', {
                funcion,
                cod_producto
            })
            .then(response => JSON.parse(response));
    }

    function mostrarDatosProducto(dato_producto) {
        const elemento0 = dato_producto[0];
        const {
            cod_producto,
            categoria_id,
            marca_id,
            nombre_producto,
            descripcion_producto,
            precio,
            stock,
            smartflex_cod,
            gama_id,
            imagen
        } = elemento0;

        $("#cod_producto_edi").val(cod_producto);
        $(".dato-producto").html(`<h3 style="color:#1783db; margin-bottom: 2px;"><i class="fas fa-tag"></i> 
        CÓDIGO SAP: ${cod_producto}</h3><div class = "linea-bajo"></div>`);

        cargarOpcionesCategoria(categoria_id);
        cargarOpcionesMarca(marca_id);
        cargarOpcionesSmartflex(smartflex_cod);
        cargarOpcionesGama(gama_id);

        $("#nombre-edit").val(nombre_producto);
        $("#descripcion-edit").val(descripcion_producto);
        $("#precio-edit").val(formatearDinero(precio));
        $("#stock-edit").val(stock);

        mostrarImagenProducto(imagen);
    }

    function cargarOpcionesCategoria(categoria_id) {
        const funcion = "categoria";
        $.post("../controllers/producto", {
            funcion
        }, response => {
            const categorias = JSON.parse(response);
            let template = `<option selected>CATEGORIA</option>`;
            categorias.forEach(categoria => {
                template += `<option value="${categoria.id_categoria}">${categoria.nombre_categoria}</option>`;
            });
            $("#select-categoria-edit").html(template).val(categoria_id);
        });
    }


    function cargarOpcionesMarca(marca_id) {
        const funcion = "marca";
        $.post('../controllers/producto.php', {
            funcion
        }, response => {
            const marcas = JSON.parse(response);
            let template = `<option selected>MARCA</option>`;
            marcas.forEach(marca => {
                template += `<option value="${marca.id_marca}">${marca.nombre_marca}</option>`;
            });
            $('#select-marca-edit').html(template).val(marca_id);
        });
    }

    function cargarOpcionesSmartflex(smartflex_cod) {
        const funcion = "smartflex";
        $.post("../controllers/producto.php", {
            funcion
        }, response => {
            const smartflexs = JSON.parse(response);
            let template = `<option selected>CODIGO SMARTFLEX</option>`;
            smartflexs.forEach(smartflex => {
                template += `<option value="${smartflex.cod_smartflex}">${smartflex.cod_smartflex}->${smartflex.nombre_smartflex}</option>`;
            });
            $('#select-smartflex-edit').html(template).val(smartflex_cod);
        });
    }

    function cargarOpcionesGama(gama_id) {
        const funcion = "gama";
        $.post('../controllers/producto.php', {
            funcion
        }, response => {
            const gamas = JSON.parse(response);
            let template = `<option selected>GAMA</option>`;
            gamas.forEach(gama => {
                template += `<option value="${gama.id_gama}">${gama.nombre_gama}</option>`;
            });
            $('#select-gama-edit').html(template).val(gama_id);
        });
    }

    function mostrarImagenProducto(imagen) {
        const vista_previa = $('.vista-img');
        const imagen_url = "../uploads/producto/" + imagen;
        const imagenElement = $('<img>').attr('src', imagen_url).css('maxWidth', '100%');
        vista_previa.empty().append(imagenElement).show();

    }

    // mostrar imagen a enviar
    function mostrarImgenedit() {
        var input_img = $('#envim')[0];
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

    $(document).on('input', '#envim', function () {
        mostrarImgenedit();
    })

    $("#form-editar").submit((e) => {
        e.preventDefault();

        // Obtener los valores de los campos del formulario
        let cod_producto_edit = $("#cod_producto_edi").val();
        let categoria = $("#select-categoria-edit").val();
        let marca = $("#select-marca-edit").val();
        let nombre = $("#nombre-edit").val();
        let descripcion = $("#descripcion-edit").val();
        let precio = $("#precio-edit").val();
        let stock = $("#stock-edit").val();
        let smartflex = $("#select-smartflex-edit").val();
        let gama = $("#select-gama-edit").val();
        // Eliminar el formato de moneda y convertir a número decimal
        precio = parseFloat(precio.replace(/[^0-9.-]+/g, ""));

        // Crear un objeto FormData
        var formData = new FormData();

        formData.append('funcion', 'editar_producto');
        formData.append('cod_sap', cod_producto_edit);
        formData.append('categoria', categoria);
        formData.append('marca', marca);
        formData.append('nombre', nombre);
        formData.append('descripcion', descripcion);
        formData.append('precio', precio);
        formData.append('stock', stock);
        formData.append('smartflex', smartflex);
        formData.append('gama', gama);
        // Verificar si se seleccionó una imagen
        var input_img = $('#envim')[0];
        if (input_img.files.length > 0) {
            var imagen_seleccionada = input_img.files[0];
            formData.append('imagen', imagen_seleccionada);
        }

        // Realizar la petición AJAX
        $.ajax({
            url: "../controllers/producto.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                response = response.trim();
                if (response === "add") {
                    $('#add-edit').hide('slow').show(1000).hide(2000);
                    $('#form-crear').trigger('reset');
                    $('#envim').val('');
                    cargar_producto();
                    alertaCorrecto("Editado con Exito");
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



    var btn_cerrar_modal_edi = $("#btn-cerrar-modal-edi");
    // btn_cerrar sesion
    btn_cerrar_modal_edi.click(function () {
        // cerrar
        modal_editar.css("display", "none");
        // limpiarFormularioCrearProyecto()
        //    modal_crear_eje.val("");
    });


    // cotizador
    $(document).on("click", ".cotizar", (e) => {
        e.preventDefault();
        modal_cotizador.css("display", "block");

        const elemento = $(this)[0].activeElement.parentElement
        // console.log(elemento);
        // cojo el elemento
        const cod_producto = $(elemento).attr('cod_producto');
        const nombre_producto = $(elemento).attr('nombre_producto');
        const precio_equipo = $(elemento).attr('precio_equipo');
        // console.log(precio_equipo)

        template = "";
        template += `
            <h3 style="color:#1783db; margin-bottom: 2px;">${nombre_producto}</h3>
            <label for=""><i class="fas fa-tag" style="color: #0b7300";></i> <span style="color: #0b7300">CÓDIGO SAP:</span> <br><span style="margin-left:19px";>${cod_producto}</span></label>
            <label for=""><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">PRECIO:</span> <br><span style="margin-left:19px";>${formatearDinero(precio_equipo)}</span></label>
        
            `;

        funcion = "cotizacion"
        $.post("../controllers/producto.php", {
            funcion
        }, (response) => {

            // console.log(response);
            const dato_cotizacion = JSON.parse(response);
            const tasa_interes = dato_cotizacion[0];
            let nombre_tasa_interes = tasa_interes.nombre_cotizacion;
            let valor_tasa_interes = tasa_interes.valor_cotizacion;
            const interes_mensual = dato_cotizacion[1];
            let nombre_interes_mensual = interes_mensual.nombre_cotizacion;
            var valor_interes_mensual = interes_mensual.valor_cotizacion;
            const iva = dato_cotizacion[2];
            let nombre_iva = iva.nombre_cotizacion;
            let valor_iva = iva.valor_cotizacion;
            // este es el impuesto al valor agregado
            var impuesto_val_agre = (valor_iva / 100) * precio_equipo
            impuesto_val_agre = Math.ceil(impuesto_val_agre * 100) / 100;
            // Calcular el precio incluyendo el IVA y redondear a dos decimales
            var prec_incl_iva = (parseFloat(precio_equipo) + parseFloat(impuesto_val_agre)).toFixed(2);


            // console.log(impuesto)
            template += `
            <label for=""><i class="fas fa-percent" style="color: #0b7300";></i> <span style="color: #0b7300">${nombre_tasa_interes}:</span> <br><span style="margin-left:19px";>${valor_tasa_interes}</span></label>
            <label for=""><i class="fas fa-percent" style="color: #0b7300";></i> <span style="color: #0b7300">${nombre_interes_mensual}:</span> <br><span style="margin-left:19px";>${valor_interes_mensual}</span></label>
            <label for=""><i class="fas fa-percent" style="color: #0b7300";></i> <span style="color: #0b7300">${nombre_iva}:</span> <br><span style="margin-left:19px";>${valor_iva}</span></label>
            <label for=""><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">IMPUESTO AL VALOR AGREGADO:</span> <br><span style="margin-left:19px";>${impuesto_val_agre}</span></label>
            
            <div class = "linea-bajo"></div>
            
            `


            $(".dato-producto").html(template);

            template = "";
            template += `
                    <label for=""><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">PRECIO INCL. IVA:</span> <br><span style="margin-left:19px";>${formatearDinero(prec_incl_iva)}</span></label>
                    <div class="form">
                        <input id="abono" type="text" class="form-control" required>
                        <label class="lbl">
                            <span class="text-span"><i class="fas fa-dollar-sign"></i> ABONO</span>
                        </label>
                    </div>
                    <br>
                    <label for="inputcbmcorp"><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">CBM CORP:</span> <br><span id="spancbmcorp" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
                    <input id="inputcbmcorp" type="hidden" class="form-control" required>
                    <label for="inputequiivaabonocbm"><i class="" style="color: #0b7300";></i> <span style="color: #0b7300">EQUIPO + IVA - ABONO - CBM:</span> <br><span id="spanequiivaabonocbm" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
                    <input id="inputequiivaabonocbm" type="hidden" class="form-control" required>
        `;
            funcion = "plan"
            $.post("../controllers/producto.php", {
                funcion
            }, (response) => {
                console.log(response)
                var planes = JSON.parse(response);
                template += `
            <div class="combodesplegable">
                <select class="select" id="select-plan">
                <option selected>PLAN</option>
            `

                planes.forEach(function (plan) {
                    template += `<option value="${plan.cod_plan}">${plan.nombre_plan}</option>`;
                })
                template += `
                </select>
            </div>
            `

                template += `
            </br>
            <label for="inputtarifa_plan"><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">VALOR DEL PLAN:</span> <br><span id="spantarifa_plan" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
            <input id="inpttarifa_plan" type="hidden" class="form-control" required>
            <label for="inputcbm"><i class="" style="color: #0b7300";></i> <span style="color: #0b7300">CBM:</span> <br><span id="spancbm" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
            <input id="inputcbm" type="hidden" class="form-control" required>
            <div class="combodesplegable">
                <select class="select" id="select-plazo">
                    <option selected>PLAZO</option>
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="9">9</option>
                    <option value="12">12</option>
                    <option value="15">15</option>
                    <option value="24">24</option>
                </select>
            </div>
            <input id="valor-plazo" type="hidden" class="form-control" required>
            </br>
            <label for="inputcuotaMensualEquipoSinIva"><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">CUOTA MENSUAL DEL EQUIPO (SIN IVA):</span> <br><span id="spancuotaMensualEquipoSinIva" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
            <input id="inputcuotaMensualEquipoSinIva" type="hidden" class="form-control" required>
            <label for="inputcuotaMensualEquipoMasPlanSinIva"><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">CUOTA MENSUAL EQUIPO+PLAN (SIN IVA):</span> <br><span id="spancuotaMensualEquipoMasPlanSinIva" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
            <input id="inputcuotaMensualEquipoMasPlanSinIva" type="hidden" class="form-control" required>
            <label for="inputcuotamensualincliva"><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">CUOTA MENSUAL DEL EQUIPO (INCL. IVA):</span> <br><span id="spancuotamensualincliva" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
            <input id="inputcuotamensualincliva" type="hidden" class="form-control" required>
            <label for="inputpagoMensualEquipoMasPlanInclIva"><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">CUOTA MENSUAL EQUIPO+PLAN (INCL. IVA):</span> <br><span id="spanpagoMensualEquipoMasPlanInclIva" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
            <input id="inputpagoMensualEquipoMasPlanInclIva" type="hidden" class="form-control" required>
            <label for="inputfrdi"><i class="fas fa-dollar-sign" style="color: #0b7300";></i> <span style="color: #0b7300">VALOR TOTAL DIFERIDO INGRESAR A FRDI:</span> <br><span id="spanfrdi" style="margin-left:19px; display:block; width: 100px; height: 20px; background-color: #f0f0f0; margin: 0 auto; text-align: center;";></span></label>
            <input id="inputfrdi" type="hidden" class="form-control" required>

            `

                $(document).off('change', '#select-plan').on('change', '#select-plan', function () {
                    var valorSeleccionado = $(this).val();
                    funcion = "buscar_plan"
                    $.post("../controllers/producto", {
                        funcion,
                        valorSeleccionado
                    }, function (response) {
                        // console.log(response)
                        var plan = JSON.parse(response)
                        // console.log(plan[0].nombre_plan)
                        var cbm = plan[0].cbm;
                        var tarifa_plan = plan[0].tarifa_plan;
                        var cbm_corp = parseFloat(cbm) * parseFloat(tarifa_plan)

                        $("#spancbmcorp").text(cbm_corp);
                        $("#inputcbmcorp").val(cbm_corp);
                        // spanequi+iva-abono-cbm
                        let abono = $("#abono").val();
                        if (abono === "") {
                            abono = 0
                        }

                        let equi_mas_iva_menos_abono_menos_cbm = (parseFloat(prec_incl_iva) - parseFloat(abono) - parseFloat(cbm_corp)).toFixed(2);

                        $("#inputequiivaabonocbm").val(equi_mas_iva_menos_abono_menos_cbm);
                        $("#spanequiivaabonocbm").text(equi_mas_iva_menos_abono_menos_cbm);

                        $("#inpttarifa_plan").val(tarifa_plan);
                        $("#spantarifa_plan").text(formatearDinero(tarifa_plan));
                        $("#spancbm").text(cbm);
                        $("#inputcbm").val(cbm);

                        var select_plazo = $("#select-plazo").val();

                        if (select_plazo === "PLAZO") {
                            select_plazo = 0
                        }

                        var tasaInteresMensual = 1.26; // Tasa de interés anual en porcentaje
                        if (select_plazo > 6) {
                            // console.log("plazo:" + valorSeleccionado)
                            // console.log("precio incluido iva:" + prec_incl_iva) // Monto principal del préstamo
                            var pagoMensual = calcularPago(tasaInteresMensual, select_plazo, prec_incl_iva);
                            // console.log("El pago mensual es: " + pagoMensual.toFixed(2));
                            pagoMensualInclIva = pagoMensual.toFixed(2);
                        } else {

                            pagoMensualInclIva = (parseFloat(prec_incl_iva) / parseFloat(select_plazo)).toFixed(2);

                        }
                        if (select_plazo != 0) {
                            var sacarIva = parseFloat("1." + valor_iva); // Convertir la cadena en un número decimal
                            var pagoMensualSinIva = (pagoMensualInclIva / sacarIva).toFixed(2);
                            var pagoMensualSinIvamasplan = (parseFloat(pagoMensualSinIva) + parseFloat(tarifa_plan)).toFixed(2)
                            $("#inputcuotaMensualEquipoMasPlanSinIva").val(pagoMensualSinIvamasplan);
                            $("#spancuotaMensualEquipoMasPlanSinIva").text(formatearDinero(pagoMensualSinIvamasplan));
                            // Calcular el resultado de la expresión
                            var pagoMensualEquipoMasPlanInclIva = (parseFloat(pagoMensualInclIva) + (parseFloat(tarifa_plan) * (1 + (valor_iva / 100)))).toFixed(2);
                            // console.log(pagoMensualEquipoMasPlanInclIva)
                            $("#inputpagoMensualEquipoMasPlanInclIva").val(pagoMensualEquipoMasPlanInclIva);
                            $("#spanpagoMensualEquipoMasPlanInclIva").text(formatearDinero(pagoMensualEquipoMasPlanInclIva));
                        }





                    })
                    // Haz lo que necesites con el valor seleccionado
                    // console.log("El valor seleccionado es: " + valorSeleccionado);
                });

                $(document).off("change", "#select-plazo").on('change', '#select-plazo', function () {
                    var abono = $("#abono").val();
                    var valorSeleccionado = $(this).val(); // Número de periodos (meses)
                    var tasaInteresMensual = valor_interes_mensual; // Tasa de interés anual en porcentaje
                    var pagoMensualInclIva = "";
                    var pagoMensualSinIva = "";
                    var frdi = "";
                    if(abono == ""){
                        abono = 0
                    }
                    if (valorSeleccionado > 6) {
                        // console.log("plazo:" + valorSeleccionado)
                        // console.log("precio incluido iva:" + prec_incl_iva) // Monto principal del préstamo
                        var pagoMensual = calcularPago(tasaInteresMensual, valorSeleccionado, prec_incl_iva, abono);
                        // console.log("El pago mensual es: " + pagoMensual.toFixed(2));
                        pagoMensualInclIva = pagoMensual.toFixed(2);

                    } else {
                        pagoMensualInclIva = (parseFloat(prec_incl_iva) / parseFloat(valorSeleccionado)).toFixed(2);
                        // console.log(pagoMensualInclIva)

                    }
                
                    $("#inputcuotamensualincliva").val(pagoMensualInclIva);
                    $("#spancuotamensualincliva").text(formatearDinero(pagoMensualInclIva));
                    var sacarIva = parseFloat("1." + valor_iva); // Convertir la cadena en un número decimal
                    var pagoMensualSinIva = (pagoMensualInclIva / sacarIva).toFixed(2);

                    $("#inputcuotaMensualEquipoSinIva").val(pagoMensualSinIva);
                    $("#spancuotaMensualEquipoSinIva").text(formatearDinero(pagoMensualSinIva));

                    var tarifa_plan = $("#inpttarifa_plan").val()
                    if (tarifa_plan === "") {
                        tarifa_plan = 0
                    }
                    var pagoMensualSinIvamasplan = (parseFloat(pagoMensualSinIva) + parseFloat(tarifa_plan)).toFixed(2)

                    $("#inputcuotaMensualEquipoMasPlanSinIva").val(pagoMensualSinIvamasplan);
                    $("#spancuotaMensualEquipoMasPlanSinIva").text(formatearDinero(pagoMensualSinIvamasplan));


                    // Calcular el resultado de la expresión
                    var pagoMensualEquipoMasPlanInclIva = (parseFloat(pagoMensualInclIva) + (parseFloat(tarifa_plan) * (1 + (valor_iva / 100)))).toFixed(2);
                    // console.log(pagoMensualEquipoMasPlanInclIva)
                    $("#inputpagoMensualEquipoMasPlanInclIva").val(pagoMensualEquipoMasPlanInclIva);
                    $("#spanpagoMensualEquipoMasPlanInclIva").text((pagoMensualEquipoMasPlanInclIva));




                    if (valorSeleccionado > 6) {
                        frdi = (parseFloat(pagoMensualInclIva) * parseFloat(valorSeleccionado)).toFixed(2);
                    } else {
                        var equi_mas_iva_menos_abono_menos_cbm = $("#inputequiivaabonocbm").val()
                        frdi = parseFloat(equi_mas_iva_menos_abono_menos_cbm).toFixed(2);

                    }

                    $("#inputfrdi").val(frdi);
                    $("#spanfrdi").text(formatearDinero(frdi));



                });


                $(document).on("input", "#abono", function () {
                    var abono = $(this).val()
                    var plazo = $("#select-plazo").val(); // Número de periodos (meses)
                    // console.log(plazo);
                    var tasaInteresMensual = valor_interes_mensual; // Tasa de interés anual en porcentaje
                    var pagoMensualInclIva = "";
                    var pagoMensualSinIva = "";
                    var frdi = "";
                    if (plazo != "PLAZO") {
                        if (plazo > 6) {
                            // console.log("plazo:" + plazo)
                            // console.log("precio incluido iva:" + prec_incl_iva) // Monto principal del préstamo
                            var pagoMensual = calcularPago(tasaInteresMensual, plazo, prec_incl_iva, abono);
                            // console.log("El pago mensual es: " + pagoMensual.toFixed(2));
                            pagoMensualInclIva = pagoMensual.toFixed(2);

                        } else {
                            pagoMensualInclIva = (parseFloat(prec_incl_iva) / parseFloat(plazo)).toFixed(2);
                            // console.log(pagoMensualInclIva)

                        }

                        $("#inputcuotamensualincliva").val(pagoMensualInclIva);
                        $("#spancuotamensualincliva").text(formatearDinero(pagoMensualInclIva));
                        var sacarIva = parseFloat("1." + valor_iva); // Convertir la cadena en un número decimal
                        var pagoMensualSinIva = (pagoMensualInclIva / sacarIva).toFixed(2);

                        $("#inputcuotaMensualEquipoSinIva").val(pagoMensualSinIva);
                        $("#spancuotaMensualEquipoSinIva").text(formatearDinero(pagoMensualSinIva));

                        var tarifa_plan = $("#inpttarifa_plan").val()
                        if (tarifa_plan === "") {
                            tarifa_plan = 0
                        }
                        var pagoMensualSinIvamasplan = (parseFloat(pagoMensualSinIva) + parseFloat(tarifa_plan)).toFixed(2)

                        $("#inputcuotaMensualEquipoMasPlanSinIva").val(pagoMensualSinIvamasplan);
                        $("#spancuotaMensualEquipoMasPlanSinIva").text(formatearDinero(pagoMensualSinIvamasplan));


                        // Calcular el resultado de la expresión
                        var pagoMensualEquipoMasPlanInclIva = (parseFloat(pagoMensualInclIva) + (parseFloat(tarifa_plan) * (1 + (valor_iva / 100)))).toFixed(2);
                        // console.log(pagoMensualEquipoMasPlanInclIva)
                        $("#inputpagoMensualEquipoMasPlanInclIva").val(pagoMensualEquipoMasPlanInclIva);
                        $("#spanpagoMensualEquipoMasPlanInclIva").text((pagoMensualEquipoMasPlanInclIva));




                        if (plazo > 6) {
                            console.log(pagoMensualInclIva);
                            frdi = (parseFloat(pagoMensualInclIva) * parseFloat(plazo)).toFixed(2);
                        } else {
                            var equi_mas_iva_menos_abono_menos_cbm = $("#inputequiivaabonocbm").val()
                            frdi = parseFloat(equi_mas_iva_menos_abono_menos_cbm).toFixed(2);

                        }

                        $("#inputfrdi").val(frdi);
                        $("#spanfrdi").text(formatearDinero(frdi));

                    }

                })



                $(".datos-pedir-bodega").html(template);

            });








        })


    })


    function formatearDinero(input) {
        // Remover cualquier carácter que no sea un número o un punto decimal
        var cleanedInput = input.replace(/[^0-9.]/g, '');

        // Convertir la cadena a un número de punto flotante
        var dinero = parseFloat(cleanedInput);

        // Verificar si es un número válido
        if (!isNaN(dinero)) {
            // Formatear el número con separadores de miles y dos decimales
            var dineroFormateado = dinero.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            return dineroFormateado;
        } else {
            return "Error: Ingresa un número válido.";
        }
    }


    $("#precio").on("input", function () {
        var dineroIngresado = $(this).val();
        var dineroFormateado = formatearDinero(dineroIngresado);
        $("#precio").val(dineroFormateado);
    })


    $("#precio-edit").on("input", function () {
        var dineroIngresado = $(this).val();
        var dineroFormateado = formatearDinero(dineroIngresado);
        $("#precio-edit").val(dineroFormateado);
    })


    function calcularPago(tasa, periodos, principal, abono) {
        // Convertir la tasa de interés mensual a decimal
        var tasaDecimal = tasa / 100;
    
        // Calcular el pago periódico
        var pago = (principal - abono) * (tasaDecimal / (1 - Math.pow(1 + tasaDecimal, -periodos)));
        pago = Math.round(pago * 100) / 100; // Redondea al número entero más cercano
    
        // Agregar manualmente un centavo al pago
        pago += 0.01;
    
        return pago;
    }

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

    function alerCargar() {
        Swal.fire({
            title: 'Cargando...',
            html: '<i class="fas fa-spinner fa-spin"></i>',
            // allowOutsideClick: false,
            // showCancelButton: false,
            showConfirmButton: false,
            didOpen: () => {}
        });
    }

    


})