const httpSrv = require("http")

const serverInstance = httpSrv.createServer(
    function (request, response) {
        response.end("Hello NodeJsApi")
    }
)

serverInstance.listen(3000, function (err)  {
    console.log("Server Start " + "http://localhost:3000")
})
