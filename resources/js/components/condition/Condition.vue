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
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-conditions-id">
                      Id
                    </th>
                    <th class="table-conditions-name">
                      Tình trạng
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
            </div>
          </div>
        </div>
      </div>
      <div v-if="conditions !== undefined">
        <div v-if="conditions.length > 0" class="row">
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
                          <button @click="deleteCondition" class="btn btn-danger btn-block">Xóa</button>
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
import ConditionItem from './ConditionItem'

export default {
  name: 'Condition',
  components: {
    ConditionItem,
  },
  data() {
    return {
      editing: -1,
      deleting: -1,
      isAdd: false,
      newName: "",
      nameError: "",
      offset: 3,
    }
  },
  created() {
    this.$store.dispatch('retrieveConditions', 1);
  },
  computed: {
    conditions() {
      return this.$store.getters.conditions;
    },
    pagination() {
      return this.$store.getters.conditionsPagination;
    },
    isActived() {
        return this.$store.getters.conditionsPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.conditionsPagination;
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
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveConditions', page);
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.conditions.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa tình trạng <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    addCondition() {
      this.$store.dispatch('retrieveConditions', this.pagination.last_page);
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
    deleteCondition() {
      this.$store.dispatch('deleteCondition', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    }
  }
}
</script>

<style>
.table-conditions-id{
  width: 5%;
}
.table-conditions-name{
  width: 70%;
}
.table-conditions-actions{
  width: 25%;
}
</style>