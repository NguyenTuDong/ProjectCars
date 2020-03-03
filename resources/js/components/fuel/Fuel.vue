<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Nhiên liệu</h4>
              <button v-if="fuels" class="btn btn-primary ml-auto" @click="addFuel">Thêm nhiên liệu</button>
            </div>
            <div v-if="!fuels" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-fuels-id">
                      Id
                    </th>
                    <th class="table-fuels-name">
                      Nhiên liệu
                    </th>
                    <th class="table-fuels-ratio">
                      Tỉ lệ
                    </th>
                    <th class="table-fuels-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <fuel-item 
                      v-for="fuel in fuels" 
                      :key="fuel.id" 
                      :fuel="fuel"
                      :editing="editing"
                      :max="max"
                      :carCountApprove="carCountApprove"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></fuel-item>
                    <tr v-if="isAdd">
                      <td>
                      </td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Nhiên liệu" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td></td>
                      <td class="td-actions text-right">
                        <button @click="createFuel" class="btn btn-primary">Thêm nhiên liệu</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addFuel">Thêm nhiên liệu</button>
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
import FuelItem from './FuelItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Fuel',
  components: {
    FuelItem,
    Modal,
    Pagination,
  },
  data() {
    return {
      editing: -1,
      isAdd: false,
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
    var data = {
      page: 1,
      q: '',
    }
    this.$store.dispatch('retrieveFuels', data);
    this.$store.dispatch("carCountApprove");
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      fuels: 'fuels',
      pagination: 'fuelsPagination',
    }),
    carCountApprove() {
      return this.$store.getters.carCountApprove;
    },
    max(){
      var max = 0;
      this.fuels.forEach(ele => {
        if(ele.count > max) max = ele.count;
      });
      return max;
    },
  },
  methods: {
    getItems(page){
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) {
        var data = {
          page: page,
          q: this.q,
        }
        this.$store.dispatch('retrieveFuels', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa nhiên liệu <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addFuel() {
      var data = {
        page: this.pagination.last_page,
        q: this.q,
      }
      this.$store.dispatch('retrieveFuels', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    createFuel() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập nhiên liệu!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        this.$store.dispatch('createFuel', formData);
        this.newName = "";
        this.isAdd = false;
      }
    },
    submit(data) {
      this.$store.dispatch('deleteFuel', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveFuels', data);
    }
  }
}
</script>

<style>
.table-fuels-id{
  width: 5%;
}
.table-fuels-name{
  width: 30%;
}
.table-fuels-ratio{
  width: 40%;
}
.table-fuels-actions{
  width: 25%;
}
</style>