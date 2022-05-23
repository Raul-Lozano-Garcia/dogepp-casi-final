"use strict"

//EFECTO SCROLL INFO
const info_h2=document.querySelectorAll("#info h2");

if(info_h2.length>0){
    document.addEventListener("scroll",
    ()=>{
        let top=document.documentElement.scrollTop;
        if(top>100){
            info_h2[0].classList.add("info_h2");
            
        }

        if(top>520){
            info_h2[1].classList.add("info_h2");
        }
    });
}


//MODAL COOKIES
const cookieModal = document.querySelector(".cookie-consent-modal")
const cancelCookieBtn = document.querySelector(".btn.cancel")
const acceptCookieBtn = document.querySelector(".btn.accept")

if(cancelCookieBtn!==null){
    cancelCookieBtn.addEventListener("click", ()=>{
        cookieModal.classList.remove("active")
    })
    acceptCookieBtn.addEventListener("click", ()=>{
        cookieModal.classList.remove("active")
        localStorage.setItem("cookieAccepted", "yes")
    })
    
    setTimeout(()=>{
        const cookieAccepted = localStorage.getItem("cookieAccepted")
        if (cookieAccepted != "yes"){
            cookieModal.classList.add("active")
        }
    }, 2000)
}

// API COVID-19
const contador_espania=document.querySelector(".contador_espania");
const contador_espania_hoy=document.querySelector(".contador_espania_hoy");
const contador_mundo=document.querySelector(".contador_mundo");
const fecha = new Date();
const mes=fecha.getMonth() + 1;
let mes_formateado;
if(mes<=9){
    mes_formateado="0"+mes;
}else{
    mes_formateado=mes;
}
const anio_formateado=fecha.getFullYear();
const dia=fecha.getDate();
let dia_formateado;
if(dia<=9){
    dia_formateado="0"+dia;
}else{
    dia_formateado=dia;
}

if(contador_espania!==null){

    (async () => {

        const respuesta1= await fetch(`https://api.covid19tracking.narrativa.com/api/${anio_formateado}-${mes_formateado}-${dia_formateado}/country/spain`);

        const datos1=await respuesta1.json();

        const lista1=datos1["dates"][`${anio_formateado}-${mes_formateado}-${dia_formateado}`]["countries"]["Spain"]["today_confirmed"];

        contador_espania.setAttribute("data-target",lista1);

        const respuesta2= await fetch(`https://api.covid19tracking.narrativa.com/api/${anio_formateado}-${mes_formateado}-${dia_formateado}/country/spain`);

        const datos2=await respuesta2.json();

        const lista2=datos2["dates"][`${anio_formateado}-${mes_formateado}-${dia_formateado}`]["countries"]["Spain"]["today_new_confirmed"];

        contador_espania_hoy.setAttribute("data-target",lista2);

        const respuesta3= await fetch(`https://api.covid19tracking.narrativa.com/api/${anio_formateado}-${mes_formateado}-${dia_formateado}/country/spain`);

        const datos3=await respuesta3.json();

        const lista3=datos3["total"]["today_confirmed"];

        contador_mundo.setAttribute("data-target",lista3);

        const contadores=document.querySelectorAll(".contador");

        contadores.forEach(
            (contador)=>{
                contador.innerText='0';

                document.addEventListener("scroll",
                ()=>{
                    let top=document.documentElement.scrollTop;

                        if(top>1950){
                    
                            contador.classList.add("contador_animacion");
                
                            const actualizar_contador=()=>{
                                const total=+contador.getAttribute("data-target");
                                const c=+contador.innerText;
                
                                const incremento=total/5000;
                
                                if(c<total){
                                    contador.innerText=`${Math.ceil(c + incremento)}`;
                                    setTimeout(actualizar_contador,1);
                                }else{
                                    contador.innerText=total;
                                }
                            }
                            actualizar_contador();
                
                    }
            
                });
            }
        );

    })();

}

//FORMULARIO ACCESO
const form = document.querySelector('#requires-validation');

if(form!==null){
    form.addEventListener('submit', (event)=> {
        if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
        }
    
        form.classList.add('was-validated')
    }, false);
}

//SECCION PRINCIPAL
const seccionP = document.querySelectorAll("#secciones-principales .col-md-4");
const seccionS = document.querySelector("#subsecciones-principales");

if(seccionP!==null){
    seccionP.forEach(
        (colSeccionP)=>{
            colSeccionP.addEventListener("click",
                ()=>{
                    colSeccionP.classList.toggle("seccion-activa");
                    colSeccionP.firstElementChild.nextElementSibling.classList.toggle("subseccion");

                })
        }
    )
}

//AJUSTES
const ajustes = document.querySelector(".rotacion");
const divAjustes = document.querySelector(".rotacion>div");

if(ajustes!==null){
    ajustes.addEventListener("click",
        ()=>{
            divAjustes.classList.toggle("d-block");
        })
}

// SCROLL SIEMPRE ABAJO AL CARGAR EL CHAT
const mensajeLog = document.querySelector("#mensajeLog");
if(mensajeLog!==null){
    mensajeLog.scrollTop = mensajeLog.scrollHeight;
}

// BUSCADOR
document.addEventListener("keyup", e=>{
    if(e.target.matches("#search")){

        if (e.key ==="Escape")e.target.value = "";
    
        document.querySelectorAll(".fila_a_buscar").forEach(fila =>{

            const nombre=fila.querySelector("h2");
            nombre.textContent.toLowerCase().includes(e.target.value.toLowerCase())
                ?fila.classList.remove("quitar")
                :fila.classList.add("quitar")
        })
    
    }

})

// ABRIR EL MODAL DE ACEPTAR SOLICITUDES
document.addEventListener("click",
    (e)=>{
        if(e.target.matches(".abrir_modal_amigo")){
            document.querySelector(".boton_agregar_amigo").classList.add("poner");
        }

        if(e.target.matches(".boton_agregar_amigo>div")){
            document.querySelector(".boton_agregar_amigo").classList.remove("poner");
        }
    });

// COPIAR URL AL PORTAPAPELES
const boton_copiar_url=document.querySelector(".copiarURL");

if(boton_copiar_url!==null){
    boton_copiar_url.addEventListener("click",
        ()=>{
            let inputc = document.body.appendChild(document.createElement("input"));
            inputc.value = window.location.href;
            inputc.select();
            document.execCommand('copy');
            inputc.parentNode.removeChild(inputc);
        });
}




//----------------------------------------------------------------------------------------------------------
//API INTERNA

//TABLA DE EVENTOS
const tabla_eventos = document.querySelector("#lista_eventos");

//LAZY LOADING
let imageOptions={threshold:0};

const observer= new IntersectionObserver((entries,observer)=>{
  entries.forEach(
    (entry)=>{
      if(!entry.isIntersecting) return;
      const image=entry.target;
      const newURL= image.getAttribute("data-src");
      image.src=newURL;
      observer.unobserve(image);
    }
  );
}, imageOptions);


  const nuevoEvento = (json) => {
    let articulo=document.createElement("article");
    articulo.classList.add("eventos");
    articulo.id = "ID_" + json["nombre"].toUpperCase().replaceAll(" ", "");
  
    //CREA LA CELDA CON LA IMAGEN
    let imagen = document.createElement("img");
    imagen.setAttribute("data-src",json["imagen"]);
    imagen.setAttribute("class","img-fluid");
    let td_imagen = document.createElement("div");
    td_imagen.appendChild(imagen);
    articulo.appendChild(td_imagen);
    observer.observe(imagen);

    //CREO LA CELDA DONDE VA TODO LO DEMAS PARA QUE FUNCIONE BIEN EL DISPLAY FLEX
    let td_div = document.createElement("div");
  
    //CREA LA CELDA CON EL NOMBRE
    let td_nombre = document.createElement("h2");
    td_nombre.style.lineHeight="2em";
    td_nombre.setAttribute("class","fw-bold mb-0");
    td_nombre.innerText = json["nombre"];
    td_div.appendChild(td_nombre);

    //CREA LA CELDA CON LA LOCALIZACION
    let td_localizacion = document.createElement("h4");
    td_localizacion.innerText = json["localizacion"];
    td_div.appendChild(td_localizacion);
  
    //CREA LA CELDA CON LA FECHA
    let td_fecha = document.createElement("span");
    td_fecha.setAttribute("class","d-block mb-3");
    const fecha_formateada=json["fecha"].split("-");
    td_fecha.innerText = fecha_formateada[2]+"-"+fecha_formateada[1]+"-"+fecha_formateada[0];
  
    td_div.appendChild(td_fecha);
  
      //CREA LA CELDA CON EL CONTENIDO
    let td_descripcion = document.createElement("p");

    const textoCrudo=json["descripcion"];

    let textoAreaDividido = textoCrudo.split(" ");
    let numeroPalabras = textoAreaDividido.length;

    if(numeroPalabras>20){
      for (let i = 0; i < 20; i++) {
        td_descripcion.innerText += textoAreaDividido[i]+" ";
    }
      td_descripcion.innerText += "...";
    }else{
      td_descripcion.innerText = textoCrudo;
    }
  
  
    td_div.appendChild(td_descripcion);

    articulo.appendChild(td_div);

    //CREO LA CELDA DONDE VA TODO LO DEMAS PARA QUE FUNCIONE BIEN EL DISPLAY FLEX
    let td_div2 = document.createElement("div");
    td_div2.classList.add("align-self-center","ms-auto","d-flex");
    td_div2.style.gap="1em";
  
    //CREA LA CELDA CON EL BOTON DE EDITAR EL EVENTO
    let formulario=document.createElement("form");
    formulario.action="evento.php";
    formulario.method="POST";
  
    let input_hidden=document.createElement("input");
    input_hidden.type="hidden";
    input_hidden.name="id";
    input_hidden.id="id";
    input_hidden.value=json["id"];
  
    let input_submit=document.createElement("input");
    input_submit.type="submit";
    input_submit.setAttribute("name","editar");
    input_submit.setAttribute("class","btn boton_analogo");
    input_submit.value="Editar";
  
    formulario.appendChild(input_hidden);
    formulario.appendChild(input_submit);
  
    td_div2.appendChild(formulario);


    //CREA LA CELDA CON EL BOTON DE BORRAR EL EVENTO
    let formulario2=document.createElement("form");
    formulario2.action="panel.php";
    formulario2.method="POST";
  
    let input_hidden2=document.createElement("input");
    input_hidden2.type="hidden";
    input_hidden2.name="id";
    input_hidden2.id="id";
    input_hidden2.value=json["id"];
  
    let input_submit2=document.createElement("input");
    input_submit2.type="submit";
    input_submit2.setAttribute("name","borrar");
    input_submit2.setAttribute("class","btn boton_complementario");
    input_submit2.value="Borrar";
  
    formulario2.appendChild(input_hidden2);
    formulario2.appendChild(input_submit2);
  
    td_div2.appendChild(formulario2);

    articulo.appendChild(td_div2);
    //================================================================================================
  
    return articulo;
  }

//=========AÑADIR NUEVO EVENTO COMPROBANDO ANTES LOS DATOS=======================
const form_añadir = document.querySelector("#insertar_evento_form");

if(form_añadir!==null){
  const nombre = document.querySelector("#nombre");
  const localizacion = document.querySelector("#localizacion");
  const descripcion = document.querySelector("#descripcion");
  const imagen = document.querySelector("#imagen");
  const fecha = document.querySelector("#fecha");
  const b_nuevo=document.querySelector("#enviarEvento");


  b_nuevo.addEventListener("click",async (evento) => {
    evento.preventDefault();
    if (nombre.value.trim().length <= 0 || nombre.value.trim().length > 100) {
      mensajeError("Nombre incorrecto");
    } else if (descripcion.value.trim().length <= 0 || descripcion.value.trim().length > 5000) {
        mensajeError("Descripcion incorrecta");
    } else if (localizacion.value.trim().length <= 0 || localizacion.value.trim().length > 5000) {
      mensajeError("Localizacion incorrecta");
    } else if (imagen.value.trim().length <= 0 || imagen.value.trim().length > 1000) {
      mensajeError("Imagen incorrecta");
    } else if (fecha.value.trim().length <= 0) {
      mensajeError("Fecha vacia");
    } else if (sessionStorage.getItem("ID_" + nombre.value.trim().toUpperCase().replaceAll(" ", "")) !== null) {
      mensajeError("El evento ya existe");
    } else {
      //MANDAR LOS DATOS DEL FORMULARIO A LA API DE INSERTAR
      const datos_formulario=new URLSearchParams(new FormData(form_añadir));
      const respuesta=await fetch("eventoInsertar.php",
      {
        method:"POST",
        body:datos_formulario
      });
  
      const id_evento=await respuesta.json();
      
      const datos_evento = {
        "id":id_evento,
        "nombre": nombre.value.trim(),
        "imagen": imagen.value.trim(),
        "descripcion": descripcion.value.trim(),
        "localizacion": localizacion.value.trim(),
        "fecha": fecha.value.trim()
      };
  
      const nuevo = nuevoEvento(datos_evento);
      tabla_eventos.appendChild(nuevo);
      sessionStorage.setItem("ID_" + nombre.value.trim().toUpperCase().replaceAll(" ", ""), JSON.stringify(datos_evento));
  
      form_añadir.reset();
      document.documentElement.scrollTop = document.documentElement.scrollHeight;
      mensajeOk("Añadido correctamente");
    }
  });
}



//AÑADIR LOS DATOS DEL STORAGE PARA MANEJAR LA APLICACION A TRAVES DE ELLOS Y NO TENER QUE USAR SIEMPRE LA BASE DE DATOS
if(tabla_eventos!==null){
    sessionStorage.clear();
    //LA PRIMERA VEZ QUE SE CARGUE LA PAGINA-->METERLO TODO EN EL SESSION

    (async () => {
      const respuesta = await fetch("eventoTabla.php");
      //DATOS_EVENTOS SE OBTIENE DE LA API INTERNA QUE NOS DEVUELVE LO QUE HAY EN LA BASE DE DATOS
      const datos_eventos = await respuesta.json();

      datos_eventos.forEach((evento) => {
        sessionStorage.setItem("ID_" + evento["nombre"].
          toUpperCase()
          .replaceAll(" ", ""),
          JSON.stringify(evento))
      });
      //METER LOS DATOS EN LA TABLA DEL INTERFAZ
      Object.values(sessionStorage).forEach(
        (evento) => {
          tabla_eventos.appendChild(nuevoEvento(JSON.parse(evento)));
        }
      )
    })();
}