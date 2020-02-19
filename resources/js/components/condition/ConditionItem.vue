<template>
  <tr>
    <td>
      {{condition.id}}
    </td>
    <td v-if="editing != condition.id">
      {{condition.ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Tình trạng" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td>
      <div :title="condition.count + ' / ' + carCountAll">
        <div :style="{ width: percent, opacity: opacity }" class="records-ratio"></div>
        <span>{{ percent }}</span>
      </div>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != condition.id" @click="edit" type="button" rel="tooltip" title="Chỉnh sửa" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons design-2_ruler-pencil"></i>
      </button>
      <button v-if="editing != condition.id" @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == condition.id" @click="updateCondition" type="button" rel="tooltip" title="Xác nhận" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == condition.id" @click="cancle" type="button" rel="tooltip" title="Hủy" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'ConditionItem',
  props: {
    condition: {
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
    carCountAll: {
      type: Number,
    }
  },
  data() {
    return {
      newName: this.condition.ten,
      nameError: "",
    }
  },
  computed: {
    percent(){
      var self = this;
      return Math.round(((self.condition.count / self.carCountAll) * 100 + Number.EPSILON) * 100) / 100 + '%';
    },
    opacity(){
      var self = this;
      return (self.condition.count / self.max);
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.condition.id);
      this.newName = this.condition.ten;
    },
    showPopup() {
      this.$emit('showPopup', this.condition);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateCondition() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tình trạng!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        var data = {
          id: this.condition.id,
          formData: formData,
        }

        this.$store.dispatch('updateCondition', data);
        this.newName = "";
        this.$emit('changeEditing', -1);
      }
    },
  }
}
</script>

<style>
</style>