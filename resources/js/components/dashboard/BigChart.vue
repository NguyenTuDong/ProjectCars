<template>
  <canvas id="bigDashboardChart"></canvas>
</template>

<script>
export default {
  name: 'BigChart',
  props: {
    data: {
      required: true,
    }
  },
  watch: {
    data: function(newVal, oldVal){
      var months = newVal.map((data) => data.date);
      var counts = newVal.map((data) => data.count);
      $(document).ready(function() {
        var chartColor = "#FFFFFF";

        var ctx = document.getElementById('bigDashboardChart').getContext("2d");

        var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, chartColor);

        var gradientFill = ctx.createLinearGradient(0, 200, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, "rgba(255, 255, 255, 0.24)");

        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: months,
            datasets: [{
              label: "Mẫu tin",
              borderColor: chartColor,
              pointBorderColor: chartColor,
              pointBackgroundColor: "#1e3d60",
              pointHoverBackgroundColor: "#1e3d60",
              pointHoverBorderColor: chartColor,
              pointBorderWidth: 1,
              pointHoverRadius: 7,
              pointHoverBorderWidth: 2,
              pointRadius: 5,
              fill: true,
              backgroundColor: gradientFill,
              borderWidth: 2,
              data: counts
            }]
          },
          options: {
            layout: {
              padding: {
                left: 20,
                right: 20,
                top: 0,
                bottom: 0
              }
            },
            maintainAspectRatio: false,
            tooltips: {
              backgroundColor: '#fff',
              titleFontColor: '#333',
              bodyFontColor: '#666',
              bodySpacing: 4,
              xPadding: 12,
              mode: "nearest",
              intersect: 0,
              position: "nearest"
            },
            legend: {
              position: "bottom",
              fillStyle: "#FFF",
              display: false
            },
            scales: {
              yAxes: [{
                ticks: {
                  fontColor: "rgba(255,255,255,0.4)",
                  fontStyle: "bold",
                  beginAtZero: true,
                  maxTicksLimit: 5,
                  padding: 10
                },
                gridLines: {
                  drawTicks: true,
                  drawBorder: false,
                  display: true,
                  color: "rgba(255,255,255,0.1)",
                  zeroLineColor: "transparent"
                }

              }],
              xAxes: [{
                gridLines: {
                  zeroLineColor: "transparent",
                  display: false,

                },
                ticks: {
                  padding: 10,
                  fontColor: "rgba(255,255,255,0.4)",
                  fontStyle: "bold"
                }
              }]
            }
          }
        });
      })
    }
  },
}
</script>

<style>

</style>