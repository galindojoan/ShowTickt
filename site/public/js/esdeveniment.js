let precioTotal = 0;
let entradasArray = [];
let entradas;
let sessiones;
let contador = 0;
let contadorSession = 0;
let contadorEntrada = 0;
let nuevoDivEntrada = true;
let creaNuevo=true;

const sessionSelect = document.getElementById("fecha");
const divEntradas = document.getElementById("entradas");
const precioSelect = document.getElementById("preu");
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

sessionSelect.addEventListener("change", function () {
    // Verifica si algo está seleccionado
    if (sessionSelect.value) {
        divEntradas.style.display = "block";
        sessiones = sessionSelect.value.split(",");
        contadorSession = parseInt(sessiones[1]);
    }
});

precioSelect.addEventListener("change", function () {
    entradas = precioSelect.value.split(",");
    precioTotal = parseFloat(entradas[0]).toFixed(2);
    maxEntradas.max = parseInt(entradas[1]);
    contadorEntrada = parseInt(entradas[3]);
    mostrarMax.textContent = `Escoge el numero de entradas (Max ${maxEntradas.max})`;
});

buttonEntrada.addEventListener("click", function (e) {
    e.preventDefault;

    if (precioSelect.value) {
        
        if (maxEntradas.max < maxEntradas.value) {
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
            };
            creaNuevo=true;
            entradasArray.forEach((entrada) => {
              if(creaNuevo){
                if (
                  entrada.contadorSession === divReserva.contadorSession &&
                  entrada.contadorEntrada === divReserva.contadorEntrada
              ) {
                  entrada.cantidad = entrada.cantidad + divReserva.cantidad;
                  nuevoDivEntrada = false;
                  creaNuevo=false;
              } else if (
                  entrada.contadorSession === divReserva.contadorSession
              ) {
                  if (
                      entrada.contadorEntrada === divReserva.contadorEntrada
                  ) {
                      entrada.cantidad =
                          entrada.cantidad + divReserva.cantidad;
                      nuevoDivEntrada = false;
                      creaNuevo=false;
                  } else {
                      nuevoDivEntrada = true;
                  }
              } else{
                  nuevoDivEntrada = true;
              }
              }
                
            });
            if (nuevoDivEntrada === true) {
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
