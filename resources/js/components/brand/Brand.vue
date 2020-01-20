<template>
  <div>
    <slot></slot>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Thương hiệu</h4>
              <button class="btn btn-primary ml-auto" @click="addBrand">Thêm thương hiệu</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-brands-id">
                      Id
                    </th>
                    <th class="table-brands-logo">
                      Logo
                    </th>
                    <th class="table-brands-name">
                      Tên thương hiệu
                    </th>
                    <th class="table-brands-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <brand-item 
                      v-for="brand in brands" 
                      :key="brand.id" 
                      :brand="brand"
                      :editing="editing"
                      @changeEditing="changeEditing"
                    ></brand-item>
                    <tr v-if="isAdd && !addBrandSuccess">
                      <td>
                      </td>
                      <td>
                        <h6 class="text-primary my-3">Logo:</h6>
                        <span class="text-danger" v-if="logoError != ''">{{logoError}}</span>
                        <div>
                          <img class="preview-logo" :src="preview" alt="">
                          <button @click="showForm" class="btn btn-primary btn-block preview-btn">Chọn ảnh</button>
                          <input @change="imagePreview" type="file" ref="newLogo" value="Chọn ảnh" style="display: none">
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Tên Thương Hiệu" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td class="td-actions text-right">
                        <button @click="createBrand" class="btn btn-primary">Thêm thương hiệu</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BrandItem from './BrandItem'

export default {
  name: 'Brand',
  components: {
    BrandItem,
  },
  data() {
    return {
      editing: -1,
      isAdd: false,
      newName: null,
      preview: null,
      logoError: "",
      nameError: "",
    }
  },
  computed: {
    brands() {
      return this.$store.state.brands;
    },
    addBrandSuccess() {
      return this.$store.state.createBrandSuccess;
    }
  },
  methods: {
    changeEditing(id) {
      this.editing = id;
    },
    addBrand() {
      this.isAdd = true;
      this.$store.dispatch('changeCreateBrandState', false);
      this.$nextTick(() => {
        this.$refs.newName.focus();
      })
    },
    showForm() {
      this.$refs.newLogo.click();
    },
    imagePreview() 
    { 
      var input = this.$refs.newLogo;
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
    createBrand() {
      if(this.$refs.newLogo.files[0] == null){
        this.logoError = "Vui lòng chọn logo!";
      } else {
        this.logoError = "";
      }

      if(this.newName == null){
        this.nameError = "Vui lòng nhập tên thương hiệu!";
      } else {
        this.nameError = "";
      }
      
      if(this.$refs.newLogo.files[0] != null && this.newName != null){
        var formData = new FormData();
        formData.append("logo", this.$refs.newLogo.files[0]);
        formData.append("name", this.newName);

        this.$store.dispatch('createBrand', formData);
      }
    }
  }
}
</script>

<style>
.table-brands-id{
  width: 5%;
}
.table-brands-logo{
  width: 40%;
}
.table-brands-name{
  width: 35%;
}
.table-brands-actions{
  width: 20%;
}
/* .preview-logo{
  width: 100px;
  height: auto;
} */
.preview-btn{
  width: 150px;
}
</style>