<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Hộp số</h4>
              <button v-if="transmissions" class="btn btn-primary ml-auto" @click="addTransmission">Thêm hộp số</button>
            </div>
            <div v-if="!transmissions" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-transmissions-id">
                      Id
                    </th>
                    <th class="table-transmissions-name">
                      Hộp số
                    </th>
                    <th class="table-transmissions-ratio">
                      Tỉ lệ
                    </th>
                    <th class="table-transmissions-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <transmission-item 
                      v-for="transmission in transmissions" 
                      :key="transmission.id" 
                      :transmission="transmission"
                      :editing="editing"
                      :max="max"
                      :carCountApprove="carCountApprove"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></transmission-item>
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
                        <button @click="createTransmission" class="btn btn-primary">Thêm hộp số</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addTransmission">Thêm hộp số</button>
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
import TransmissionItem from './TransmissionItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Transmission',
  components: {
    TransmissionItem,
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
    this.$store.dispatch('retrieveTransmissions', data);
    this.$store.dispatch("carCountApprove");
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      transmissions: 'transmissions',
      pagination: 'transmissionsPagination',
    }),
    carCountApprove() {
      return this.$store.getters.carCountApprove;
    },
    max(){
      var max = 0;
      this.transmissions.forEach(ele => {
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
        this.$store.dispatch('retrieveTransmissions', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa hộp số <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addTransmission() {
      var data = {
        page: this.pagination.last_page,
        q: this.q,
      }
      this.$store.dispatch('retrieveTransmissions', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    createTransmission() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập hộp số!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        this.$store.dispatch('createTransmission', formData);
        this.newName = "";
        this.isAdd = false;
      }
    },
    submit(data) {
      this.$store.dispatch('deleteTransmission', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveTransmissions', data);
    }
  }
}
</script>

<style>
.table-transmissions-id{
  width: 5%;
}
.table-transmissions-name{
  width: 30%;
}
.table-transmissions-ratio{
  width: 40%;
}
.table-transmissions-actions{
  width: 25%;
}
</style>