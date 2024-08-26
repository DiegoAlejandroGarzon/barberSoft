(function () {
    "use strict";

    console.log(chartData);
    if ($("#report-pie-chart").length) {
        const chartColors = () => [
            getColor("primary", 0.9), // Color para "Entradas registradas"
            getColor("pending", 0.9), // Color para "Entradas Disponibles"
        ];

        const ctx = $("#report-pie-chart")[0].getContext("2d");
        const reportPieChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: [
                    "Entradas registradas",
                    "Entradas Disponibles"
                ],
                datasets: [
                    {
                        data: [chartData.soldTickets, chartData.availableTickets],
                        backgroundColor: chartColors,
                        hoverBackgroundColor: chartColors,
                        borderWidth: 5,
                        borderColor: () =>
                            $("html").hasClass("dark")
                                ? getColor("darkmode.700")
                                : getColor("white"),
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });

        helper.watchClassNameChanges($("html")[0], (currentClassName) => {
            reportPieChart.update();
        });
    }
})();
