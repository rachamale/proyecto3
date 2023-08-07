import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast ,confirmacion} from "../funciones";

const formulario = document.querySelector('form')
const tablaAlumnos = document.getElementById('tablaAlumnos')
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('divTabla');

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

const guardar = async (evento) => {
    evento.preventDefault();
    if(!validarFormulario(formulario, ['id_alumnos'])){
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return 
    }

    const body = new FormData(formulario)
    body.delete('id_alumnos')
    const url = '/proyecto3/API/alumnos/guardar';
    const config = {
        method : 'POST',
        // body: otroNombre
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        // return
        
        const {codigo, mensaje,detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                break;
        
            case 0:
                icon = 'error'
                console.log(detalle)
                break;
        
            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const buscar = async () => {

    let alu_nombre = formulario.alu_nombre.value;
    let alu_apellido = formulario.alu_apellido.value;
    const url = `/proyecto3/API/alumnos/buscar?alu_nombre=${alu_nombre}&alu_apellido=${alu_apellido}`;
    const headers = new Headers();
    headers.append("X-Requested-With","fetch");
    const config = {
        method : 'GET',
    }

    try {
        const respuesta = await fetch(url, config) 
        const data = await respuesta.json();
        //     return response
        //   })(function(data) {
    
        //     console.log(data);  
        //   });
        // const data =  respuesta
        // console.log(data);
        
        
        tablaAlumnos.tBodies[0].innerHTML = ''
        const fragment = document.createDocumentFragment();
        if(data.length > 0){
            let contador = 1;
            data.forEach( alumnos => {
                // CREAMOS ELEMENTOS
                const tr = document.createElement('tr');
                const td1 = document.createElement('td')
                const td2 = document.createElement('td')
                const td3 = document.createElement('td')
                const td4 = document.createElement('td')
                const td5 = document.createElement('td')
                const td6 = document.createElement('td')
                const td7= document.createElement('td')
                const td8 = document.createElement('td')
                const buttonModificar = document.createElement('button')
                const buttonEliminar = document.createElement('button')
                //const buttonReporte = document.createElement('button')

                // CARACTERISTICAS A LOS ELEMENTOS
                buttonModificar.classList.add('btn', 'btn-warning')
                buttonEliminar.classList.add('btn', 'btn-danger')
                buttonModificar.textContent = 'Modificar'
                buttonEliminar.textContent = 'Eliminar'

                buttonModificar.addEventListener('click', () => colocarDatos(alumnos))
                buttonEliminar.addEventListener('click', () => eliminar(alumnos.id_alumnos))                
                //buttonEliminar.addEventListener('click', () => reporte(alumno.id_alumnos))

                td1.innerText = contador;
                td2.innerText = alumnos.alu_nombre
                td3.innerText = alumnos.alu_apellido
                td4.innerText = alumnos.alu_grado
                td5.innerText = alumnos.alu_arma
                td6.innerText = alumnos.alu_nac
                
                
                // ESTRUCTURANDO DOM
                td7.appendChild(buttonModificar)
                td8.appendChild(buttonEliminar)
                tr.appendChild(td1)
                tr.appendChild(td2)
                tr.appendChild(td3)
                tr.appendChild(td4)
                tr.appendChild(td5)
                tr.appendChild(td6)
                tr.appendChild(td7)
                tr.appendChild(td8)

                fragment.appendChild(tr);

                contador++;
            })
        }else{
            const tr = document.createElement('tr');
            const td = document.createElement('td')
            td.innerText = 'No existen registros'
            td.colSpan = 5
            tr.appendChild(td)
            fragment.appendChild(tr);
        }

        tablaAlumnos.tBodies[0].appendChild(fragment)
    } catch (error) {
        console.log(error);
    }
}


const colocarDatos = (datos) => {

    formulario.id_alumnos.value = datos.id_alumnos
    formulario.alu_nombre.value = datos.alu_nombre
    formulario.alu_apellido.value = datos.alu_apellido    
    formulario.alu_grado.value = datos.alu_grado
    formulario.alu_arma.value = datos.alu_arma  
    formulario.alu_nac.value = datos.alu_nac

    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none'
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none'
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = ''
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = ''
    divTabla.style.display = 'none'

    // modalEjemploBS.show();
}

const cancelarAccion = () => {
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
    divTabla.style.display = ''
}

const modificar = async () => {
    if(!validarFormulario(formulario)){
        alert('Debe llenar todos los campos');
        return 
    }

    const body = new FormData(formulario)
    const url = '/proyecto3/API/alumnos/modificar';
    const headers = new Headers();
    for (var pair of body.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }
    headers.append("X-Requested-With","fetch");
    const config = {
        method: 'POST',
        body
    }


    try {
        // fetch(url, config).then( (respuesta) => respuesta.json() ).then(d => data = d)
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        
        const {codigo, mensaje,detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                cancelarAccion();
                break;
        
            case 0:
                icon = 'error'
                console.log(detalle)
                break;
        
            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const eliminar = async (id) => {
    if(await confirmacion('warning','¿Desea eliminar este registro?')){
        
        const body = new FormData()
        body.append('id_alumnos', id)
        const url = '/proyecto3/API/alumnos/eliminar';
        
        const headers = new Headers();        
        headers.append("X-Requested-With","fetch");
        const config = {
            method: 'POST',
            body
        }
        try {
            console.log("realizar peticion")
            const respuesta = await fetch(url, config)
            console.log("peticion realizada")
            const data = await respuesta.json();
            console.log(data)


            const {codigo, mensaje,detalle} = data;
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(detalle)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}
buscar();
formulario.addEventListener('submit', guardar )
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)