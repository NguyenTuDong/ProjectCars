<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <button @click="$router.go(-1)" class="btn-back"><i class="now-ui-icons arrows-1_minimal-left"></i> Trở lại</button>
    <div class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="car-image">
              <img :src="car.hinhanh_path" alt="">
            </div>
            <div class="card-body">
              <h5 class="title text-primary text-center car-price">
                {{ price }} VND
              </h5>
              <p v-if="car.types !== undefined" class="text-center">
                {{ car.types.ten }} | {{ car.types.brands.ten }}
              </p>
              <p>
                <span v-if="car.styles !== undefined"><b>Kiểu dáng: </b>{{ car.styles.ten }}<br></span>
                <span v-if="car.origins !== undefined"><b>Nguồn gốc: </b>{{ car.origins.ten }}<br></span>
                <span v-if="car.conditions !== undefined"><b>Tình trạng: </b>{{ car.conditions.ten }}<br></span>
                <span v-if="car.doixe != null"><b>Đời xe: </b>{{ car.doixe }}<br></span>
                <span v-if="car.namsx != null"><b>Năm sản xuất: </b>{{ car.namsx }}<br></span>
                <span v-if="car.locations !== undefined"><b>Nơi bán: </b>{{ car.locations.ten }}<br></span>
                <span v-if="car.created_at != null"><b>Ngày tạo: </b>{{ car.created_at }}<br></span>
              </p>
              <div class="row justify-content-center text-center">
                <div v-if="car.trangthai == 0" class="col-md-4">
                  <button @click="approveCar" type="button" rel="tooltip" title="Duyệt" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
                    <i class="now-ui-icons ui-1_check"></i>
                  </button>
                </div>
                <div v-if="car.trangthai == 0" class="col-md-4">
                  <button @click="denyCar" type="button" rel="tooltip" title="Từ chối" class="btn btn-warning btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
                    <i class="now-ui-icons ui-1_simple-delete"></i>
                  </button>
                </div>
                <div class="col-md-4">
                  <button @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
                    <i class="now-ui-icons ui-1_simple-remove"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="d-flex card-header">
              <h5 class="title">{{ car.ten }}</h5>
            </div>
            <div class="card-body">
              <p v-if="car.users !== undefined">
                <b>Người đăng: </b>
                <router-link :to="{ name: 'user-detail', params: { id: car.users_id }}">
                  {{car.users.ten}}
                </router-link>
              </p>
              <div v-html="car.mota"></div>
              <h5>Thông tin cơ bản</h5>
              <div class="row mb-4">
                <div v-if="car.fuels !== undefined" class="col-md-6">
                  <b>Nhiên liệu: </b>{{ car.fuels.ten }}
                </div>
                <div v-if="car.transmissions !== undefined" class="col-md-6">
                  <b>Hộp số: </b>{{ car.transmissions.ten }}
                </div>
                <div v-if="car.colors !== undefined" class="col-md-6">
                  <b>Màu xe: </b>{{ car.colors.ten }}
                </div>
                <div v-if="car.furnitures !== undefined" class="col-md-6">
                  <b>Màu nội thất: </b>{{ car.furnitures.ten }}
                </div>
                <div v-if="car.socua != null" class="col-md-6">
                  <b>Số cửa: </b>{{ car.socua }}
                </div>
                <div v-if="car.sochongoi != null" class="col-md-6">
                  <b>Số chổ ngồi: </b>{{ car.sochongoi }}
                </div>
              </div>
              <h5>Thông tin kỹ thuật</h5>
              <div class="row mb-4">
                <div v-if="car.kichthuoc != null" class="col-md-6">
                  <b>Dài x Rộng x Cao (mm): </b>{{ car.kichthuoc }}
                </div>
                <div v-if="car.phanh != null" class="col-md-6">
                  <b>Phanh: </b>{{ car.phanh }}
                </div>
                <div v-if="car.cannang != null" class="col-md-6">
                  <b>Trọng lượng không tải (kg): </b>{{ car.cannang }}
                </div>
                <div v-if="car.giamxoc != null" class="col-md-6">
                  <b>Giảm xóc: </b>{{ car.giamxoc }}
                </div>
                <div v-if="car.dungtich != null" class="col-md-6">
                  <b>Dung tích động cơ: </b>{{ car.dungtich }}
                </div>
                <div v-if="car.lopxe != null" class="col-md-6">
                  <b>Lốp xe: </b>{{ car.lopxe }}
                </div>
              </div>
              <h5>Tiện nghi</h5>
              <div class="row mb-4">
                <div v-for="item in car.convenientcars" :key="item.id" class="col-md-6">
                  <b>{{ item.convenients.ten }}</b>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="pop-up">
      <div class="pop-up-inner">
        <div class="pop-up-header">
          <div class="pop-up-title">Thông báo</div>
          <button @click="closePopup" type="button" rel="tooltip" title="" class="btn btn-link btn-neutral" data-original-title="Remove">
            <i class="now-ui-icons ui-1_simple-remove"></i>
          </button>
        </div>
        <div class="pop-up-body">
        </div>
        <div class="pop-up-footer">
          <button @click="deleteCar" class="btn btn-link btn-neutral">Xóa</button>
          <button @click="closePopup" class="btn btn-link btn-neutral">Hủy</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'CarDetail',
  data() {
    return {
      id: this.$route.params.id
    }
  },
  created() {
    this.$store.dispatch('getCar', this.id);
  },
  computed: {
    car() {
      return this.$store.getters.car;
    },
    price() {
      if(this.$store.getters.car.gia === undefined) return;
      return this.$store.getters.car.gia.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  },
  methods: {
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var message = "Bạn có muốn xóa mẫu tin <b>"+this.car.ten+"</b> không?";
      $('.pop-up-body').html(message);
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
    },
    deleteCar() {
      this.$store.dispatch('deleteCar', this.car.id);
      $('.pop-up').fadeOut(300);
    },
    approveCar() {
      this.$store.dispatch('approveCar', this.car.id);
    },
    denyCar() {
      this.$store.dispatch('denyCar', this.car.id);
    },
  }
}
</script>

<style>
.btn-back{
  position: absolute;
  top: 40px;
  left: 30px;
  background-color: transparent;
  padding: 0;
  color: white;
  border: 0;
  cursor: pointer;
  z-index: 1100;
}
</style>