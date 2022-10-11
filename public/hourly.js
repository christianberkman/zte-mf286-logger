async function draw(){
    let date;
    let searchParams = new URLSearchParams(window.location.search)
    if(searchParams.has('date')){
        date = searchParams.get('date')
    } else{
        let yourDate = new Date()
        date = yourDate.toISOString().split('T')[0]
    }

    const dataTotal = await $.getJSON('makeJson.php?file=hourly&column=delta&date=' + date);
    
    const data = {
        datasets: [
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
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'hour',
                        stepSize: 1
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Delta (MiB)'
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