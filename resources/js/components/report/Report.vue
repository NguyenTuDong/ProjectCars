<template>
  <div>
    <div class="panel-header panel-header-sm"></div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Báo cáo</h4>
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
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">Phân loại</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link3" role="tablist">Thành viên</a>
                  </li>
                </ul>
                <select v-model="date" @change="onDateChange($event)" class="selectpicker" data-style="btn-primary btn-round btn-block">
                  <option value="week" selected>7 ngày qua</option>
                  <option value="4_weeks">28 ngày qua</option>
                  <option value="quarter">90 ngày qua</option>
                  <option value="year">365 ngày qua</option>
                  <option value="lifetime">Từ đầu đến giờ</option>
                  <option data-divider="true"></option>
                  <option value="current_year">2020</option>
                  <option value="minus_1_year">2019</option>
                  <option data-divider="true"></option>
                  <option value="current_month">Tháng 7</option>
                  <option value="minus_1_month">Tháng 6</option>
                  <option value="minus_2_month">Tháng 5</option>
                  <option data-divider="true"></option>
                  <option value="fixed">Tùy chọn</option>
                </select>
              </div>
              <div class="tab-content tab-space">
                <div class="tab-pane active" id="link1">
                  Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.
                  <br />
                  <br />Dramatically visualize customer directed convergence without revolutionary ROI.
                </div>
                <div class="tab-pane" id="link2">
                  Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                  <br />
                  <br />Dramatically maintain clicks-and-mortar solutions without functional solutions.
                </div>
                <div class="tab-pane" id="link3">
                  Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                  <br />
                  <br />Dynamically innovate resource-leveling customer service for state of the art customer service.
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
export default {
  name: "Report",
  data() {
    return {
      date: 'week',
    };
  },
  created() {
    $(document).ready(function() {
      $('.selectpicker').selectpicker();
    })
  },
  methods: {
    onDateChange(event) {
      if(event.target.value === 'fixed') alert('fixed');
    }
  }
};
</script>

<style>
</style>