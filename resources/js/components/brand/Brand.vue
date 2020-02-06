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
            </div>
          </div>
        </div>
      </div>
      <div v-if="brands !== undefined">
        <div v-if="brands.length > 0" class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- Pagination -->
              <nav class="d-flex">
                <ul class="mx-auto pagination">
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                    <a href="#" aria-label="Previous"
                        @click.prevent="getItems(1)">
                        <span aria-hidden="true">««</span>
                    </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                    <a href="#" aria-label="Previous"
                        @click.prevent="getItems(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                  </li>
                  <li v-for="(page, id) in pagesNumber" :class="[ page == isActived ? 'active' : '']" :key="id">
                      <a v-if="page == '...'" href="#">{{ page }}</a>
                      <a v-else href="#" @click.prevent="getItems(page)">{{ page }}</a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(pagination.current_page + 1)">
                          <span aria-hidden="true">»</span>
                      </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(pagination.last_page)">
                          <span aria-hidden="true">»»</span>
                      </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="pop-up">
      <div class="pop-up-inner">
        <div class="pop-up-header">
          <div class="pop-up-title">Thông báo</div>
          <button @click="closePopup" type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
            <i class="now-ui-icons ui-1_simple-remove"></i>
          </button>
        </div>
        <div class="pop-up-body">
        </div>
        <div class="pop-up-footer">
          <div class="row">
              <div class="col-lg-8 ml-auto mr-auto">
                  <div class="row">
                      <div class="col-md-6">
                          <button @click="deleteBrand" class="btn btn-danger btn-block">Xóa</button>
                      </div>
                      <div class="col-md-6">
                          <button @click="closePopup" class="btn btn-info btn-block">Hủy</button>
                      </div>
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
import { mapGetters } from 'vuex'

export default {
  name: 'Brand',
  components: {
    BrandItem,
  },
  data() {
    return {
      editing: -1,
      deleting: -1,
      isAdd: false,
      newName: "",
      preview: "",
      logoError: "",
      nameError: "",
      offset: 3,
    }
  },
  created() {
    this.$store.dispatch('retrieveBrands', 1);
  },
  computed: {
    ...mapGetters({
      brands: 'brands',
      pagination: 'brandsPagination',
    }),
    isActived() {
        return this.$store.getters.brandsPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.brandsPagination;
      var offset = this.offset;
      if (!pagination.to) {
        return [];
      }
      var from = pagination.current_page - offset;
      if (from > pagination.last_page - (offset * 2)){
        from = pagination.last_page - (offset * 2);
      }
      if (from < 1) {
        from = 1;
      }
      var to = from + (offset * 2);
      if (to >= pagination.last_page) {
        to = pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        if(to < pagination.last_page){
          if(from == to) pagesArray.push(pagination.last_page);
          else if(from == to - 1) pagesArray.push('...');
          else pagesArray.push(from);
        } else {
          pagesArray.push(from);
        }
        from++;
      }
      return pagesArray;
    }
  },
  methods: {
    clickCallback(pageNum) {
      console.log(pageNum)
    },
    getItems(page){
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveBrands', page);
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.brands.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa thương hiệu <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    addBrand() {
      this.$store.dispatch('retrieveBrands', this.pagination.last_page);
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
    deleteBrand() {
      this.$store.dispatch('deleteBrand', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
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
  width: 55%;
}
.table-brands-actions{
  width: 25%;
}
</style>