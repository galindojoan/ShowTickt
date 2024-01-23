const sessionSelect = document.getElementById('fecha');
const divEntradas = document.getElementById('entradas');
const precioSelect = document.getElementById('preu');
const maxEntradas = document.getElementById('cantidad');
const mostrarMax = document.getElementById('escogerCantidad');
const buttonEntrada = document.getElementById('reservarEntrada');
const total = document.getElementById('precioTotal');
const DivListaEntradas = document.getElementById('listaEntradas');
const buttonEliminar = document.getElementById('eliminarReserva');
const containerList = document.getElementById('containerList');
const divError = document.getElementById('errorCantidad');
const mensajeError = document.getElementById('mensajeError');

let precioTotal=0;
let entradasArray=[];
let entradas;
let contador=0;

sessionSelect.addEventListener('change', function() {
  // Verifica si algo está seleccionado
  if (sessionSelect.value) {
      divEntradas.style.display = 'block';
  }
});

precioSelect.addEventListener('change', function() {     
      entradas=precioSelect.value.split(",");
      console.table(entradas);
      precioTotal=parseFloat(entradas[0]).toFixed(2);
      maxEntradas.max = parseInt(entradas[1]);
      mostrarMax.textContent=`Escoge el numero de entradas (Max ${maxEntradas.max})`;
});

buttonEntrada.addEventListener('click', function(e) { 
  e.preventDefault;
  precioTotal=(precioTotal*maxEntradas.value);
  if(maxEntradas.max<maxEntradas.value){
    mensajeError.textContent=`La cantidad escogida supera la máxima, escoge un número inferior a ${maxEntradas.max}`;
    divError.style.display = 'block';
    // Ocultar el div después de 3 segundos
    setTimeout(function() {
      divError.style.display = 'none';
    }, 3000);
  }else if(maxEntradas.value<=0){
    mensajeError.textContent="La cantidad escogida es inferior a 1";
    divError.style.display = 'block';
    // Ocultar el div después de 3 segundos
    setTimeout(function() {
      divError.style.display = 'none';
    }, 3000);
  }else{
    let divReserva={
      session:sessionSelect.value,
      nom:entradas[2],
      cantidad:maxEntradas.value
    };

    divError.style.display = 'none';

            // Crear un nuevo div con el número y la posición
            const nuevoDiv = document.createElement('div');
            nuevoDiv.id = 'numeroDiv';
            nuevoDiv.textContent += `Sessio:${divReserva.session}`;
            nuevoDiv.textContent += `Entrada:${divReserva.nom}`;
            nuevoDiv.textContent += `Capacidad:${divReserva.cantidad}`;

            // Añadir el nuevo div al container
            DivListaEntradas.appendChild(nuevoDiv);

    containerList;
    total.textContent="Total: "+precioTotal+"€";
    DivListaEntradas.style.display = 'block';
    entradasArray.push(divReserva);
  }
});
