$( function() { 
    // Current date
    let dateObj = new Date()
    let currentDate = dateObj.toISOString().split('T')[0]
    $('.logger-current-date').html(currentDate);

    // Realtime
    drawRealtime()
    updateRealtime()
    setInterval( () => {
        updateRealtime()
    }, 1000)

    // Daily
    $.getJSON('makeJson.php?file=daily').then( (jsonData) => {
        drawDaily(jsonData)
    })

    // Week
    $.getJSON('makeJson.php?file=daily&limit=7').then( (jsonData) => {
        drawWeek(jsonData);
    })

    // Hourly Dates
    let dates
    $.getJSON('hourlyDatesJson.php').then( (jsonDates) => {
        // Load last date available
        let lastDate = jsonDates.at(0)
        $.getJSON('makeJson.php?file=hourly&column=delta&date=' + lastDate).then( (jsonData) => {
            drawHourlyDelta(lastDate, jsonData)
        })

        // Populate Dropdown
        const dropdown = $('#hourlyDate')
        jsonDates.forEach(date => {
            dropdown.append("<option value='"+ date +"'>"+ date +"</option>")
        })
    })
    

    // Select date
    $('#hourlyDate').change( () => {
        const date = $('#hourlyDate option:selected').val()
        $.getJSON('makeJson.php?file=hourly&column=delta&date=' + date).then( (jsonData) => {
            updateHourlyDelta(date, jsonData)
        }).catch( (e) => { console.log(e) })
    })

});