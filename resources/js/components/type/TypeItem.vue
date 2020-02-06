<template>
  <tr>
    <td>
      {{type.id}}
    </td>
    <td v-if="editing != type.id">
      {{type.ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Tên Thương Hiệu" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != type.id" @click="edit" type="button" rel="tooltip" title="Chỉnh sửa" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons design-2_ruler-pencil"></i>
      </button>
      <button v-if="editing != type.id" @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == type.id" @click="updateType" type="button" rel="tooltip" title="Xác nhận" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == type.id" @click="cancle" type="button" rel="tooltip" title="Hủy" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'TypeItem',
  props: {
    type: {
      type: Object,
      required: true,
    },
    editing: {
      type: Number,
      required: true,
    }
  },
  data() {
    return {
      preview: "",
      newName: this.type.ten,
      logoError: "",
      nameError: "",
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.type.id);
      this.preview = "";
      this.newName = this.type.ten;
    },
    showPopup() {
      this.$emit('showPopup', this.type.id);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateType() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên dòng xe!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        var data = {
          id: this.type.id,
          formData: formData,
        }

        this.$store.dispatch('updateType', data);
        this.newName = "";
        this.$emit('changeEditing', -1);
      }
    },
  }
}
</script>

<style>
</style>