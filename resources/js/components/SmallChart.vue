<template>
  <canvas :id="canvas"></canvas>
</template>

<script>
export default {
  name: 'SmallChart',
  props: {
    canvas: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      default: 'line',
    },
    label: {
      type: String,
      default: 'Data',
    },
    yAxes: {
      default: 1,
    },
    xAxes: {
      default: 1,
    },
    color: {
      default: '#f96332'
    },
    bgColor: {
      default: 'rgba(249, 99, 59, 0.40)'
    },
    chartColor: {
      default: '#ffffff'
    },
    pointRadius: {
      default: 4,
    },
    data: {
      required: true,
    },
  },
  data() {
    return {
      chart: {},
    }
  },
  created() {
      var self = this;
      $(document).ready(function() {

        var ctx = document.getElementById(self.canvas).getContext("2d");

        var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, self.chartColor);

        var gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, self.bgColor);

        self.chart = new Chart(ctx, {
          type: self.type,
          responsive: true,
          data: {
            labels: self.months,
            datasets: [{
              label: self.label,
              borderColor: self.color,
              pointBorderColor: "#FFF",
              pointBackgroundColor: self.color,
              pointBorderWidth: 2,
              pointHoverRadius: 4,
              pointHoverBorderWidth: 1,
              pointRadius: self.pointRadius,
              fill: true,
              backgroundColor: gradientFill,
              borderWidth: 2,
              data: self.counts,
            }]
          },
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false
            },
            tooltips: {
              bodySpacing: 4,
              mode: "nearest",
              intersect: 0,
              position: "nearest",
              xPadding: 10,
              yPadding: 10,
              caretPadding: 10
            },
            responsive: 1,
            scales: {
              yAxes: [{
                display: self.yAxes,
                gridLines: 0,
                ticks: {
                  display: true
                },
                gridLines: {
                  zeroLineColor: "transparent",
                  drawTicks: true,
                  display: true,
                  drawBorder: false
                }
              }],
              xAxes: [{
                display: self.xAxes,
                gridLines: 0,
                ticks: {
                  display: true
                },
                gridLines: {
                  zeroLineColor: "transparent",
                  drawTicks: true,
                  display: true,
                  drawBorder: false
                }
              }]
            },
            layout: {
              padding: {
                left: 0,
                right: 0,
                top: 15,
                bottom: 15
              }
            }
          }
        });
      })
  },
  watch: {
    data: function(newVal, oldVal){
      this.chart.data.labels = newVal.map((data) => data.date);
      this.chart.data.datasets[0].data = newVal.map((data) => data.count);
      this.chart.update();
    }
  },
  computed: {
    months() {
      return this.data.map((data) => data.date);
    },
    counts() {
      return this.data.map((data) => data.count);
    }
  }
}
</script>

<style>

</style>