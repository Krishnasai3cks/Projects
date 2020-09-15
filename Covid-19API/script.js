$(document).ready(function() {
    let country = window.prompt("Please Enter your country", "india");
    weatherFunction(country);
});

function weatherFunction(country) {
    let api = `https://coronavirus-19-api.herokuapp.com/countries/${country.toLowerCase()}`;
    $.get(api, function(res) {
        let {
            active,
            cases,
            casesPerOneMillion,
            country,
            critical,
            deaths,
            deathsPerOneMillion,
            recovered,
            testsPerOneMillion,
            todayCases,
            todayDeaths,
            totalTests,
        } = res;
        $("#total-cases").html(`${cases}`);
        $("#country").html(`${country}`);
        var details = `${active},${cases},${casesPerOneMillion},${critical},${deathsPerOneMillion},${recovered},${deaths},${testsPerOneMillion},${todayCases},${todayDeaths},${totalTests}`.split(
            ","
        );
        var ids = "active,totalcases,casesPerMillion,critical,deathsPerMillion,recovered,deaths,testsPerMillion,todayCases,todayDeaths,totalTests".split(
            ","
        );
        var colorArray = [
            "#FF6633",
            "#ff4444",
            "#FFB399",
            "#FF3355",
            "#FF3300",
            "#33FF33",
            "#6680B3",
            "#66991A",
            "#FF80CC",
            "#ff4444",
            "#66664D",
        ];
        for (var i in details) {
            var a = document.createElement("div");
            a.setAttribute("id", `details${i}`);
            // a.setAttribute("class", "div");
            a.innerHTML = `${ids[i].toUpperCase()} - ${details[i]}`;
            $(a).addClass("div");
            $(a).css({ "background-color": colorArray[i] });
            $("#details-div").append(a);
        }
    });
}