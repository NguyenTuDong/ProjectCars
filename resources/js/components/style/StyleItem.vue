<template>
  <tr>
    <td>
      {{id}}
    </td>
    <td class="text-center">
      <img :src="hinhanh_path" alt="">
      <div v-if="editing == id">
        <h6 class="text-primary my-3">Hình:</h6>
        <span class="text-danger" v-if="imgError != ''">{{imgError}}</span>
        <div>
          <img class="preview-logo" :src="preview" alt="">
          <button @click="showForm" class="btn btn-primary btn-block preview-btn">Chọn ảnh</button>
          <input @change="imagePreview" type="file" ref="img" value="Chọn ảnh" style="display: none">
        </div>
      </div>
    </td>
    <td v-if="editing != id">
      {{ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Tên kiểu dáng" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != id" @click="edit" type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons design-2_ruler-pencil"></i>
      </button>
      <button v-if="editing != id" @click="showPopup" type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == id" @click="updateStyle" type="button" rel="tooltip" title="" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == id" @click="cancle" type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'StyleItem',
  props: {
    styleItem: {
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
      id: this.styleItem.id,
      hinhanh: this.styleItem.hinhanh,
      hinhanh_path: this.styleItem.hinhanh_path,
      ten: this.styleItem.ten,
      preview: "",
      newName: this.styleItem.ten,
      imgError: "",
      nameError: "",
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.id);
      this.preview = "";
      this.newName = this.ten;
    },
    showPopup() {
      this.$emit('showPopup', this.id);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateStyle() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên kiểu dáng!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);
        var image = this.$refs.img.files[0];
        if(image != null){
          formData.append("img", image);
          this.hinhanh_path = this.preview;
        }

        var data = {
          id: this.id,
          formData: formData,
        }

        this.$store.dispatch('updateStyle', data);
        this.ten = this.newName;
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