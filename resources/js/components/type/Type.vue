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
              <div class="search-form">
                <input @keyup="search" v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
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
                        @click.prevent="getItems(1)">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                    <a href="#" aria-label="Previous"
                        @click.prevent="getItems(pagination.current_page - 1)">
                        <span aria-hidden="true"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                    </a>
                  </li>
                  <li v-for="(page, id) in pagesNumber" :class="[ page == isActived ? 'active' : '']" :key="id">
                      <a v-if="page == '...'" href="#">{{ page }}</a>
                      <a v-else href="#" @click.prevent="getItems(page)">{{ page }}</a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(pagination.current_page + 1)">
                          <span aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                      </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(pagination.last_page)">
                          <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                      </a>
                  </li>
                </ul>
              </nav>
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
import TypeItem from './TypeItem'
import Modal from '../Modal';

export default {
  name: 'Type',
  components: {
    TypeItem,
    Modal
  },
  data() {
    return {
      editing: -1,
      isAdd: false,
      selectBrand: 1,
      newName: "",
      nameError: "",
      offset: 3,
      message: '',
      q: '',
    }
  },
  created() {
    this.$store.dispatch('allBrands');
    var data = {
      brands_id: 1,
      page: 1,
      q: '',
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
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) {
        var data = {
          brands_id: id,
          page: page,
          q: this.q,
        }
        this.$store.dispatch('retrieveTypes', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa dòng xe <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addType() {
      var data = {
        brands_id: this.selectBrand,
        page: this.pagination.last_page,
        q: this.q,
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
    submit(data) {
      this.$store.dispatch('deleteType', data.id);
    },
    search() {
      var data = {
        brands_id: this.selectBrand,
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveTypes', data);
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