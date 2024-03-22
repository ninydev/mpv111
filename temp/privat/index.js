fetch('https://api.privatbank.ua/p24api/exchange_rates?date=01.12.2014')
    .then(res => res.json())
    .then(exchange_rates => {
        console.log(exchange_rates)
    })
    .catch(err => {
        console.error(err)
    })