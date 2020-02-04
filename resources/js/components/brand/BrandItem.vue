<template>
  <tr>
    <td>
      {{id}}
    </td>
    <td class="text-center">
      <img :src="logo_path" alt="">
      <div v-if="editing == id">
        <h6 class="text-primary my-3">Logo:</h6>
        <span class="text-danger" v-if="logoError != ''">{{logoError}}</span>
        <div>
          <img class="preview-logo" :src="preview" alt="">
          <button @click="showForm" class="btn btn-primary btn-block preview-btn">Chọn ảnh</button>
          <input @change="imagePreview" type="file" ref="logo" value="Chọn ảnh" style="display: none">
        </div>
      </div>
    </td>
    <td v-if="editing != id">
      {{ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Tên Thương Hiệu" v-model="newName">
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
      <button v-if="editing == id" @click="updateBrand" type="button" rel="tooltip" title="" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
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
  name: 'BrandItem',
  props: {
    brand: {
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
      id: this.brand.id,
      logo: this.brand.logo,
      logo_path: this.brand.logo_path,
      ten: this.brand.ten,
      preview: "",
      newName: this.brand.ten,
      logoError: "",
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
    updateBrand() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên thương hiệu!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);
        var image = this.$refs.logo.files[0];
        if(image != null){
          formData.append("logo", image);
          this.logo_path = this.preview;
        }

        var data = {
          id: this.id,
          formData: formData,
        }

        this.$store.dispatch('updateBrand', data);
        this.ten = this.newName;
        this.newName = "";
        this.preview = "";
        this.$emit('changeEditing', -1);
      }
    },
    showForm() {
      this.$refs.logo.click();
    },
    imagePreview() 
    { 
      var input = this.$refs.logo;
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