$(document).ready(function() {
    // datepicker to show Years only
    $("#datepicker").datepicker({
        format: " yyyy", // Notice the Extra space at the beginning
        viewMode: "years",
        minViewMode: "years"
    });

    // submit Months and Year from expenditure_chart_form for processing
    $("#expenditure_chart_form").submit(function(event) {
        // prevent the form from reloading the page
        event.preventDefault();

        // get values form the user
        var months = $("#months").val();
        var year = $("#datepicker").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/admin/expenditure-months",
            method: "POST",
            data: { months: months, year: year, _token: _token },
            success: function(data) {
                // remove the prevoius expenditure-chart
                $("#expenditure-chart").remove();
                // create a new expenditure-chart canvas and append to the parent element
                $("#graph-container").append(
                    '<canvas id="expenditure-chart" height="200"></canvas>'
                );
                // generate a new expenditure-chart using processed data
                generate_expenditure_chart(data.month_labels, data.amount_data);
            }
        });
    });
});

// function that generated expenditure-chart processed data
function generate_expenditure_chart(labels, data) {
    ("use strict");

    var ticksStyle = {
        fontColor: "#495057",
        fontStyle: "bold"
    };

    var mode = "index";
    var intersect = true;

    var $expenditureChart = $("#expenditure-chart");
    var expenditureChart = new Chart($expenditureChart, {
        type: "bar",
        data: {
            // MONTHS
            labels: labels,
            datasets: [
                {
                    backgroundColor: "#007bff",
                    borderColor: "#007bff",
                    // Expenditure amount This Year
                    data: data
                }
                // {
                //     backgroundColor: "#ced4da",
                //     borderColor: "#ced4da",
                //     // Expenditure amount Another Year
                //     data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
                // }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [
                    {
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: "4px",
                            color: "rgba(0, 0, 0, .2)",
                            zeroLineColor: "transparent"
                        },
                        ticks: $.extend(
                            {
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    if (value >= 1000) {
                                        value /= 1000;
                                        value += "k";
                                    }
                                    return "KSH." + value;
                                }
                            },
                            ticksStyle
                        )
                    }
                ],
                xAxes: [
                    {
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }
                ]
            }
        }
    });
}
