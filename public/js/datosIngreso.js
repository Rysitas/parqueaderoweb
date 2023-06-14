console.log("El archivo datosingreso.js se ha cargado correctamente - se usa para validaciones en ingresos");

function validarPlaca(placa) {
  const regex = /^[a-zA-Z]{3}\d{2}[a-zA-Z0-9]{0,2}$/;
  return regex.test(placa);
}

document.getElementById('placa').addEventListener('input', function(event) {
    var placa = event.target.value.toUpperCase().replace(/[^a-zA-Z0-9]/g, '');
    if (!validarPlaca(placa)) {
        event.target.setCustomValidity('La placa debe tener el formato AAA11A o AAA111.');
    } else {
        event.target.setCustomValidity('');
    }
});


function actualizarTipoVehiculo() {
    var placa = document.getElementById('placa').value;
    var ultimoDigito = placa.charAt(5);
  
    if (isNaN(ultimoDigito)) {
      document.getElementById('tipo_vehiculo').value = 'Motocicleta';
    } else {
      document.getElementById('tipo_vehiculo').value = 'Carro';
    }
}

document.addEventListener('keydown', function(event) {
    if (event.code === 'F2') {
        event.preventDefault();
        document.getElementById('guardar-btn').click();
    }
});

window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('placa').focus();
    document.getElementById('placa').setSelectionRange(0, 0);
});