// Espera a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {
    //Declaramos variables
    var body = document.getElementById("body");
    var menuAbierto = false;
    var side_menu = document.getElementById("menu_side");
     //Ejecutar función en el evento click
     document.getElementById("btn_open").addEventListener("click", open_close_menu);
     //Evento para mostrar y ocultar menú
     function open_close_menu() {
         if (menuAbierto) {
             // Si el menú está abierto, realiza la acción para cerrarlo
             body.classList.remove("body_move");
             side_menu.classList.remove("menu__side_move");
             var cambiardireccion = "<i class='fa-solid fa-caret-right' id='btn_open'></i>";
             var btn_menu_side = document.getElementById("cambiar-direccion");
             btn_menu_side.innerHTML = cambiardireccion;
             var btn_open = document.getElementById("btn_open");
             btn_open.classList.remove("move_btn_open");
             btn_open.classList.add("btn_open");
             menuAbierto = false;
             document.getElementById("btn_open").addEventListener("click", open_close_menu);
         } else {
             // Si el menú está cerrado, realiza la acción para abrirlo
             body.classList.add("body_move");
             side_menu.classList.add("menu__side_move");
             var cambiardireccion = "<i class='fa-solid fa-caret-left' id='btn_open'></i>";
             var btn_menu_side = document.getElementById("cambiar-direccion");
             btn_menu_side.innerHTML = cambiardireccion;
             var btn_open = document.getElementById("btn_open");
             btn_open.classList.remove("btn_open");
             btn_open.classList.add("move_btn_open");
             menuAbierto = true;
             document.getElementById("btn_open").addEventListener("click", open_close_menu);
         }
     }
    
     // poner barra vertical 
     var selected_elements = document.querySelectorAll(".selected")
     // Agrega un manejador de eventos de clic a cada elemento
     selected_elements.forEach(function(selectedElement) {
         selectedElement.addEventListener("click", function(){

         // Elimina la clase "selectedd" de todos los elementos
         selected_elements.forEach(function(element){
             element.classList.remove("selectedd")
         })
 
         // Verifica si el elemento actual NO tiene la clase "home"
         if(!selectedElement.classList.contains("home")){
             // Agrega la clase "selectedd" al elemento si no es el elemento "home"
             selectedElement.classList.add("selectedd")
         }
         
 
     })
     });
 
 
 
     //Haciendo el menú responsive(adaptable)
     window.addEventListener("resize", function(){
 
         if (window.innerWidth > 760){
     
             body.classList.remove("body_move");
             side_menu.classList.remove("menu__side_move");
             
         }
     
         if (window.innerWidth < 760){
     
             body.classList.add("body_move");
             side_menu.classList.add("menu__side_move");
             
         }
     
     });
     
 
 
 
 
 
     // open menu de ajustes
     const dropdownToggle = document.querySelector(".menu__ajustes .open-menu-ajustes");
     const dropdownMenu = document.querySelector(".menu__ajustes .dropdown-content");
     dropdownToggle.addEventListener("click", function(e){
         e.stopPropagation(); // Evita que el evento llegue al contenedor principal
        //  console.log("abrir")
         // Alterna la clase 'show-dropdown' en el menú desplegable
         dropdownMenu.classList.toggle("show-dropdown");
         
         // Cierra el menú cuando se hace clic en cualquier lugar fuera de él
     window.addEventListener("click", function (event) {
         if (!event.target.matches(".menu__ajustes .open-menu-ajustes")) {
             dropdownMenu.classList.remove("show-dropdown");
         }
     });
 
 
     })
     
    // controlo lo desplegable de cada menu de opciones
    var listItems = document.querySelectorAll(".list__item");
    listItems.forEach(listItem => {
        var optionLink = listItem.querySelector('.option');
        var listShow = listItem.querySelector('.list__show');
       
        optionLink.addEventListener('click', (e) => {
        // Evitar que el enlace siga el enlace href="#" y cause la recarga de la página
        e.preventDefault();
         
        // Ocultar todas las listas y quitar la clase "selected" de todos los elementos
        listItems.forEach(item => {
            var show = item.querySelector('.list__show');
            show.classList.remove("visible");
            var selector = item.querySelector("div");
            selector.classList.remove("selected")
            
        });

        // Obtener el elemento padre y agregar la clase "selected" al elemento clicado
        var selected = optionLink.parentNode;
        selected.classList.add("selected");


        // Mostrar la lista interna asociada al enlace clicado
        listShow.classList.add("visible");


        });
    });




       

     
 });
 



 
 
 
 
 