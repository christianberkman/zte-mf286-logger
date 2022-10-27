function drawDaily(jsonData){
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

      const myChart = new Chart(
        document.getElementById('daily'),
        config
      );
}



async function draw(){
    
    $('#date').html(date);

    const dataTotal = await $.getJSON('makeJson.php?file=hourly&column=delta&date=' + date);
    
    const data = {
        datasets: [
            {
                label: 'Delta (MiB)',
                //data: dataTotal,
                fill: true,
                backgroundColor: 'rgb(214, 234, 248)',
                borderColor: 'rgb(133, 193, 233)',
                tension: 0.1,
		        pointRadius: 0
            }
        ]
      };

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
                }
            }
        }
      };

      const myChart = new Chart(
        document.getElementById('hourlyDelta'),
        config
      );
        
}
