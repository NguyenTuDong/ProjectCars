<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Tiện nghi</h4>
              <button class="btn btn-primary ml-auto" @click="addConvenient">Thêm tiện nghi</button>
            </div>
            <div class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-convenients-id">
                      Id
                    </th>
                    <th class="table-convenients-name">
                      Tiện nghi
                    </th>
                    <th class="table-convenients-ratio">
                      Tỉ lệ
                    </th>
                    <th class="table-convenients-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <convenient-item 
                      v-for="convenient in convenients" 
                      :key="convenient.id" 
                      :convenient="convenient"
                      :editing="editing"
                      :max="max"
                      :carCountAll="carCountAll"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></convenient-item>
                    <tr v-if="isAdd">
                      <td>
                      </td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Tiện nghi" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td class="td-actions text-right">
                        <button @click="createConvenient" class="btn btn-primary">Thêm tiện nghi</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addConvenient">Thêm tiện nghi</button>
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
import ConvenientItem from './ConvenientItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Convenient',
  components: {
    ConvenientItem,
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
    this.$store.dispatch('retrieveConvenients', data);
    this.$store.dispatch("carCount");
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      convenients: 'convenients',
      pagination: 'convenientsPagination',
    }),
    carCountAll() {
      return this.$store.getters.carCount;
    },
    max(){
      var max = 0;
      this.convenients.forEach(ele => {
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
        this.$store.dispatch('retrieveConvenients', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa tiện nghi <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addConvenient() {
      var data = {
        page: this.pagination.last_page,
        q: this.q,
      }
      this.$store.dispatch('retrieveConvenients', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    createConvenient() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tiện nghi!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        this.$store.dispatch('createConvenient', formData);
        this.newName = "";
        this.isAdd = false;
      }
    },
    submit(data) {
      this.$store.dispatch('deleteConvenient', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveConvenients', data);
    }
  }
}
</script>

<style>
.table-convenients-id{
  width: 5%;
}
.table-convenients-name{
  width: 30%;
}
.table-convenients-ratio{
  width: 40%;
}
.table-convenients-actions{
  width: 25%;
}
</style>