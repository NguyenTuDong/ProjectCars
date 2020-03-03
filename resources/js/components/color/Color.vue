<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Màu xe</h4>
              <button v-if="colors" class="btn btn-primary ml-auto" @click="addColor">Thêm màu xe</button>
            </div>
            <div v-if="!colors" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-colors-id">
                      Id
                    </th>
                    <th class="table-colors-img text-center">
                      Màu xe
                    </th>
                    <th class="table-colors-name">
                      Tên màu xe
                    </th>
                    <th class="table-colors-ratio">
                      Tỉ lệ
                    </th>
                    <th class="table-colors-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <color-item 
                      v-for="color in colors" 
                      :key="color.id" 
                      :color="color"
                      :editing="editing"
                      :max="max"
                      :carCountApprove="carCountApprove"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></color-item>
                    <tr v-if="isAdd">
                      <td>
                      </td>
                      <td>
                        <h6 class="text-primary my-3">Hình:</h6>
                        <span class="text-danger" v-if="imgError != ''">{{imgError}}</span>
                        <div>
                          <img class="preview-logo" :src="preview" alt="">
                          <button @click="showForm" class="btn btn-primary btn-block preview-btn">Chọn ảnh</button>
                          <input @change="imagePreview" type="file" ref="newImg" value="Chọn ảnh" style="display: none">
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Tên màu xe" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td></td>
                      <td class="td-actions text-right">
                        <button @click="createColor" class="btn btn-primary">Thêm màu xe</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addColor">Thêm màu xe</button>
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
import ColorItem from './ColorItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Color',
  components: {
    ColorItem,
    Modal,
    Pagination,
  },
  data() {
    return {
      editing: -1,
      isAdd: false,
      newName: "",
      preview: "",
      imgError: "",
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
    this.$store.dispatch('retrieveColors', data);
    this.$store.dispatch("carCountApprove");
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      colors: 'colors',
      pagination: 'colorsPagination',
    }),
    carCountApprove() {
      return this.$store.getters.carCountApprove;
    },
    max(){
      var max = 0;
      this.colors.forEach(ele => {
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
        this.$store.dispatch('retrieveColors', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa màu <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addColor() {
      var data = {
        page: this.pagination.last_page,
        q: this.q,
      }
      this.$store.dispatch('retrieveColors', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    showForm() {
      this.$refs.newImg.click();
    },
    imagePreview() 
    { 
      var input = this.$refs.newImg;
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
    createColor() {
      if(this.$refs.newImg.files[0] == null){
        this.imgError = "Vui lòng chọn hình!";
      } else {
        this.imgError = "";
      }

      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên màu xe!";
      } else {
        this.nameError = "";
      }
      
      if(this.$refs.newImg.files[0] != null && this.newName != null){
        var formData = new FormData();
        formData.append("img", this.$refs.newImg.files[0]);
        formData.append("name", this.newName);

        this.$store.dispatch('createColor', formData);
        this.newName = "";
        this.preview = "";
        this.isAdd = false;
      }
    },
    submit(data) {
      this.$store.dispatch('deleteColor', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveColors', data);
    }
  }
}
</script>

<style>
.table-colors-id{
  width: 5%;
}
.table-colors-img{
  width: 15%;
}
.table-colors-name{
  width: 20%;
}
.table-colors-ratio{
  width: 35%;
}
.table-colors-actions{
  width: 25%;
}
</style>