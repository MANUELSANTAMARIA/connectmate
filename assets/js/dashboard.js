$(document).ready(function () {
  var funcion = "";
  flatpickr('#fecha-inicio', {
    dateFormat: 'Y-m-d', // Formato de fecha deseado (por ejemplo, 'yyyy-mm-dd')
    // Configuración de idioma
    locale: 'es', // Establecer el idioma a español
  });

  flatpickr('#fecha-fin', {
    dateFormat: 'Y-m-d', // Formato de fecha deseado (por ejemplo, 'yyyy-mm-dd')
    // Configuración de idioma
    locale: 'es', // Establecer el idioma a español
  });
  cargar_home()

  function cargar_home(fecha_inicio, fecha_fin) {
    funcion = "total_productos_vendidos";
    $.post("../controllers/dashboard.php", {
      fecha_inicio,
      fecha_fin,
      funcion
    }, (response) => {
      var valor_registro_venta = response
      $("#total_productos_vendidos").text(valor_registro_venta);

    })

    funcion = "total_productos_recibidos";
    $.post("../controllers/dashboard.php", {
      fecha_inicio,
      fecha_fin,
      funcion
    }, (response) => {
      var valor_registro_venta = response
      $("#total_productos_recibido").text(valor_registro_venta);

    })

    funcion = "productos_mas_vendidos"
    $.post("../controllers/dashboard.php", {
      fecha_inicio,
      fecha_fin,
      funcion
    }, (response) => {
      // console.log(response);
      const productos = JSON.parse(response);
      // Arrays para almacenar las propiedades separadas
      var codigos = [];
      var nombres = [];
      var totalVendido = [];
      productos.forEach(producto => {
        codigos.push(producto.producto_cod);
        nombres.push(producto.nombre_producto);
        totalVendido.push(producto.total_vendido);
      });
      const ctx = $('#miGrafico');
      // Crear un nuevo gráfico
      window.miGrafico = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: nombres,
          datasets: [{
            label: 'Total Despachado',
            data: totalVendido,
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo de las barras
            borderColor: 'rgba(54, 162, 235, 1)', // Color del borde de las barras
            borderWidth: 1
          }]
        },
        options: {
          animation: {
            duration: 1000, // Duración de la animación en milisegundos
            easing: 'easeInOutQuart' // Tipo de interpolación para la animación
          },
          plugins: {
            legend: {
              display: true,
              position: 'top', // Posición de la leyenda
              labels: {
                font: {
                  size: 14 // Tamaño de la fuente de las etiquetas de la leyenda
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 10 // Tamaño del paso en el eje y
              }
            }
          }
        }
    });
    
    })

    funcion = "productos_mas_recibidos"
    $.post("../controllers/dashboard.php", {
      fecha_inicio,
      fecha_fin,
      funcion
    }, (response) => {
      // console.log(response);
      const productos = JSON.parse(response);
      // Arrays para almacenar las propiedades separadas
      var codigos = [];
      var nombres = [];
      var totalVendido = [];
      productos.forEach(producto => {
        codigos.push(producto.producto_cod);
        nombres.push(producto.nombre_producto);
        totalVendido.push(producto.total_vendido);
      });
      const ctx = $('#miGrafico_productos_recibidos');
      // Crear un nuevo gráfico
      window.miGrafico = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: nombres,
          datasets: [{
            label: 'Total Recibidos',
            data: totalVendido,
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo de las barras
            borderColor: 'rgba(54, 162, 235, 1)', // Color del borde de las barras
            borderWidth: 1
          }]
        },
        options: {
          animation: {
            duration: 1000, // Duración de la animación en milisegundos
            easing: 'easeInOutQuart' // Tipo de interpolación para la animación
          },
          plugins: {
            legend: {
              display: true,
              position: 'top', // Posición de la leyenda
              labels: {
                font: {
                  size: 14 // Tamaño de la fuente de las etiquetas de la leyenda
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 10 // Tamaño del paso en el eje y
              }
            }
          }
        }
    });
    
    })
  }


  $(document).on('change', '#fecha-inicio, #fecha-fin', function() {
     // Obtener los valores de los inputs de fecha de inicio y fin
     var fechaInicio = $('#fecha-inicio').val();
     var fechaFin = $('#fecha-fin').val();
    // Verificar si ambos campos de fecha tienen valores
    if (fechaInicio && fechaFin) {
      // Verificar si ya hay un gráfico existente
      if (window.miGrafico) {
        // Si hay un gráfico existente, eliminarlo primero antes de crear uno nuevo
        window.miGrafico.destroy();
      }
      cargar_home(fechaInicio, fechaFin)
      // Aquí puedes realizar cualquier otra acción que desees realizar cuando ambas fechas estén seleccionadas
    }
  });



})