<template>
  <div>
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
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-brands-id">
                      Id
                    </th>
                    <th class="table-brands-logo text-center">
                      Logo
                    </th>
                    <th class="table-brands-name">
                      Tên thương hiệu
                    </th>
                    <th class="table-brands-ratio">
                      Tỉ lệ
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
                      :max="max"
                      :carCountAll="carCountAll"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></brand-item>
                    <tr v-if="isAdd">
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
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addBrand">Thêm thương hiệu</button>
                </div>
              </div>
              <pagination
                :pagination="pagination"
                :getItems="getItems"
              ></pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <modal
      ref="modal"
      :message="message"
      @submit="submit"
    ></modal>
  </div>
</template>

<script>
import BrandItem from './BrandItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex'

export default {
  name: 'Brand',
  components: {
    BrandItem,
    Modal,
    Pagination,
  },
  data() {
    return {
      editing: -1,
      isAdd: false,
      newName: "",
      preview: "",
      logoError: "",
      nameError: "",
      offset: 3,
      message: '',
      q: '',
    }
  },
  watch: {
    q: function() {
      this.debouncedGetQuery();
    }
  },
  created() {
    var data = {
      page: 1,
      q: '',
    }
    this.$store.dispatch('retrieveBrands', data);
    this.$store.dispatch("carCount");
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      brands: 'brands',
      pagination: 'brandsPagination',
    }),
    carCountAll() {
      return this.$store.getters.carCount;
    },
    max(){
      var max = 0;
      this.brands.forEach(ele => {
        if(ele.count > max) max = ele.count;
      });
      return max;
    }
  },
  methods: {
    getItems(page){
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) {
        var data = {
          page: page,
          q: this.q,
        }
        this.$store.dispatch('retrieveBrands', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa thương hiệu <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addBrand() {
      var data = {
        page: this.pagination.last_page,
        q: this.q,
      }
      this.$store.dispatch('retrieveBrands', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
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

      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên thương hiệu!";
      } else {
        this.nameError = "";
      }
      
      if(this.$refs.newLogo.files[0] != null && this.newName != null){
        var formData = new FormData();
        formData.append("logo", this.$refs.newLogo.files[0]);
        formData.append("name", this.newName);

        this.$store.dispatch('createBrand', formData);
        this.newName = "";
        this.preview = "";
        this.isAdd = false;
      }
    },
    submit(data) {
      this.$store.dispatch('deleteBrand', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveBrands', data);
    }
  }
}
</script>

<style>
.table-brands-id{
  width: 5%;
}
.table-brands-logo{
  width: 15%;
}
.table-brands-name{
  width: 20%;
}
.table-brands-ratio{
  width: 35%;
}
.table-brands-actions{
  width: 25%;
}
</style>