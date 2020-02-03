<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Nguồn gốc</h4>
              <button class="btn btn-primary ml-auto" @click="addOrigin">Thêm nguồn gốc</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-origins-id">
                      Id
                    </th>
                    <th class="table-origins-name">
                      Nguồn gốc
                    </th>
                    <th class="table-origins-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <origin-item 
                      v-for="origin in origins" 
                      :key="origin.id" 
                      :origin="origin"
                      :editing="editing"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></origin-item>
                    <tr v-if="isAdd">
                      <td>
                      </td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Nguồn gốc" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td class="td-actions text-right">
                        <button @click="createOrigin" class="btn btn-primary">Thêm nguồn gốc</button>
                        <button @click="isAdd = false" class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addOrigin">Thêm nguồn gốc</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="origins.length > 0" class="row">
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
                          <button @click="deleteOrigin" class="btn btn-danger btn-block">Xóa</button>
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
import OriginItem from './OriginItem'

export default {
  name: 'Origin',
  components: {
    OriginItem,
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
    this.$store.dispatch('retrieveOrigins', 1);
  },
  computed: {
    origins() {
      return this.$store.getters.origins;
    },
    pagination() {
      return this.$store.getters.originsPagination;
    },
    isActived() {
        return this.$store.getters.originsPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.originsPagination;
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
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveOrigins', page);
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.origins.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa nguồn gốc <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    addOrigin() {
      this.$store.dispatch('retrieveOrigins', this.pagination.last_page);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    createOrigin() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập nguồn gốc!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        this.$store.dispatch('createOrigin', formData);
        this.newName = "";
        this.isAdd = false;
      }
    },
    deleteOrigin() {
      this.$store.dispatch('deleteOrigin', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    }
  }
}
</script>

<style>
.table-origins-id{
  width: 5%;
}
.table-origins-name{
  width: 70%;
}
.table-origins-actions{
  width: 25%;
}
</style>