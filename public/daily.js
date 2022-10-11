async function draw(){
    const dataRx = await $.getJSON('makeJson.php?file=daily&column=rx');
    const dataTx = await $.getJSON('makeJson.php?file=daily&column=tx');
    const dataTotal = await $.getJSON('makeJson.php?file=daily&column=total');
    
    const data = {
        datasets: [
            /*{
                label: 'Transferred',
                data: dataTx,
                fill: true,
                backgroundColor: 'rgb(232, 248, 245)',
                borderColor: 'rgb(163, 228, 215)',
                tension: 0.1
            },

            {
                label: 'Received',
                data: dataRx,
                fill: true,
                backgroundColor: 'rgb(254, 249, 231)',
                borderColor: 'rgb(249, 231, 159)',
                tension: 0.1
            },*/

            {
                label: 'Total',
                data: dataTotal,
                fill: true,
                backgroundColor: 'rgb(214, 234, 248)',
                borderColor: 'rgb(133, 193, 233)',
                tension: 0.1
            },
        ]
      };

      const config = {
        type: 'line',
        data: data,
        options: {
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        stepSize: 1
                    }
                }
            }
        }
      };
    
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
        
}

draw();