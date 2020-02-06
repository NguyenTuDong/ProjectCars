<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Mẫu tin</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-cars-id">
                      Id
                    </th>
                    <th class="table-cars-img text-center">
                      Hình
                    </th>
                    <th class="table-cars-name">
                      Tên mẫu tin
                    </th>
                    <th class="table-cars-author">
                      Người đăng
                    </th>
                    <th class="table-cars-status">
                      Trạng thái
                    </th>
                    <th class="table-cars-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <car-item 
                      v-for="car in cars" 
                      :key="car.id" 
                      :car="car"
                      @showPopup="showPopup"
                    >
                    </car-item>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="cars !== undefined">
        <div v-if="cars.length > 0" class="row">
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
                          <button @click="deleteCar" class="btn btn-danger btn-block">Xóa</button>
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
import CarItem from './CarItem'
import { mapGetters } from 'vuex';

export default {
  name: 'Car',
  components: {
    CarItem,
  },
  data() {
    return {
      deleting: -1,
      offset: 3,
    }
  },
  created() {
    this.$store.dispatch('retrieveCars', 1);
  },
  computed: {
    ...mapGetters({
      cars: 'cars',
      pagination: 'carsPagination',
    }),
    isActived() {
        return this.$store.getters.carsPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.carsPagination;
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
      if(page <= this.pagination.last_page && page >= 1) this.$store.dispatch('retrieveCars', page);
    },
    showPopup(id){
      $('.pop-up').fadeIn(300);
      var deleting = this.cars.filter(obj => {
        return obj.id === id
      });
      var message = "Bạn có muốn xóa mẫu tin <b>"+deleting[0].ten+"</b> không?";
      $('.pop-up-body').html(message);
      this.deleting = id;
    },
    closePopup(){
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    },
    deleteCar() {
      this.$store.dispatch('deleteCar', this.deleting);
      $('.pop-up').fadeOut(300);
      this.deleting = -1;
    }
  }
}
</script>

<style>
.table-cars-id{
  width: 5%;
}
.table-cars-img{
  width: 15%;
}
.table-cars-name{
  width: 40%;
}
.table-cars-author{
  width: 10%;
}
.table-cars-status{
  width: 10%;
}
.table-cars-actions{
  width: 20%;
}
</style>