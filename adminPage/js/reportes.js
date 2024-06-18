var ctx1 = document.getElementById('chart1').getContext('2d');
console.log("test");
var chart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Etiqueta 1', 'Etiqueta 2', 'Etiqueta 3'],
        datasets: [{
            label: 'Dataset 1',
            data: [10, 20, 30],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});