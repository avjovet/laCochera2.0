const urlParams = new URLSearchParams(window.location.search);

const m = urlParams.get('m');
if (m !== null) {
    // Aquí puedes utilizar el valor de 'mesa'
    console.log('holaa',m);
} else {
    // El parámetro 'mesa' no está presente en la URL
    console.log('El parámetro mesa no está presente en la URL');
}
