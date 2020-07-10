<template>
  <div>
    <div class="panel-header panel-header-lg">
      <big-chart :data="carCostPerMonth"></big-chart>
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="statistics">
                    <div class="info">
                      <div class="icon text-warning">
                        <i class="now-ui-icons business_money-coins"></i>
                      </div>
                      <h3 class="info-title">
                        {{ money }}
                      </h3>
                      <h6 class="stats-title">Doanh thu</h6>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="statistics">
                    <div class="info">
                      <div class="icon text-success">
                        <i class="now-ui-icons files_paper"></i>
                      </div>
                      <h3 class="info-title">
                        {{ carCountApprove }} / {{ carCountAll }}
                      </h3>
                      <h6 class="stats-title">Mẫu tin</h6>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="statistics">
                    <div class="info">
                      <div class="icon text-primary">
                        <i class="now-ui-icons users_single-02"></i>
                      </div>
                      <h3 class="info-title">{{userCountAll}}</h3>
                      <h6 class="stats-title">Khách hàng</h6>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="statistics">
                    <div class="info">
                      <div class="icon text-info">
                        <i class="now-ui-icons ui-1_email-85"></i>
                      </div>
                      <h3 class="info-title">{{contactCountAll}}</h3>
                      <h6 class="stats-title">Liên hệ</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category">Số tin được đăng</h5>
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
                <small-chart
                  :canvas="'carApprovePerMonth'"
                  :label="'Online'"
                  :color="'#18ce0f'"
                  :yAxes="true"
                  :xAxes="false"
                  :bgColor="'rgba(24, 206, 15, 0.4)'"
                  :data="carApprovePerMonth"
                ></small-chart>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category">Số khách hàng</h5>
              <h4 class="card-title">{{userCount}}</h4>
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
                <small-chart
                  :canvas="'userPerMonth'"
                  :label="'Khách hàng'"
                  :color="'#f96332'"
                  :yAxes="false"
                  :xAxes="false"
                  :bgColor="'rgba(249, 99, 59, 0.4)'"
                  :data="userPerMonth"
                ></small-chart>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category">Số liên hệ</h5>
              <h4 class="card-title">{{contactCount}}</h4>
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
                <small-chart
                  :canvas="'contactPerMonth'"
                  :label="'Liên hệ'"
                  :color="'#2CA8FF'"
                  :yAxes="true"
                  :xAxes="false"
                  :bgColor="'rgba(44, 168, 255, 0.6)'"
                  :data="contactPerMonth"
                ></small-chart>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BigChart from "../BigChart";
import SmallChart from "../SmallChart";
import { mapGetters } from 'vuex';

export default {
  name: "Dashboard",
  components: {
    BigChart,
    SmallChart
  },
  created() {
    this.$store.dispatch("carCostPerMonth");

    this.$store.dispatch("carCount");
    this.$store.dispatch("carCountApprove");
    this.$store.dispatch("carCountCost");
    this.$store.dispatch("userCount");
    this.$store.dispatch("contactCount");

    this.$store.dispatch("carApprovePerMonth");

    this.$store.dispatch("userPerMonth");

    this.$store.dispatch("contactPerMonth");
  },
  computed: {
    ...mapGetters({
      carCountAll: 'carCount',
      carCountApprove: 'carCountApprove',
      carCountCost: 'carCountCost',
      carCostPerMonth: 'carCostPerMonth',
      carApprovePerMonth: 'carApprovePerMonth',
      userCountAll: 'userCount',
      userPerMonth: 'userPerMonth',
      contactCountAll: 'contactCount',
      contactPerMonth: 'contactPerMonth',
    }),
    userCount() {
      var count = 0;
      var data = this.$store.getters.userPerMonth;

      data.forEach(el => {
        count += el.count;
      });

      return count;
    },
    contactCount() {
      var count = 0;
      var data = this.$store.getters.contactPerMonth;

      data.forEach(el => {
        count += el.count;
      });

      return count;
    },
    money() {
      if(this.carCountCost === 'Đang tải...') return this.carCountCost;
      if(this.carCountCost > 1000000000){
        var money = Math.round(((this.carCountCost / 1000000000) + Number.EPSILON) * 100) / 100;
        return money.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' tỉ VND';
      }
      if(this.carCountCost > 1000000){
        var money = Math.round(((this.carCountCost / 1000000) + Number.EPSILON) * 100) / 100;
        return money.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' tr VND';
      }
      return this.carCountCost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VND';
    }
  }
};
</script>

<style>
.card-stats .statistics {
  position: relative;
  text-align: center;
  padding: 15px 0;
}
.card-stats .icon {
  display: inline-block;
  vertical-align: top;
  margin: 0 15px;
}
.info .info-title {
  margin: 15px 0 5px;
  padding: 0 15px;
  color: #2c2c2c;
  font-weight: 700;
}
.card-stats .statistics .stats-title {
  margin-bottom: 5px;
  color: #9a9a9a;
  font-weight: 400;
}
.card-stats [class*="col-"]:not(:last-child) .statistics:after {
  position: absolute;
  right: -15px;
  top: 20px;
  width: 1px;
  height: calc(100% - 40px);
  content: "";
  background: #ddd;
}
.info .icon > i {
  font-size: 2.3em;
}
</style>