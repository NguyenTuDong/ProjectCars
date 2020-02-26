<template>
  <tr>
    <td>
      {{car.id}}
    </td>
    <td class="text-center">
      <img :src="car.hinhanh_path" alt="">
    </td>
    <td>
      <router-link :to="{ name: 'car-detail', params: { id: car.id }}">
        <h6>{{car.ten}}</h6>
      </router-link>
      <div>
        <h6>{{price}} VND</h6>
      </div>
      <div class="blocks">
        <span title="Thương hiệu">{{car.types.brands.ten}}</span>
        <span title="Dòng xe">{{car.types.ten}}</span>
        <span title="Kiểu dáng">{{car.styles.ten}}</span>
        <span title="Tình trạng">{{car.conditions.ten}}</span>
        <span title="Nguồn gốc">{{car.origins.ten}}</span>
        <span title="Nơi bán">{{car.locations.ten}}</span>
      </div>
    </td>
    <td>
      <router-link :to="{ name: 'user-detail', params: { id: car.users_id }}">
        {{car.users.ten}}
      </router-link>
    </td>
    <td>
      <span v-if="car.trangthai == 0" class="text-warning">
        Chờ duyệt
      </span>
      <span v-if="car.trangthai == 2" class="text-success">
        Đã duyệt
      </span>
      <span v-if="car.trangthai == 3" class="text-danger">
        Đã từ chối
      </span>
    </td>
    <td class="td-actions text-right">
      <button v-if="car.trangthai == 0" @click="approveCar" type="button" rel="tooltip" title="Duyệt" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="car.trangthai == 0" @click="denyCar" type="button" rel="tooltip" title="Từ chối" class="btn btn-warning btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
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
  computed: {
    price() {
      return this.car.gia.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  },
  methods: {
    showPopup() {
      this.$emit('showPopup', this.car);
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
</style>