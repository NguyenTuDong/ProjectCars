<template>
  <tr>
    <td>
      {{brand.id}}
    </td>
    <td>
      <img :src="brand.logo_path" alt="">
      <div v-if="this.editing == this.id">
        <h6 class="text-primary my-3">Logo:</h6>
        <div>
          <img class="preview-logo" :src="preview" alt="">
          <button @click="showForm" class="btn btn-primary btn-block preview-btn">Chọn ảnh</button>
          <input @change="imagePreview" type="file" ref="logo" value="Chọn ảnh" style="display: none">
        </div>
      </div>
    </td>
    <td v-if="this.editing != this.id">
      {{brand.ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Tên Thương Hiệu" :value="this.newName">
      </div>
    </td>
    <td class="td-actions text-right">
      <button v-if="this.editing != this.id" @click="edit" type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons ui-2_settings-90"></i>
      </button>
      <button v-if="this.editing != this.id" type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="this.editing == this.id" @click="updateBrand" type="button" rel="tooltip" title="" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="this.editing == this.id" @click="cancle" type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
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
      preview: null,
      newName: this.brand.ten,
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.id);
      this.preview = null;
      this.newName = this.brand.ten;
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateBrand() {
      this.$emit('changeEditing', -1);
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
    }
  }
}
</script>

<style>
</style>