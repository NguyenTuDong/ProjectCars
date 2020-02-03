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
              <button class="btn btn-primary ml-auto" @click="addFuel">Thêm nhiên liệu</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-fuels-id">
                      Id
                    </th>
                    <th class="table-fuels-name">
                      Nhiên liệu
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
            </div>
          </div>
        </div>
      </div>
      <div v-if="fuels.length > 0" class="row">
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
                          <button @click="deleteFuel" class="btn btn-danger btn-block">Xóa</button>
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
import FuelItem from './FuelItem'

export default {
  name: 'Fuel',
  components: {
    FuelItem,
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
    this.$store.dispatch('retrieveFuels', 1);
  },
  computed: {
    fuels() {
      return this.$store.getters.fuels;
    },
    pagination() {
      return this.$store.getters.fuelsPagination;
    },
    isActived() {
        return this.$store.getters.fuelsPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.fuelsPagination;
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
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveFuels', page);
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.fuels.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa nhiên liệu <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    addFuel() {
      this.$store.dispatch('retrieveFuels', this.pagination.last_page);
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
    deleteFuel() {
      this.$store.dispatch('deleteFuel', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    }
  }
}
</script>

<style>
.table-fuels-id{
  width: 5%;
}
.table-fuels-name{
  width: 70%;
}
.table-fuels-actions{
  width: 25%;
}
</style>