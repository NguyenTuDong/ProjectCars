<template>
  <div>
    <div class="panel-header panel-header-sm"></div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Báo cáo</h4>
              <a :href="'/admin/api/report/revenue/pdf?start='+start+'&end='+ end" target="_blank" class="btn btn-primary ml-auto" ><i class="fas fa-file-pdf mr-2"></i> Xuất PDF</a>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <ul class="nav nav-pills nav-pills-primary" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      data-toggle="tab"
                      href="#link1"
                      role="tablist"
                    >Tổng quan</a>
                  </li>
                </ul>
                <div id="reportrange" class="date-picker">
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
              </div>
              <div class="tab-content tab-space">
                <div class="tab-pane active" id="link1">
                  <div class="chart-report">
                    <small-chart
                      :canvas="'revenue'"
                      :label="'Doanh số'"
                      :color="'#18ce0f'"
                      :yAxes="true"
                      :xAxes="true"
                      :bgColor="'rgba(24, 206, 15, 0.4)'"
                      :pointRadius="0"
                      :data="revenueChart"
                    ></small-chart>
                  </div>
                  <h5 class="text-center my-5">Doanh thu hàng đầu của bạn trong giao đoạn này</h5>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th class="table-cars-img text-center">
                          Hình
                        </th>
                        <th class="table-cars-name">
                          Tên mẫu tin
                        </th>
                        <th class="table-cars-author">
                          Người đăng
                        </th>
                        <th class="table-cars-created-at">
                          Ngày đăng
                        </th>
                        <th class="table-cars-cost text-right">
                          Phí
                        </th>
                      </thead>
                      <tbody>
                        <tr v-for="record in revenueRecords" :key="record.id">
                          <td class="text-center">
                            <img :src="record.hinhanh_path" alt="">
                          </td>
                          <td>
                            <router-link :to="{ name: 'car-detail', params: { id: record.id }}">
                              <h6>{{record.ten}}</h6>
                            </router-link>
                            <div>
                              <h6>{{price(record.gia)}} VND</h6>
                            </div>
                            <div class="blocks">
                              <span title="Thương hiệu">{{record.types.brands.ten}}</span>
                              <span title="Dòng xe">{{record.types.ten}}</span>
                              <span title="Kiểu dáng">{{record.styles.ten}}</span>
                              <span title="Tình trạng">{{record.conditions.ten}}</span>
                              <span title="Nguồn gốc">{{record.origins.ten}}</span>
                              <span title="Nơi bán">{{record.locations.ten}}</span>
                            </div>
                          </td>
                          <td>
                            <router-link :to="{ name: 'user-detail', params: { id: record.users_id }}">
                              {{record.users.ten}}
                            </router-link>
                          </td>
                          <td>
                            {{record.created_at}}
                          </td>
                          <td>
                            {{price(record.phi)}} VND
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SmallChart from "../SmallChart";
import { mapGetters } from 'vuex';

export default {
  name: "Report",
  components: {
    SmallChart
  },
  data() {
    return {
      start: null,
      end: null,
    };
  },
  created() {
    var self = this;
    $(document).ready(function() {
      moment.locale('vi');
      var start = moment().subtract(6, 'days');
      var end = moment();

      function cb(start, end) {
          $('#reportrange span').html(start.format('DD MMMM, YYYY') + ' - ' + end.format('DD MMMM, YYYY'));
          self.start = start.format('YYYY/MM/DD');
          self.end = end.format('YYYY/MM/DD');
          var data = {
            start: self.start,
            end: self.end
          }
          self.$store.dispatch("getRevenueReport", data);
      }

      $('#reportrange').daterangepicker({
          startDate: start,
          endDate: end,
          opens: "left",
          ranges: {
            '7 ngày qua': [moment().subtract(6, 'days'), moment()],
            '28 ngày qua': [moment().subtract(27, 'days'), moment()],
            '90 ngày qua': [moment().subtract(89, 'days'), moment()],
            '365 ngày qua': [moment().subtract(364, 'days'), moment()],
            ['Năm ' + (moment().year())]: [moment().startOf('year'), moment()],
            ['Năm ' + (moment().subtract(1, 'year').year())]: [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            ['Tháng ' + (moment().month() + 1)]: [moment().startOf('month'), moment()],
            ['Tháng ' + (moment().subtract(1, 'month').month() + 1)]: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            ['Tháng ' + (moment().subtract(2, 'month').month() + 1)]: [moment().subtract(2, 'month').startOf('month'), moment().subtract(2, 'month').endOf('month')]
          },
          locale: {
            format: "DD/MM/YYYY",
            separator: " - ",
            applyLabel: "Áp dụng",
            cancelLabel: "Hủy",
            fromLabel: "Từ",
            toLabel: "Đến",
            customRangeLabel: "Tùy chỉnh",
            weekLabel: "T",
            daysOfWeek: [
                "CN",
                "T2",
                "T3",
                "T4",
                "T5",
                "T6",
                "T7"
            ],
            monthNames: [
                "Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12"
            ],
            firstDay: 1
          },
      }, cb);

      cb(start, end);
    })
  },
  computed: {
    ...mapGetters({
      revenueChart: 'revenueChart',
      revenueRecords: 'revenueRecords',
    }),
  },
  methods: {
    price(value) {
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  }
};
</script>

<style lang="scss">
.date-picker{
  cursor: pointer; 
  padding: 10px 20px; 
  border: 1px solid #ccc;
  width: 300px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.daterangepicker {
  font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
}
.daterangepicker .ranges li.active {
  background-color: #f96332;
}
.daterangepicker td.in-range {
  background-color: #f9643279;
}
.daterangepicker td.active, .daterangepicker td.active:hover {
  background-color: #f96332;
}
.chart-report{
  height: 300px;
}
</style>