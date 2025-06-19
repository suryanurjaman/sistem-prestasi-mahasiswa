export function renderPrestasiChart(chartId, chartData) {
    if (!document.getElementById(chartId) || typeof ApexCharts === 'undefined') {
        return;
    }
    const options = {
        series: chartData.series,
        chart: { type: "bar", height: 250, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: false, columnWidth: "60%", borderRadius: 6 } },
        dataLabels: { enabled: false },
        xaxis: { categories: chartData.categories, labels: { style: { fontFamily: "Inter, sans-serif" } } },
        yaxis: { labels: { formatter: v => v, style: { fontFamily: "Inter, sans-serif" } } },
        tooltip: { y: { formatter: v => v } },
        legend: { position: "bottom" },
        colors: chartData.series.map(s => s.color),
        grid: { strokeDashArray: 4, padding: { left: 0, right: 0, top: -10 } },
    };
    new ApexCharts(document.getElementById(chartId), options).render();
}
