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
    <td class="td-actions text-right">
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