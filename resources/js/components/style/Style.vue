<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Kiểu dáng</h4>
              <button class="btn btn-primary ml-auto" @click="addStyle">Thêm kiểu dáng</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-styles-id">
                      Id
                    </th>
                    <th class="table-styles-logo text-center">
                      Hình ảnh
                    </th>
                    <th class="table-styles-name">
                      Tên kiểu dáng
                    </th>
                    <th class="table-styles-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <style-item 
                      v-for="style in styles" 
                      :key="style.id" 
                      :styleItem="style"
                      :editing="editing"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></style-item>
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
                          <input ref="newName" type="text" class="form-control" placeholder="Tên kiểu dáng" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td class="td-actions text-right">
                        <button @click="createStyle" class="btn btn-primary">Thêm kiểu dáng</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addStyle">Thêm kiểu dáng</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="styles !== undefined">
        <div v-if="styles.length > 0" class="row">
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
          Bạn có muốn xóa kiểu dáng này không?
        </div>
        <div class="pop-up-footer">
          <div class="row">
              <div class="col-lg-8 ml-auto mr-auto">
                  <div class="row">
                      <div class="col-md-6">
                          <button @click="deleteStyle" class="btn btn-danger btn-block">Xóa</button>
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
import StyleItem from './StyleItem'

export default {
  name: 'Style',
  components: {
    StyleItem,
  },
  data() {
    return {
      editing: -1,
      deleting: -1,
      isAdd: false,
      newName: "",
      preview: "",
      imgError: "",
      nameError: "",
      offset: 3,
    }
  },
  created() {
    this.$store.dispatch('retrieveStyles', 1);
  },
  computed: {
    styles() {
      return this.$store.getters.styles;
    },
    pagination() {
      return this.$store.getters.stylesPagination;
    },
    isActived() {
        return this.$store.getters.stylesPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.stylesPagination;
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
    getItems(page){
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveStyles', page);
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.styles.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa kiểu dáng <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    addStyle() {
      this.$store.dispatch('retrieveStyles', this.pagination.last_page);
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
    createStyle() {
      if(this.$refs.newImg.files[0] == null){
        this.imgError = "Vui lòng chọn hình!";
      } else {
        this.imgError = "";
      }

      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên kiểu dáng!";
      } else {
        this.nameError = "";
      }
      
      if(this.$refs.newImg.files[0] != null && this.newName != null){
        var formData = new FormData();
        formData.append("img", this.$refs.newImg.files[0]);
        formData.append("name", this.newName);

        this.$store.dispatch('createStyle', formData);
        this.newName = "";
        this.preview = "";
        this.isAdd = false;
      }
    },
    deleteStyle() {
      this.$store.dispatch('deleteStyle', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    }
  }
}
</script>

<style>
.table-styles-id{
  width: 5%;
}
.table-styles-logo{
  width: 15%;
}
.table-styles-name{
  width: 55%;
}
.table-styles-actions{
  width: 25%;
}
</style>