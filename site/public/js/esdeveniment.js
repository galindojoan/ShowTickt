let precioTotal = 0,contador = 0,contadorSession = 0,contadorEntrada = 0;
let entradasArray = [];
let entradas;
let sessiones;
let nuevoDivEntrada = true;
let FinEach=true;

const sessionSelect = document.getElementById("fecha");
const divEntradas = document.getElementById("entradas");
const maxEntradas = document.getElementById("cantidad");
const mostrarMax = document.getElementById("escogerCantidad");
const buttonEntrada = document.getElementById("reservarEntrada");
const total = document.getElementById("precioTotal");
const DivListaEntradas = document.getElementById("listaEntradas");
const containerList = document.getElementById("containerList");
const divError = document.getElementById("errorCantidad");
const mensajeError = document.getElementById("mensajeError");

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

sessionSelect.addEventListener("change", function () {
    // Verifica si algo está seleccionado
    if (sessionSelect.value) {
        divEntradas.style.display = "block";
        sessiones = sessionSelect.value.split(",");
        if (contadorSession!==0) {
          document.getElementById(contadorSession).style.display="none";
          document.getElementById(contadorSession).value="";
          mostrarMax.textContent=" ";
        }
        contadorSession = parseInt(sessiones[1]);
        document.getElementById(contadorSession).style.display="block";
        document.getElementById(contadorSession).addEventListener("change", function () {
          entradas = document.getElementById(contadorSession).value.split(`,`);
          precioTotal = parseFloat(entradas[0]).toFixed(2);
          contadorEntrada = parseInt(entradas[3]);
          maxEntradas.max = verMaximEntradas(parseInt(entradas[1]),contadorSession,contadorEntrada);
      });
    }
});


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
                session: sessiones[0],
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
