import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.querySelector('form');
const tablaReportes = document.getElementById('tablaReportes');
const thalumno = document.getElementById('nombre')
const thgrado = document.getElementById('grado')
const thnacionalidad = document.getElementById('nacionalidad')
const thpromedio = document.getElementById('promedio')
const btnBuscar = document.getElementById('btnBuscar');
const divTabla = document.getElementById('divTabla');

// Función para calcular el promedio de un array de números
function calcularPromedio(array) {
    if (array.length === 0) return 0;
    const sum = array.reduce((total, value) => total + value, 0);
    return sum / array.length;
}

// Función para cambiar el color del texto en la columna calificacion_punteo si es menor a 60
function aplicarColorCalificacionPunteo(td, calificacionPunteo) {
    if (parseFloat(calificacionPunteo) < 60) {
        td.style.color = 'red';
    }
}

const buscar = async () => {
    let id= document.getElementById('calificacion_asignacion').value;
 
  
    const url = `/proyecto3/API/reportes/buscar?id_asignacion=${id}`;
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method: 'GET',
        headers: headers
    }

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();se trabaj
       console.log(data)
       return

        tablaReportes.tBodies[0].innerHTML = '';
        const fragment = document.createDocumentFragment();
        const calificacionPunteoArray = [];

        if (data.length > 0) {
            let contador = 1;
            data.forEach(calificacion => {
                const tr = document.createElement('tr');
                const td1 = document.createElement('td')
                const td2 = document.createElement('td')
                const td3 = document.createElement('td')
                const td4 = document.createElement('td')

                td1.innerText = contador;
                td2.innerText = calificacion.materia_asignada;
                td3.innerText = calificacion.calificacion_punteo;
                td4.innerText = calificacion.calificacion_resultado;

                thalumno.innerText = calificacion.alumno_nombre;
                thgrado.innerText = calificacion.grado_y_arma;
                thnacionalidad.innerText = calificacion.nacionalidad;

                // Llamar a la función para aplicar el color en la columna calificacion_punteo
                aplicarColorCalificacionPunteo(td3, calificacion.calificacion_punteo);

                // ESTRUCTURANDO DOM
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                
                // Agregar calificación_punteo al array para el cálculo del promedio
                calificacionPunteoArray.push(parseFloat(calificacion.calificacion_punteo));

                fragment.appendChild(tr);

                contador++;
            });

            // Calcular el promedio de las calificaciones
            const promedio = calcularPromedio(calificacionPunteoArray);
            
            // Mostrar el promedio en thpromedio
            thpromedio.innerText = 'Promedio: ' + promedio.toFixed(2);
        } else {
            const tr = document.createElement('tr');
            const td = document.createElement('td')
            td.innerText = 'No existen registros'
            td.colSpan = 4
            tr.appendChild(td)
            fragment.appendChild(tr);
        }
        
        tablaReportes.tBodies[0].appendChild(fragment);

    } catch (error) {
        console.log(error);
    }
}

btnBuscar.addEventListener('click', buscar);