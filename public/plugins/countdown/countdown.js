var bnNumbers = {
    '0': '০',
    '1': '১',
    '2': '২',
    '3': '৩',
    '4': '৪',
    '5': '৫',
    '6': '৬',
    '7': '৭',
    '8': '৮',
    '9': '৯'
};

String.prototype.getBnDigit = function () {
    var str = this;
    for (var x in bnNumbers) {
        str = str.replace(new RegExp(x, 'g'), bnNumbers[x]);
    }
    return str;
};

var enNumber = "1234";

console.log(enNumber.getBnDigit());

function startCountdown(targetElementId, date_time) {
    if (date_time.replace(/\s/g, "") !== '') {
        countDownDate = new Date(date_time).getTime();
    } else {
        countDownDate = new Date("2000-01-01 00:00:00").getTime(); // Default to 2000-01-01 00:00:00
    }

    var x = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (document.getElementById("session_language").innerText=='bn')
        {
            document.getElementById(targetElementId + "-day").innerHTML = days.toString().getBnDigit();
            document.getElementById(targetElementId + "-hour").innerHTML = hours.toString().getBnDigit();
            document.getElementById(targetElementId + "-minute").innerHTML = minutes.toString().getBnDigit();
            document.getElementById(targetElementId + "-second").innerHTML = seconds.toString().getBnDigit();
        }
        else {
            document.getElementById(targetElementId + "-day").innerHTML = days.toString();
            document.getElementById(targetElementId + "-hour").innerHTML = hours.toString();
            document.getElementById(targetElementId + "-minute").innerHTML = minutes.toString();
            document.getElementById(targetElementId + "-second").innerHTML = seconds.toString();
        }


        if (distance < 0) {
            clearInterval(x);
            document.getElementById(targetElementId + "-day").innerHTML = '0';
            document.getElementById(targetElementId + "-hour").innerHTML = '0';
            document.getElementById(targetElementId + "-minute").innerHTML = '0';
            document.getElementById(targetElementId + "-second").innerHTML = '0';
        }
    }, 1000);
}

