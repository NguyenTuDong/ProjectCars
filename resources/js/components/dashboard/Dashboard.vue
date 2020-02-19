<template>
  <div>
    <div class="panel-header panel-header-lg">
      <big-chart :data="carPerMonth"></big-chart>
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="statistics">
                    <div class="info">
                      <div class="icon text-success">
                        <i class="now-ui-icons business_money-coins"></i>
                      </div>
                      <h3 class="info-title">
                        {{carCountAll}}
                      </h3>
                      <h6 class="stats-title">Mẫu tin</h6>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
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
          <small-chart
            :canvas="'carActivePerMonth'"
            :category="'Số tin được đăng'"
            :label="'Online'"
            :color="'#18ce0f'"
            :yAxes="true"
            :xAxes="false"
            :bgColor="'rgba(24, 206, 15, 0.4)'"
            :data="carActivePerMonth"
          ></small-chart>
        </div>
        <div class="col-lg-4 col-md-6">
          <small-chart
            :canvas="'userPerMonth'"
            :category="'Số khách hàng'"
            :title="userCount"
            :label="'Khách hàng'"
            :color="'#f96332'"
            :yAxes="false"
            :xAxes="false"
            :bgColor="'rgba(249, 99, 59, 0.4)'"
            :data="userPerMonth"
          ></small-chart>
        </div>
        <div class="col-lg-4 col-md-6">
          <small-chart
            :canvas="'contactPerMonth'"
            :category="'Số liên hệ'"
            :title="contactCount"
            :label="'Liên hệ'"
            :type="'bar'"
            :color="'#2CA8FF'"
            :yAxes="true"
            :xAxes="false"
            :bgColor="'rgba(44, 168, 255, 0.6)'"
            :data="contactPerMonth"
          ></small-chart>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BigChart from "./BigChart";
import SmallChart from "./SmallChart";

export default {
  name: "Dashboard",
  components: {
    BigChart,
    SmallChart
  },
  created() {
    this.$store.dispatch("carPerMonth");

    this.$store.dispatch("carCount");
    this.$store.dispatch("userCount");
    this.$store.dispatch("contactCount");

    this.$store.dispatch("carActivePerMonth");

    this.$store.dispatch("userPerMonth");

    this.$store.dispatch("contactPerMonth");
  },
  computed: {
    carCountAll() {
      return this.$store.getters.carCount;
    },
    carPerMonth() {
      return this.$store.getters.carPerMonth;
    },
    carActivePerMonth() {
      return this.$store.getters.carActivePerMonth;
    },
    userCountAll() {
      return this.$store.getters.userCount;
    },
    userPerMonth() {
      return this.$store.getters.userPerMonth;
    },
    userCount() {
      var count = 0;
      var data = this.$store.getters.userPerMonth;

      data.forEach(el => {
        count += el.count;
      });

      return count;
    },
    contactCountAll() {
      return this.$store.getters.contactCount;
    },
    contactPerMonth() {
      return this.$store.getters.contactPerMonth;
    },
    contactCount() {
      var count = 0;
      var data = this.$store.getters.contactPerMonth;

      data.forEach(el => {
        count += el.count;
      });

      return count;
    },
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