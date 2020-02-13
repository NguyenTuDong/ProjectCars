<template>
  <div class="card card-chart">
    <div class="card-header">
      <h5 class="card-category">{{category}}</h5>
      <h4 class="card-title">{{title}}</h4>
      <div class="dropdown">
        <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
          <i class="now-ui-icons loader_gear"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
          <a class="dropdown-item text-danger" href="#">Remove Data</a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="chart-area">
        <canvas :id="canvas"></canvas>
      </div>
    </div>
    <div class="card-footer">
      <div class="stats">
        <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SmallChart',
  props: {
    canvas: {
      type: String,
      required: true,
    },
    category: {
      type: String,
      default: '',
    },
    title: {
      default: '',
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
    data: {
      required: true,
    },
  },
  watch: {
    data: function(newVal, oldVal){
      var self = this;
      var months = newVal.map((data) => data.date);
      var counts = newVal.map((data) => data.count);
      $(document).ready(function() {

        var ctx = document.getElementById(self.canvas).getContext("2d");

        var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, self.chartColor);

        var gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, self.bgColor);

        var myChart = new Chart(ctx, {
          type: self.type,
          responsive: true,
          data: {
            labels: months,
            datasets: [{
              label: self.label,
              borderColor: self.color,
              pointBorderColor: "#FFF",
              pointBackgroundColor: self.color,
              pointBorderWidth: 2,
              pointHoverRadius: 4,
              pointHoverBorderWidth: 1,
              pointRadius: 4,
              fill: true,
              backgroundColor: gradientFill,
              borderWidth: 2,
              data: counts
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
    }
  },
}
</script>

<style>

</style>