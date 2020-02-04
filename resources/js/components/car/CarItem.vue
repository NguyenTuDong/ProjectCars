<template>
  <tr>
    <td>
      {{id}}
    </td>
    <td class="text-center">
      <img :src="hinhanh_path" alt="">
    </td>
    <td>
      <a href="#" class="text-primary">
        <h6>{{ten}}</h6>
      </a>
      <div>
        <h6>{{price}} VND</h6>
      </div>
      <div class="blocks">
        <span title="Thương hiệu">{{brand}}</span>
        <span title="Dòng xe">{{type}}</span>
        <span title="Kiểu dáng">{{style}}</span>
        <span title="Tình trạng">{{condition}}</span>
        <span title="Nguồn gốc">{{origin}}</span>
        <span title="Nơi bán">{{location}}</span>
      </div>
    </td>
    <td>
      <a href="#">
        {{author}}
      </a>
    </td>
    <td>
      <span v-if="trangthai == 0" class="text-warning">
        Chờ duyệt
      </span>
      <span v-if="trangthai == 2" class="text-success">
        Đã duyệt
      </span>
      <span v-if="trangthai == 3" class="text-danger">
        Đã từ chối
      </span>
    </td>
    <td class="td-actions text-right">
      <button v-if="trangthai != 2" @click="approveCar" type="button" rel="tooltip" title="Duyệt" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="trangthai != 3" @click="denyCar" type="button" rel="tooltip" title="Từ chối" class="btn btn-warning btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
      <button @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'CarItem',
  props: {
    car: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      id: this.car.id,
      hinhanh: this.car.hinhanh,
      hinhanh_path: this.car.hinhanh_path,
      ten: this.car.ten,
      gia: this.car.gia,
      author: this.car.users.ten,
      type: this.car.types.ten,
      brand: this.car.types.brands.ten,
      color: this.car.colors.ten,
      condition: this.car.conditions.ten,
      fuel: this.car.fuels.ten,
      location: this.car.locations.ten,
      origin: this.car.origins.ten,
      style: this.car.styles.ten,
      transmission: this.car.transmissions.ten,
      trangthai: this.car.trangthai,
    }
  },
  computed: {
    price() {
      return this.gia.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  },
  methods: {
    showPopup() {
      this.$emit('showPopup', this.id);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    approveCar() {
      this.$store.dispatch('approveCar', this.id);
      this.trangthai = 2;
    },
    denyCar() {
      this.$store.dispatch('denyCar', this.id);
      this.trangthai = 3;
    },
  }
}
</script>

<style>
.blocks span{
  display: inline-block;
  background-color: #fa7a50;
  font-size: 11px;
  color: white;
  padding: 2px 5px;
}
</style>