<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Tình trạng</h4>
              <button class="btn btn-primary ml-auto" @click="addCondition">Thêm tình trạng</button>
            </div>
            <div class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-conditions-id">
                      Id
                    </th>
                    <th class="table-conditions-name">
                      Tình trạng
                    </th>
                    <th class="table-conditions-ratio">
                      Tỉ lệ
                    </th>
                    <th class="table-conditions-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <condition-item 
                      v-for="condition in conditions" 
                      :key="condition.id" 
                      :condition="condition"
                      :editing="editing"
                      :max="max"
                      :carCountApprove="carCountApprove"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></condition-item>
                    <tr v-if="isAdd">
                      <td>
                      </td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Tình trạng" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td class="td-actions text-right">
                        <button @click="createCondition" class="btn btn-primary">Thêm tình trạng</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addCondition">Thêm tình trạng</button>
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
import ConditionItem from './ConditionItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Condition',
  components: {
    ConditionItem,
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
    this.$store.dispatch('retrieveConditions', data);
    this.$store.dispatch("carCountApprove");
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      conditions: 'conditions',
      pagination: 'conditionsPagination',
    }),
    carCountApprove() {
      return this.$store.getters.carCountApprove;
    },
    max(){
      var max = 0;
      this.conditions.forEach(ele => {
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
        this.$store.dispatch('retrieveConditions', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa tình trạng <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addCondition() {
      var data = {
        page: this.pagination.last_page,
        q: this.q,
      }
      this.$store.dispatch('retrieveConditions', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    createCondition() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tình trạng!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        this.$store.dispatch('createCondition', formData);
        this.newName = "";
        this.isAdd = false;
      }
    },
    submit(data) {
      this.$store.dispatch('deleteCondition', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveConditions', data);
    }
  }
}
</script>

<style>
.table-conditions-id{
  width: 5%;
}
.table-conditions-name{
  width: 30%;
}
.table-conditions-ratio{
  width: 40%;
}
.table-conditions-actions{
  width: 25%;
}
</style>