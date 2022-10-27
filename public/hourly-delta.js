let hourlyChart

function drawHourlyDelta(date, jsonData){
    
    const data = {
        datasets: [
            {
                label: 'Delta (MiB)',
                data: jsonData,
                fill: true,
                backgroundColor: 'rgb(214, 234, 248)',
                borderColor: 'rgb(133, 193, 233)',
                tension: 0.1,
		        pointRadius: 0
            }
        ]
    }   
    
    const config = {
        type: 'line',
        data: data,
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        displayFormats: {
                            hour: 'HH:mm'
                        },
                        unit: 'hour',
                        stepSize: 4
                    },
		            min: date + ' 00:00',
		            max: date + ' 23:59'
                },
                y: { title: { display: true, text: 'MiB/hr' } }
            }
        }
      };

      hourlyChart = new Chart(
        document.getElementById('hourlyDelta'),
        config
      );
}

function updateHourlyDelta(date, jsonData){
    hourlyChart.config.data.datasets[0].data = null
    hourlyChart.update()
    hourlyChart.config.data.datasets[0].data = jsonData
    hourlyChart.config.options.scales.x.min = date + ' 00:00'
    hourlyChart.config.options.scales.x.max = date + ' 23:59'
    hourlyChart.update()
}