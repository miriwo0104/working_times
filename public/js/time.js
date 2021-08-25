time();
function time() {
    var now = new Date();
    document.getElementById("time").innerHTML = now.toLocaleTimeString();
}
setInterval('time()', 1000);