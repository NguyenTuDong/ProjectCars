<template>
  <tr>
    <td>
      {{fuel.id}}
    </td>
    <td v-if="editing != fuel.id">
      {{fuel.ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Nhiên liệu" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td>
      <div :title="fuel.count + ' / ' + carCountApprove">
        <div v-if="fuel.count > 0" :style="{ width: percent, opacity: opacity }" class="records-ratio"></div>
        <span>{{ percent }}</span>
      </div>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != fuel.id" @click="edit" type="button" rel="tooltip" title="Chỉnh sửa" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons design-2_ruler-pencil"></i>
      </button>
      <button v-if="editing != fuel.id" @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == fuel.id" @click="updateFuel" type="button" rel="tooltip" title="Xác nhận" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == fuel.id" @click="cancle" type="button" rel="tooltip" title="Hủy" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'FuelItem',
  props: {
    fuel: {
      type: Object,
      required: true,
    },
    editing: {
      type: Number,
      required: true,
    },
    max: {
      type: Number,
    },
    carCountApprove: {
      type: Number,
    }
  },
  data() {
    return {
      newName: this.fuel.ten,
      nameError: "",
    }
  },
  computed: {
    percent(){
      var self = this;
      return Math.round(((self.fuel.count / self.carCountApprove) * 100 + Number.EPSILON) * 100) / 100 + '%';
    },
    opacity(){
      var self = this;
      return (self.fuel.count / self.max);
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.fuel.id);
      this.newName = this.fuel.ten;
    },
    showPopup() {
      this.$emit('showPopup', this.fuel);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateFuel() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập nhiên liệu!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        var data = {
          id: this.fuel.id,
          formData: formData,
        }

        this.$store.dispatch('updateFuel', data);
        this.newName = "";
        this.$emit('changeEditing', -1);
      }
    },
  }
}
</script>

<style>
</style>