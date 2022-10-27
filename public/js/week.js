let weekChart;

function drawWeek(jsonData){
    const data = {
        datasets: [
            {
                label: 'Daily (GiB)',
                data: jsonData,
                fill: true,
                backgroundColor: 'rgb(214, 234, 248)',
                borderColor: 'rgb(133, 193, 233)',
                tension: 0.1,
		        pointRadius: 0,
                pointHitRadius: 16
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
                            //hour: 'HH:mm'
                        },
                        unit: 'day',
                        //stepSize: 4
                    },
                },
                y: { title: { display: true, text: 'GiB' } }
            }
        }
      };

      weekChart = new Chart(
        document.getElementById('week'),
        config
      );
}


