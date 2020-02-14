//Population chart
/*$(document).ready(function() {
    var config = {
        type: 'bar',
        data: {
            labels: ["Haryana", "Chhattisgarh", "Odisha", "Rajasthan", "Punjab", "Gujarat", "Jharkhand", "Maharashtra"],
            datasets: [{
                    label: "Limit",
                    data: [100, 130, 217, 150, 200, 97, 160, 120, 230, 300, 310, 40, 10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 40],

                    fill: true,
                    borderColor: "rgba(49,172,170,0.9)",
                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],

                    //	   borderCapStyle: 'square',
                    //    pointBorderColor: "white",
                    //    pointBackgroundColor: "green",
                    //    pointBorderWidth: 1,
                    //    pointHoverRadius: 8,
                    //    pointHoverBackgroundColor: "yellow",
                    //    pointHoverBorderColor: "green",
                    //    pointHoverBorderWidth: 2,
                    fill: false,
                    pointRadius: 4,
                    pointHitRadius: 10,

                },
                {
                    type: 'line',
                    label: 'B',
                    // the 1st and last value are placeholders and never get displayed on the chart
                    // to get a straight line, the 1st and last values must match the same value as
                    // the next/prev respectively
                    data: [100, 130, 217, 150, 200, 97, 160, 120, 230, 300, 310, 40, 10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 40],
                    fill: false,
                    borderWidth: 3,
                    borderColor: "rgba(49,172,170,0.9)",
                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                    borderDash: [5, 4],
                    lineTension: 0,
                    //steppedLine: true
                }

            ]
        },

        options: {
            responsive: true,
            legend: {
                display: false,
                position: 'bottom',
            },

            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    },
                    scaleLabel: {
                        labelString: 'ton',
                        display: true,
                    },
                }]
            },

            title: {
                fontSize: 12,
                display: true,
                text: 'States',
                position: 'bottom'
            }
        },

    };

    var myChart;
    change('bar');
    $("#populationPanel #barChartBtn").click(function() {
        change('bar');
    });

    $("#populationPanel #pieChartBtn").click(function() {
        change('scatter');

        //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],

    });

    $("#populationPanel #lineChartBtn").click(function() {
        change('line');
    });

    function change(newType) {
        var ctx = document.getElementById("trainingChart").getContext("2d");

        // Remove the old chart and all its event handles
        if (myChart) {
            myChart.destroy();
        }

        // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
        var temp = jQuery.extend(true, {}, config);
        temp.type = newType;
        //temp.type = newType;
        myChart = new Chart(ctx, temp);
    };
});*/










/*$(document).ready(function() {
    var config = {
        type: 'bar',
        data: {
            labels: ["Haryana", "Chhattisgarh", "Odisha", "Rajasthan", "Punjab", "Gujarat", "Jharkhand", "Maharashtra"],
            datasets: [{
                    label: "Limit",
                    data: [100, 130, 217, 150, 200, 97, 160, 120, 230, 300, 310, 40, 10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 40],

                    fill: true,
                    borderColor: "rgba(49,172,170,0.9)",
                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],

                    //	   borderCapStyle: 'square',
                    //    pointBorderColor: "white",
                    //    pointBackgroundColor: "green",
                    //    pointBorderWidth: 1,
                    //    pointHoverRadius: 8,
                    //    pointHoverBackgroundColor: "yellow",
                    //    pointHoverBorderColor: "green",
                    //    pointHoverBorderWidth: 2,
                    fill: false,
                    pointRadius: 4,
                    pointHitRadius: 10,

                },
                {
                    type: 'line',
                    label: 'B',
                    // the 1st and last value are placeholders and never get displayed on the chart
                    // to get a straight line, the 1st and last values must match the same value as
                    // the next/prev respectively
                    data: [100, 130, 217, 150, 200, 97, 160, 120, 230, 300, 310, 40, 10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 40],
                    fill: false,
                    borderWidth: 3,
                    borderColor: "rgba(49,172,170,0.9)",
                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                    borderDash: [5, 4],
                    lineTension: 0,
                    //steppedLine: true
                }

            ]
        },

        options: {
            responsive: true,
            legend: {
                display: false,
                position: 'bottom',
            },

            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    },
                    scaleLabel: {
                        labelString: 'ton',
                        display: true,
                    },
                }]
            },

            title: {
                fontSize: 12,
                display: true,
                text: 'States',
                position: 'bottom'
            }
        },

    };

    var myChart;
    change('bar');
    $("#cetTrainings #barChartBtn").click(function() {
        change('bar');
    });

    $("#cetTrainings #pieChartBtn").click(function() {
        change('scatter');

        //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],

    });

    $("#cetTrainings #lineChartBtn").click(function() {
        change('line');
    });

    function change(newType) {
        var ctx = document.getElementById("cetTrainings").getContext("2d");

        // Remove the old chart and all its event handles
        if (myChart) {
            myChart.destroy();
        }

        // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
        var temp = jQuery.extend(true, {}, config);
        temp.type = newType;
        //temp.type = newType;
        myChart = new Chart(ctx, temp);
    };
});

*/










//School Collage
$(document).ready(function() {
    var config = {
        type: 'line',
        data: {
            labels: classroom_headings,
            datasets: [{
                label: "Limit",
                data: classroom_chartdata,

                fill: true,
                borderColor: "rgba(49,172,170,0.9)",
                backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677", "#0ec599", "#10adf4", "#faae1c", "#0ec599"],
                //	   borderCapStyle: 'square',
                //    pointBorderColor: "white",
                //    pointBackgroundColor: "green",
                //    pointBorderWidth: 1,
                //    pointHoverRadius: 8,
                //    pointHoverBackgroundColor: "yellow",
                //    pointHoverBorderColor: "green",
                //    pointHoverBorderWidth: 2,
                fill: false,
                pointRadius: 4,
                pointHitRadius: 10,
            }, ]
        },

        options: {
            responsive: true,
            legend: {
                display: false,
                // position: 'bottom',
            },

            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    },
                    scaleLabel: {
                        labelString: 'beginner',
                        display: false,
                    },
                }]
            },
            title: {
                fontSize: 12,
                display: true,
                text: 'Courses',
                position: 'bottom'
            }
        },

    };

    var myChart;
    change('line');
    $("#schoolCollagePanel #barChartBtn").click(function() {
        change('bar');
    });

    $("#schoolCollagePanel #pieChartBtn").click(function() {
        change('polarArea');
        //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],

    });

    $("#schoolCollagePanel #lineChartBtn").click(function() {
        change('line');
    });

    function change(newType) {
        var ctx = document.getElementById("webinarsChart").getContext("2d");

        // Remove the old chart and all its event handles
        if (myChart) {
            myChart.destroy();
        }

        // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
        var temp = jQuery.extend(true, {}, config);
        temp.type = newType;
        //temp.type = newType;
        myChart = new Chart(ctx, temp);
    };

});


//Constituency Details
$(document).ready(function() {
    var config = {
        type: 'bar',
        data: {
            labels: trending_headings,
            datasets: [{
                label: "limit",
                data: trending_chartdata,

                fill: true,
                borderColor: "rgba(49,172,170,0.9)",
                backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677", "#0ec599", "#10adf4", "#faae1c", "#0ec599"],
                //	   borderCapStyle: 'square',
                //    pointBorderColor: "white",
                //    pointBackgroundColor: "green",
                //    pointBorderWidth: 1,
                //    pointHoverRadius: 8,
                //    pointHoverBackgroundColor: "yellow",
                //    pointHoverBorderColor: "green",
                //    pointHoverBorderWidth: 2,
                fill: false,
                pointRadius: 4,
                pointHitRadius: 10,
            }, ]
        },

        options: {
            responsive: true,
            legend: {
                display: false,
                // position: 'bottom',
            },

            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    },
                    scaleLabel: {
                        labelString: 'Intermediate',
                        display: false,
                    },
                }]
            },
            title: {
                fontSize: 12,
                display: true,
                text: 'Category',
                position: 'bottom'
            }
        },

    };

    var myChart;
    change('bar');
    $("#constituencyPanel #barChartBtn").click(function() {
        change('bar');
    });

    $("#constituencyPanel #pieChartBtn").click(function() {
        change('polarArea');
        //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],

    });

    $("#constituencyPanel #lineChartBtn").click(function() {
        change('line');
    });

    function change(newType) {
        var ctx = document.getElementById("constituencyDetailsChart").getContext("2d");

        // Remove the old chart and all its event handles
        if (myChart) {
            myChart.destroy();
        }

        // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
        var temp = jQuery.extend(true, {}, config);
        temp.type = newType;
        //temp.type = newType;
        myChart = new Chart(ctx, temp);
    };

});