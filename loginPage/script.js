
document.getElementById('submit').addEventListener('click', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe automáticamente
    
    // Crear un objeto para almacenar las credenciales
    let credenciales = {
        username: document.getElementById('username').value,
        password: document.getElementById('password').value
    };
    
    // Aquí puedes añ   adir el código para enviar los datos a tu servidor
    

    comprobarCredenciales(credenciales);
});
function comprobarCredenciales(credenciales) {
    fetch('../src/controllers/loginController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(credenciales)
    })
    .then(response => {
        console.log('Response Status:', response.status);
        console.log('Response Headers:', response.headers);

        // Check if the response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.indexOf('application/json') !== -1) {
            return response.json();
        } else {
            throw new Error('La respuesta no es JSON. Tipo de contenido: ' + contentType);
        }
    })
    .then(data => {
        if (data.success) {
            console.log('Autenticado.', data);
            if (data.TipoUsuario_id == 1) {
                let url = `../adminPage/adminPanel.html?id=${data.idUsuario}&user=${encodeURIComponent(data.Nombre)}`;
                window.location.href = url;
            } else if (data.TipoUsuario_id == 2) {
               /* let url = `interfaz_mozo.html?id=${data.idUsuario}&user=${encodeURIComponent(data.Nombre)}`;
                window.location.href = url;*/
            } else if (data.TipoUsuario_id == 3) {
               /* window.location.href = 'interfaz_cocina.html';*/
            }
        } else {
            console.error('Clave o contraseña incorrecta', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error.message);
        // Aquí puedes manejar el error mostrando un mensaje al usuario
    });
}



/*
function comprobarCredenciales(credenciales) {
    fetch('../src/controllers/loginController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(credenciales)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la solicitud al servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log('Credenciales correctas.');
            console.log('Tipo de usuario:', data.TipoUsuario_id);
            if (data.TipoUsuario_id == 1) {
                window.location.href = 'interfaz_administrador.html';
            } else if (data.TipoUsuario_id == 2) {
                let url = `interfaz_mozo.html?id=${data.idUsuario}&user=${encodeURIComponent(data.Nombre)}`;
                window.location.href = url;
            } else if (data.TipoUsuario_id == 3) {
                window.location.href = 'interfaz_cocina.html';
            }
        } else {
            throw new Error(data.message || 'Error en la autenticación');
        }
    })
    .catch(error => {
        console.error('Error:', error.message);
        // Aquí puedes manejar el error mostrando un mensaje al usuario
    });
}
*/


