<template>
  <tr>
    <td>
      {{color.id}}
    </td>
    <td class="text-center">
      <img :src="color.rgb_path" alt="">
      <div v-if="editing == color.id">
        <h6 class="text-primary my-3">Hình:</h6>
        <span class="text-danger" v-if="imgError != ''">{{imgError}}</span>
        <div>
          <img class="preview-logo" :src="preview" alt="">
          <button @click="showForm" class="btn btn-primary btn-block preview-btn">Chọn ảnh</button>
          <input @change="imagePreview" type="file" ref="img" value="Chọn ảnh" style="display: none">
        </div>
      </div>
    </td>
    <td v-if="editing != color.id">
      {{color.ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Tên Màu Xe" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != color.id" @click="edit" type="button" rel="tooltip" title="Chỉnh sửa" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons design-2_ruler-pencil"></i>
      </button>
      <button v-if="editing != color.id" @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == color.id" @click="updateColor" type="button" rel="tooltip" title="Xác nhận" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == color.id" @click="cancle" type="button" rel="tooltip" title="Hủy" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'ColorItem',
  props: {
    color: {
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
      newName: this.color.ten,
      imgError: "",
      nameError: "",
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.color.id);
      this.preview = "";
      this.newName = this.color.ten;
    },
    showPopup() {
      this.$emit('showPopup', this.color);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateColor() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên màu xe!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);
        var image = this.$refs.img.files[0];
        if(image != null){
          formData.append("img", image);
        }

        var data = {
          id: this.color.id,
          formData: formData,
        }

        this.$store.dispatch('updateColor', data);
        this.newName = "";
        this.preview = "";
        this.$emit('changeEditing', -1);
      }
    },
    showForm() {
      this.$refs.img.click();
    },
    imagePreview() 
    { 
      var input = this.$refs.img;
      var self = this;

      if (input.files && input.files[0]) 
      {
          var reader = new FileReader(); 
          reader.onload = function(e) { 
              self.preview = e.target.result;
          } 
          reader.readAsDataURL(input.files[0]); 
      } 
    },
  }
}
</script>

<style>
</style>