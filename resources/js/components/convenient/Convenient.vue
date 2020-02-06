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
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-convenients-id">
                      Id
                    </th>
                    <th class="table-convenients-name">
                      Tiện nghi
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
            </div>
          </div>
        </div>
      </div>
      <div v-if="convenients !== undefined">
        <div v-if="convenients.length > 0" class="row">
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
                          <button @click="deleteConvenient" class="btn btn-danger btn-block">Xóa</button>
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
import ConvenientItem from './ConvenientItem'

export default {
  name: 'Convenient',
  components: {
    ConvenientItem,
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
    this.$store.dispatch('retrieveConvenients', 1);
  },
  computed: {
    convenients() {
      return this.$store.getters.convenients;
    },
    pagination() {
      return this.$store.getters.convenientsPagination;
    },
    isActived() {
        return this.$store.getters.convenientsPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.convenientsPagination;
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
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveConvenients', page);
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.convenients.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa tiện nghi <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    addConvenient() {
      this.$store.dispatch('retrieveConvenients', this.pagination.last_page);
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
    deleteConvenient() {
      this.$store.dispatch('deleteConvenient', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    }
  }
}
</script>

<style>
.table-convenients-id{
  width: 5%;
}
.table-convenients-name{
  width: 70%;
}
.table-convenients-actions{
  width: 25%;
}
</style>