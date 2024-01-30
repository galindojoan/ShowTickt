let precioTotal = 0,contador = 0,contadorSession = 0,contadorEntrada = 0;
let entradasArray = [];
let entradas;
let sessiones;
let nuevoDivEntrada = true;
let FinEach=true;

const divEntradas = document.getElementById("entradas");
const maxEntradas = document.getElementById("cantidad");
const mostrarMax = document.getElementById("escogerCantidad");
const buttonEntrada = document.getElementById("reservarEntrada");
const total = document.getElementById("precioTotal");
const DivListaEntradas = document.getElementById("listaEntradas");
const containerList = document.getElementById("containerList");
const divError = document.getElementById("errorCantidad");
const mensajeError = document.getElementById("mensajeError");

function pad(numero) {
  return numero < 10 ? '0' + numero : numero;
}

function convertirFormato(fechaHoraString) {
  const fechaHora = new Date(fechaHoraString);
  const año = fechaHora.getFullYear();
  const mes = pad(fechaHora.getMonth() + 1);
  const dia = pad(fechaHora.getDate());
  const hora = pad(fechaHora.getHours() - 5); // Ajuste de la diferencia horaria
  const minuto = pad(fechaHora.getMinutes());
  const segundo = pad(fechaHora.getSeconds());

  return `${año}-${mes}-${dia}T${hora}:${minuto}:${segundo}`;
}

function obtenerSiguienteHora(fechaHoraString) {
  const fechaHora = new Date(fechaHoraString);
  fechaHora.setHours(fechaHora.getHours() + 1);
  const año = fechaHora.getFullYear();
  const mes = pad(fechaHora.getMonth() + 1);
  const dia = pad(fechaHora.getDate());
  const hora = pad(fechaHora.getHours());
  const minuto = pad(fechaHora.getMinutes());
  const segundo = pad(fechaHora.getSeconds());

  return `${año}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;
}

function compararFechas(a, b) {
  var fechaA = new Date(a.data);
  var fechaB = new Date(b.data);

  return fechaA - fechaB;
}

function crearEventos(Session) {
  var eventos = [];
  let cont = 1;
  // Crea eventos para diferentes horas en el día
  Session.forEach(fechaSession => {
    let siguienteHora=obtenerSiguienteHora(fechaSession.data);
      var evento = {
          title: `${cont} Session`,
          start: `${convertirFormato(fechaSession.data)}`,
          end: `${convertirFormato(siguienteHora)}`
      }
      eventos.push(evento);
      cont++;
  });
  return eventos;
}

function reiniciarEntradas() {
    containerList.innerHTML = " ";
    entradasArray.forEach((entrada) => {
        const nuevoDiv = document.createElement("div");
        containerList.appendChild(nuevoDiv);
        nuevoDiv.id = contador;
        let sessionP = document.createElement("p");
        sessionP.textContent = entrada.session;
        let entradaP = document.createElement("p");
        entradaP.textContent = entrada.nom;
        let cantidadP = document.createElement("p");
        cantidadP.textContent = entrada.cantidad;

        nuevoDiv.appendChild(sessionP);
        nuevoDiv.appendChild(entradaP);
        nuevoDiv.appendChild(cantidadP);

        const btnBorrar = document.createElement("button");
        btnBorrar.id = contador;
        btnBorrar.type = "button";
        btnBorrar.class = "borrarEntrada";
        btnBorrar.textContent = "eliminar";
        // Añadir el nuevo div al container
        contador++;
        containerList.appendChild(btnBorrar);
    });
}

function verMaximEntradas(max,Session,Entrada)  {
  let esZero=false;
  if (entradasArray.length!==0) {
    entradasArray.forEach((entrada) => {
    
      if(FinEach){
        if (
          entrada.contadorSession === Session &&
          entrada.contadorEntrada === Entrada
      ) {
          max=entrada.Maxcantidad;
          FinEach=false;
          if (entrada.Maxcantidad<=0) {
            esZero=true;
          }
          
      }
      }
    });
  }
  if (esZero) {
    console.log("entrp",max);
    max=0;
    vermax(max);
    return max;  
  }else{
    vermax(max);
    return max; 
  }
}
function vermax(entrada)  {
  if (entrada<=0) {
    mostrarMax.textContent = `Escoge otra entrada, esta entrada esta agotada`;
    maxEntradas.max=0;
    cantidad = 0;
  }else{
    mostrarMax.textContent = `Escoge el numero de entradas (Max ${entrada})`;
  }
}

function sessionSelect(ArraySession){
  divEntradas.style.display = "block";
  if (contadorSession!==0) {
    document.getElementById(contadorSession).style.display="none";
    document.getElementById(contadorSession).value="";
    mostrarMax.textContent=" ";
  }
  contadorSession = parseInt(ArraySession.id);
  document.getElementById(contadorSession).style.display="block";
  document.getElementById(contadorSession).addEventListener("change", function () {
    entradas = document.getElementById(contadorSession).value.split(`,`);
    precioTotal = parseFloat(entradas[0]).toFixed(2);
    contadorEntrada = parseInt(entradas[3]);
    maxEntradas.max = verMaximEntradas(parseInt(entradas[1]),contadorSession,contadorEntrada);
});
sessiones=ArraySession;
}

buttonEntrada.addEventListener("click", function (e) {
    e.preventDefault;

    if (document.getElementById(contadorSession).value) {
        if (maxEntradas.max<=0) {
          mensajeError.textContent = `Entradas Agotadas`;
            divError.style.display = "block";
            // Ocultar el div después de 3 segundos
            setTimeout(function () {
                divError.style.display = "none";
            }, 3000);
        }else if (maxEntradas.max < maxEntradas.value) {
            mensajeError.textContent = `La cantidad escogida supera la máxima, escoge un número inferior a ${maxEntradas.max}`;
            divError.style.display = "block";
            // Ocultar el div después de 3 segundos
            setTimeout(function () {
                divError.style.display = "none";
            }, 3000);
        } else if (maxEntradas.value <= 0) {
            mensajeError.textContent = "La cantidad escogida es inferior a 1";
            divError.style.display = "block";
            // Ocultar el div después de 3 segundos
            setTimeout(function () {
                divError.style.display = "none";
            }, 3000);
        } else {
            divError.style.display = "none";
            let divReserva = {
                session: sessiones.id,
                nom: entradas[2],
                cantidad: parseInt(maxEntradas.value),
                contadorSession: contadorSession,
                contadorEntrada: contadorEntrada,
                Maxcantidad: parseInt(maxEntradas.max-maxEntradas.value),
            };
            FinEach=true;
            entradasArray.forEach((entrada) => {
              if(FinEach){
                if (
                  entrada.contadorSession === divReserva.contadorSession &&
                  entrada.contadorEntrada === divReserva.contadorEntrada
              ) {
                  entrada.cantidad = entrada.cantidad + divReserva.cantidad;
                  entrada.Maxcantidad =entrada.Maxcantidad-entrada.cantidad;
                  maxEntradas.max=entrada.Maxcantidad;
                  vermax(maxEntradas.max);
                  nuevoDivEntrada = false;
                  FinEach=false;
              // } else if (
              //     entrada.contadorSession === divReserva.contadorSession
              // ) {
              //     if (
              //         entrada.contadorEntrada === divReserva.contadorEntrada
              //     ) {
              //         entrada.cantidad = entrada.cantidad + divReserva.cantidad;
              //         entrada.Maxcantidad =entrada.Maxcantidad-entrada.cantidad;
              //         maxEntradas.max=entrada.Maxcantidad;
              //         mostrarMax.textContent = `Escoge el numero de entradas (Max ${maxEntradas.max})`;
              //         nuevoDivEntrada = false;
              //         FinEach=false;
              //     } else {
              //         nuevoDivEntrada = true;
              //     }
              } else{
                  nuevoDivEntrada = true;
              }
              }
                
            });
            if (nuevoDivEntrada === true) {
              maxEntradas.max=divReserva.Maxcantidad;
              vermax(maxEntradas.max);
                entradasArray.push(divReserva);
            }
            precioTotal = precioTotal * maxEntradas.value;
            reiniciarEntradas();
            total.textContent = "Total: " + precioTotal + "€";
            DivListaEntradas.style.display = "block";
        }
    } else {
        mensajeError.textContent = "Escoge una entrada";
        divError.style.display = "block";
        // Ocultar el div después de 3 segundos
        setTimeout(function () {
            divError.style.display = "none";
        }, 3000);
    }
});

document.getElementById('arrayEntradas').value = JSON.stringify(entradasArray);
//$datosArray = json_decode($request->input('datos_array'));
