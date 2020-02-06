<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Dòng xe - 
                <select v-model="selectBrand" @click="getItems(selectBrand, 1)" class="card-select">
                  <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{brand.ten}}</option>
                </select>
              </h4>
              <button class="btn btn-primary ml-auto" @click="addType">Thêm dòng xe</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-types-id">
                      Id
                    </th>
                    <th class="table-types-name">
                      Tên dòng xe
                    </th>
                    <th class="table-types-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <type-item 
                      v-for="type in types" 
                      :key="type.id" 
                      :type="type"
                      :editing="editing"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></type-item>
                    <tr v-if="isAdd">
                      <td>
                      </td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Tên dòng xe" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td class="td-actions text-right">
                        <button @click="createType" class="btn btn-primary">Thêm dòng xe</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addType">Thêm dòng xe</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="types !== undefined">
        <div v-if="types.length > 0" class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- Pagination -->
              <nav class="d-flex">
                <ul class="mx-auto pagination">
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                    <a href="#" aria-label="Previous"
                        @click.prevent="getItems(selectBrand, 1)">
                        <span aria-hidden="true">««</span>
                    </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                    <a href="#" aria-label="Previous"
                        @click.prevent="getItems(selectBrand, pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                  </li>
                  <li v-for="(page, id) in pagesNumber" :class="[ page == isActived ? 'active' : '']" :key="id">
                      <a v-if="page == '...'" href="#">{{ page }}</a>
                      <a v-else href="#" @click.prevent="getItems(selectBrand, page)">{{ page }}</a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(selectBrand, pagination.current_page + 1)">
                          <span aria-hidden="true">»</span>
                      </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(selectBrand, pagination.last_page)">
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
import TypeItem from './TypeItem'

export default {
  name: 'Type',
  components: {
    TypeItem,
  },
  data() {
    return {
      editing: -1,
      deleting: -1,
      isAdd: false,
      selectBrand: 1,
      newName: "",
      nameError: "",
      offset: 3,
    }
  },
  created() {
    this.$store.dispatch('allBrands');
    var data = {
      brands_id: 1,
      page: 1,
    }
    this.$store.dispatch('retrieveTypes', data);
  },
  computed: {
    brands() {
      return this.$store.getters.allBrands;
    },
    types() {
      return this.$store.getters.types;
    },
    pagination() {
      return this.$store.getters.typesPagination;
    },
    isActived() {
        return this.$store.getters.typesPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.typesPagination;
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
    getItems(id, page){
      var data = {
        brands_id: id,
        page: page,
      }
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveTypes', data);
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.types.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa dòng xe <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    addType() {
      var data = {
        brands_id: this.selectBrand,
        page: this.pagination.last_page,
      }
      this.$store.dispatch('retrieveTypes', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    createType() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tên dòng xe!";
      } else {
        this.nameError = "";
      }
      if(this.newName != null){
        var formData = new FormData();
        formData.append("brands_id", this.selectBrand);
        formData.append("name", this.newName);

        this.$store.dispatch('createType', formData);
        this.newName = "";
        this.isAdd = false;
      }
    },
    deleteBrand() {
      this.$store.dispatch('deleteType', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    }
  }
}
</script>

<style>
.table-types-id{
  width: 5%;
}
.table-types-name{
  width: 70%;
}
.table-types-actions{
  width: 25%;
}
</style>