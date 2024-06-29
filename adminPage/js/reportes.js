let chart1 = [];

let globalData;

/*
// Función para obtener los datos de la vista
function fetchData(url) {
    return fetch(url)
        .then(response => response.json())
        .catch(error => {
            console.error('Error al obtener los datos:', error);
        });
}*/

// Función para procesar y mostrar los datos en la consola


// Función para crear un gráfico de barras
function createBarChart(ctx, labels, data) {
    return new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad',
                data: data,
                backgroundColor: [
                    'rgba(255, 182, 193, 0.6)', // Rosa suave
                    'rgba(152, 251, 152, 0.6)', // Verde menta
                    'rgba(230, 230, 250, 0.6)', // Lavanda
                    'rgba(255, 255, 204, 0.6)', // Amarillo pálido
                    'rgba(173, 216, 230, 0.6)', // Azul cielo
                    'rgba(255, 218, 185, 0.6)', // Melocotón
                    'rgba(175, 238, 238, 0.6)', // Turquesa claro
                    'rgba(211, 211, 211, 0.6)', // Gris suave
                    'rgba(240, 128, 128, 0.6)', // Coral claro
                    'rgba(247, 231, 206, 0.6)'  // Champán
                ],
                borderColor: [
                    'rgba(255, 182, 193, 1)',
                    'rgba(152, 251, 152, 1)',
                    'rgba(230, 230, 250, 1)',
                    'rgba(255, 255, 204, 1)',
                    'rgba(173, 216, 230, 1)',
                    'rgba(255, 218, 185, 1)',
                    'rgba(175, 238, 238, 1)',
                    'rgba(211, 211, 211, 1)',
                    'rgba(240, 128, 128, 1)',
                    'rgba(247, 231, 206, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            events: [],

            //tooltips: {enabled: false},
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              xAxes: [{
                animation: false,
                ticks: {
                  beginAtZero: true,
                  
                 
                  stepSize: 1,
                  

                }
              }],
              yAxes: [{
                stacked: true,
                animation: false,
                barPercentage: 1,
              }],
            },          
        }
    });
}


/*
document.addEventListener('DOMContentLoaded', function() {
    const url = '../src/controllers/vistas.php?';

    fetchData(url).then(data => {
        console.log(data)
       
        
        // Filtrar los primeros 10 productos
        const productosVendidos = data.precioTotal_productos.slice(0, 10);
        const labels1 = productosVendidos.map(item => item.nombre);
        const chartData1 = productosVendidos.map(item => item.cantidad);    
        const ctx1 = document.getElementById('chart1').getContext('2d');
        chart1.append = createBarChart(ctx1, labels1, chartData1);

        const agregado_vendido = data.agregado_vendido.slice(0, 10);
        const labels2 = agregado_vendido.map(item => item.nombre);
        const chartData2 = agregado_vendido.map(item => item.cantidad);    
        const ctx2 = document.getElementById('chart2').getContext('2d');
        chart1.append = createBarChart(ctx2, labels2, chartData2);

        const bebida_vendido = data.bebida_vendida.slice(0, 10);
        const labels3 = bebida_vendido.map(item => item.nombre);
        const chartData3 = bebida_vendido.map(item => item.cantidad);    
        const ctx3 = document.getElementById('chart3').getContext('2d');
        chart1.append = createBarChart(ctx3, labels3, chartData3);

        const cant_tipoPedido = data.cant_tipoPedido.slice(0, 10);
        const labels4 = cant_tipoPedido.map(item => item.Tipo_pedido);
        const chartData4 = cant_tipoPedido.map(item => item.Cantidad);    
        const ctx4 = document.getElementById('chart4').getContext('2d');
        chart1.append = createBarChart(ctx4, labels4, chartData4);

        const hamburguesas_vendidas = data.hamburguesas_vendidas.slice(0, 10);
        const labels5 = hamburguesas_vendidas.map(item => item.nombre);
        const chartData5 = hamburguesas_vendidas.map(item => item.cantidad);    
        const ctx5 = document.getElementById('chart5').getContext('2d');
        chart1.append = createBarChart(ctx5, labels5, chartData5);

        
        
        const mesa_pedidos = data.mesa_pedidos.slice(0, 10);
        const labels6 = mesa_pedidos.map(item => item.NumMesa);
        const chartData6 = mesa_pedidos.map(item => item.CantidadPedidos);    
        const ctx6 = document.getElementById('chart6').getContext('2d');
        chart1.append = createBarChart(ctx6, labels6, chartData6);


        const plato_vendido = data.plato_vendido.slice(0, 10);
        const labels7 = plato_vendido.map(item => item.nombre);
        const chartData7 = plato_vendido.map(item => item.cantidad);    
        const ctx7 = document.getElementById('chart7').getContext('2d');
        chart1.append = createBarChart(ctx7, labels7, chartData7);
        

        const Totalpedidos_porFecha = data.Totalpedidos_porFecha.slice(0, 10);
        const labels8 = Totalpedidos_porFecha.map(item => item.Fecha);
        const chartData8 = Totalpedidos_porFecha.map(item => item.Cantidad);    
        const ctx8 = document.getElementById('chart8').getContext('2d');
        chart1.append = createBarChart(ctx8, labels8, chartData8);
        








    });
});*/

document.addEventListener('DOMContentLoaded', function() {
    const url = '../src/controllers/vistas.php?';

    fetchDataAndCreateCharts(url, 'desc');
    

    let buttons = document.querySelectorAll(".box");

    // Agregar un evento click a cada botón
    buttons.forEach(function(button) {
        button.addEventListener("click", handleButtonClick);
    });

});

function handleButtonClick(event) {
    var id = event.target.id; // Obtener el ID del botón clickeado

    // Lógica basada en el ID del botón
    switch (id) {
        case "1b":
            mostrarGrafico(1,id);
            console.log("Mostrar productos");
            break;
        case "2b":
            mostrarGrafico(6,id);
            console.log("Mostrar mesas");
            break;
        case "3b":
            mostrarGrafico(4,id);
            console.log("Mostrar tipo de pedido");
            break;
        case "4b":
            mostrarGrafico(9,id);
            console.log("Mostrar ventas por día");
            break;
        case "5b":
            mostrarGrafico(8,id);
            console.log("Mostrar ventas por fecha");
            break;
        case "6b":
            mostrarGrafico(5,id);
            console.log("Mostrar hamburguesas");
            break;
        case "7b":
            mostrarGrafico(7,id);
            console.log("Mostrar platos");
            break;
        case "8b":
            mostrarGrafico(3,id);
            console.log("Mostrar bebidas");
            break;
        default:
            console.log("Botón no reconocido");
            break;
    }
}


function mostrarGrafico(id,bid) {
    const buttons = document.getElementsByClassName('box');
    
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].style.backgroundColor = '#e6f0ef';
    }

    const graficos = document.getElementsByClassName('grafcontainer');

    for (let i = 0; i < buttons.length; i++) {
        graficos[i].style.display = 'none';
    }

    const btnselected = document.getElementById(bid);

    btnselected.style.backgroundColor = '#ffffff';                             
    const grafico = document.getElementById(id);
    if (grafico) {
        grafico.style.display = 'block';
    }
}



document.getElementById('order-select1').addEventListener('change', function() {
    let order = this.value;
    let numElements = document.getElementById('num-elements1').value;
    createChart(globalData.precioTotal_productos, 'chart1', 'nombre', 'cantidad', order, numElements);

});

document.getElementById('num-elements1').addEventListener('change', function() {
    let numElements = this.value;
    let order = document.getElementById('order-select1').value;
    //let newNum = document.getElementById('num-elements-value');
    //newNum.textContent = numElements;

    createChart(globalData.precioTotal_productos, 'chart1', 'nombre', 'cantidad', order, numElements);

   
});

document.getElementById('order-select2').addEventListener('change', function() {
    let order = this.value;
    let numElements = document.getElementById('num-elements2').value;
    createChart(globalData.agregado_vendido, 'chart2', 'nombre', 'cantidad', order, numElements);

});

document.getElementById('num-elements2').addEventListener('change', function() {
    let numElements = this.value;
    let order = document.getElementById('order-select2').value;
    //let newNum = document.getElementById('num-elements-value');
    //newNum.textContent = numElements;

    createChart(globalData.agregado_vendido, 'chart2', 'nombre', 'cantidad', order, numElements);

   
});

document.getElementById('order-select3').addEventListener('change', function() {
    let order = this.value;
    let numElements = document.getElementById('num-elements3').value;
    createChart(globalData.bebida_vendida, 'chart3', 'nombre', 'cantidad', order, numElements);

});

document.getElementById('num-elements3').addEventListener('change', function() {
    let numElements = this.value;
    let order = document.getElementById('order-select3').value;
    //let newNum = document.getElementById('num-elements-value');
    //newNum.textContent = numElements;

    createChart(globalData.bebida_vendida, 'chart3', 'nombre', 'cantidad', order, numElements);

   
});




document.getElementById('order-select5').addEventListener('change', function() {
    let order = this.value;
    let numElements = document.getElementById('num-elements5').value;
    createChart(globalData.hamburguesas_vendidas, 'chart5', 'nombre', 'cantidad', order, numElements);

});

document.getElementById('num-elements5').addEventListener('change', function() {
    let numElements = this.value;
    let order = document.getElementById('order-select5').value;
    //let newNum = document.getElementById('num-elements-value');
    //newNum.textContent = numElements;

    createChart(globalData.hamburguesas_vendidas, 'chart5', 'nombre', 'cantidad', order, numElements);

   
});


document.getElementById('order-select6').addEventListener('change', function() {
    let order = this.value;
    let numElements = document.getElementById('num-elements6').value;
    createChart(globalData.mesa_pedidos, 'chart6', 'NumMesa', 'CantidadPedidos', order, numElements);

});

document.getElementById('num-elements6').addEventListener('change', function() {
    let numElements = this.value;
    let order = document.getElementById('order-select6').value;
    //let newNum = document.getElementById('num-elements-value');
    //newNum.textContent = numElements;

    createChart(globalData.mesa_pedidos, 'chart6', 'NumMesa', 'CantidadPedidos', order, numElements);

   
});

document.getElementById('order-select7').addEventListener('change', function() {
    let order = this.value;
    let numElements = document.getElementById('num-elements7').value;
    createChart(globalData.plato_vendido, 'chart7', 'nombre', 'cantidad', order, numElements);

});

document.getElementById('num-elements7').addEventListener('change', function() {
    let numElements = this.value;
    let order = document.getElementById('order-select7').value;
    //let newNum = document.getElementById('num-elements-value');
    //newNum.textContent = numElements;

    createChart(globalData.plato_vendido, 'chart7', 'nombre', 'cantidad', order, numElements);

   
});


document.getElementById('num-elements8').addEventListener('change', function() {
    let numElements = this.value;
    //let newNum = document.getElementById('num-elements-value');
    //newNum.textContent = numElements;

    createChart(globalData.Totalpedidos_porFecha, 'chart8', 'Fecha', 'Cantidad','asc' , numElements);

   
});



function fetchDataAndCreateCharts(url, order) {
    fetchData(url).then(data => {
        console.log(data);
        globalData = data; // Almacenar data globalmente
        
        createChart(globalData.precioTotal_productos, 'chart1', 'nombre', 'cantidad', order, 10);
        createChart(globalData.agregado_vendido, 'chart2', 'nombre', 'cantidad', order, 10);
        createChart(globalData.bebida_vendida, 'chart3', 'nombre', 'cantidad', order, 10);
        createChart(globalData.cant_tipoPedido, 'chart4', 'Tipo_pedido', 'Cantidad', order, 10);
        createChart(globalData.hamburguesas_vendidas, 'chart5', 'nombre', 'cantidad', order, 10);
        createChart(globalData.mesa_pedidos, 'chart6', 'NumMesa', 'CantidadPedidos', order, 10);
        createChart(globalData.plato_vendido, 'chart7', 'nombre', 'cantidad', order, 10);
        createChart(globalData.Totalpedidos_porFecha, 'chart8', 'Fecha', 'Cantidad', order, 10);
        createChart(globalData.Totalpedidos_porDiaSemana, 'chart9', 'DiaSemana', 'Cantidad', order, 7);

        loader = document.getElementById("loader");
        mostrarGrafico(1,'1b');
        loader.style.display = 'none';



    });
}



function createChart(data, chartId, labelKey, dataKey, order, n) {
    dataOrdered = data.slice();
    if (order === 'asc') {
        console.log(dataOrdered);
        dataOrdered.reverse();
        console.log(dataOrdered);
    }
    console.log(order);
    const sortedData = dataOrdered.slice(0, n);
    
    const labels = sortedData.map(item => item[labelKey]);
    const chartData = sortedData.map(item => item[dataKey]);
    const ctx = document.getElementById(chartId).getContext('2d');
    
    createBarChart(ctx, labels, chartData);
}

function fetchData(url) {
    return fetch(url)
        .then(response => response.json());
}


// Función para ajustar el padding y redimensionar el gráfico
function adjustPaddingAndResize() {
    const containers = document.getElementsByClassName('grafcontainer');
    
    // Verificar si hay al menos un elemento con la clase 'grafcontainer'
    if (containers.length > 0) {
        let paddingFactor = 9.5; // Default padding-bottom factor (9.5%)
        if (window.innerWidth < 550) {
            paddingFactor = 12.0;
            
        }

        if (window.innerWidth < 450) {
            paddingFactor = 16.0;
            
        }

        if (window.innerWidth < 400) {
            paddingFactor = 18.0;
            
        }
        

        const windowWidth = window.innerWidth;
        const paddingBottom = paddingFactor + 4000 / windowWidth;

        // Iterar sobre cada elemento con la clase 'grafcontainer'
        for (let i = 0; i < containers.length; i++) {
            const container = containers[i];
            container.style.paddingBottom = `${paddingBottom}%`;

            // Aquí deberías tener algún tipo de lógica para redimensionar tu gráfico
            // myChart.resize(); por cada contenedor si es necesario
        }
    } else {
        console.error('No se encontraron elementos con la clase "grafcontainer".');
    }
}

// Agregar evento 'resize' con una función anónima
window.addEventListener('resize', function() {
    // Verificar el ancho de la pantalla antes de ejecutar adjustPaddingAndResize()
    if (window.innerWidth < 1800) {
        adjustPaddingAndResize();
    }
});

// Ejecutar adjustPaddingAndResize() inicialmente si el ancho de la pantalla es menor a 1800px
if (window.innerWidth < 1800) {
    adjustPaddingAndResize();
}


