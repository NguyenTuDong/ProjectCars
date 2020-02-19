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
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
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
                    <th class="table-types-ratio">
                      Tỉ lệ
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
                      :max="max"
                      :carCountAll="carCountAll"
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
import TypeItem from './TypeItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Type',
  components: {
    TypeItem,
    Modal,
    Pagination,
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
  watch: {
    q: function() {
      this.debouncedGetQuery();
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
    this.$store.dispatch("carCount");
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      brands: 'allBrands',
      types: 'types',
      pagination: 'typesPagination',
    }),
    carCountAll() {
      return this.$store.getters.carCount;
    },
    max(){
      var max = 0;
      this.types.forEach(ele => {
        if(ele.count > max) max = ele.count;
      });
      return max;
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
  width: 30%;
}
.table-types-ratio{
  width: 40%;
}
.table-types-actions{
  width: 25%;
}
</style>