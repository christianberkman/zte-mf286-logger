let realtimeChart;

function drawRealtime(){
    const data = {
        labels: new Array(120),
        datasets: [
            {
                label: 'Download',
                data: new Array(120),
                fill: true,
                backgroundColor: 'rgb(214, 234, 248)',
                borderColor: 'rgb(133, 193, 233)',
                tension: 0.1,
		        pointRadius: 0
            },
            {
                label: 'Upload',
                data: new Array(120),
                fill: true,
                backgroundColor: 'rgb(214, 248, 234)',
                borderColor: 'rgb(133, 233, 193)',
                tension: 0.1,
		        pointRadius: 0
            }
        ]
    }   
    
    const config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                x: { display: false },
                y: { 
                    title: { display: true, text: 'MiB/s' },
                    min: 0
                }
            }
        }
      };

      realtimeChart = new Chart(
        document.getElementById('realtime'),
        config
      );
}

function updateRealtime(){
    $.getJSON('realtimeJson.php').then( (jsonData) => {
        if(jsonData.realtime.rx_mib == 0){
            // Report rx and tx in KiB/s
            $('#down').html(jsonData.realtime.rx_kib + ' KiB/s')
            $('#up').html(jsonData.realtime.tx_kib + ' KiB/s')
        } else{
            // Report rx and tx in MiB/s
            $('#down').html(jsonData.realtime.rx_mib + ' MiB/s')
            $('#up').html(jsonData.realtime.tx_mib + ' MiB/s')
        }

        // Realtime data usage
        $('#realtimeDown').html(jsonData.usage.rx.GiB)
        $('#realtimeUp').html(jsonData.usage.tx.GiB)
        $('#realtimeTotal').html(jsonData.usage.total.GiB)

        // Shift and push labels and data arrays
        realtimeChart.config.data.datasets[0].data.shift()
        realtimeChart.config.data.datasets[1].data.shift()
        realtimeChart.config.data.labels.shift()            
        realtimeChart.config.data.datasets[0].data.push(jsonData.realtime.rx_mib)
        realtimeChart.config.data.datasets[1].data.push(jsonData.realtime.tx_mib)
        realtimeChart.config.data.labels.push('')

        // Update Chart
        realtimeChart.update()
    }).catch( (e) => console.log(e) )
}