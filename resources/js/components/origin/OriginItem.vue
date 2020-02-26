<template>
  <tr>
    <td>
      {{origin.id}}
    </td>
    <td v-if="editing != origin.id">
      {{origin.ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Xuất xứ" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td>
      <div :title="origin.count + ' / ' + carCountApprove">
        <div v-if="origin.count > 0" :style="{ width: percent, opacity: opacity }" class="records-ratio"></div>
        <span>{{ percent }}</span>
      </div>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != origin.id" @click="edit" type="button" rel="tooltip" title="Chỉnh sửa" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons design-2_ruler-pencil"></i>
      </button>
      <button v-if="editing != origin.id" @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == origin.id" @click="updateOrigin" type="button" rel="tooltip" title="Xác nhận" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == origin.id" @click="cancle" type="button" rel="tooltip" title="Hủy" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'OriginItem',
  props: {
    origin: {
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
      newName: this.origin.ten,
      nameError: "",
    }
  },
  computed: {
    percent(){
      var self = this;
      return Math.round(((self.origin.count / self.carCountApprove) * 100 + Number.EPSILON) * 100) / 100 + '%';
    },
    opacity(){
      var self = this;
      return (self.origin.count / self.max);
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.origin.id);
      this.newName = this.origin.ten;
    },
    showPopup() {
      this.$emit('showPopup', this.origin);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateOrigin() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập nguồn gốc!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        var data = {
          id: this.origin.id,
          formData: formData,
        }

        this.$store.dispatch('updateOrigin', data);
        this.newName = "";
        this.$emit('changeEditing', -1);
      }
    },
  }
}
</script>

<style>
</style>