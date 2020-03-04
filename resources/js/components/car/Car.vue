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
            <div v-if="!cars" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form" v-if="$root.userCan('xem-tin')">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-cars-id">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'id'), 'sort-btn-desc': (!isASC && orderBy == 'id')}" @click="toggleOrderBy('id')">Id</button>
                    </th>
                    <th class="table-cars-img text-center">
                      Hình
                    </th>
                    <th class="table-cars-name">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'ten'), 'sort-btn-desc': (!isASC && orderBy == 'ten')}" @click="toggleOrderBy('ten')">Tên mẫu tin</button>
                    </th>
                    <th class="table-cars-author">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'users.ten'), 'sort-btn-desc': (!isASC && orderBy == 'users.ten')}" @click="toggleOrderBy('users.ten')">Người đăng</button>
                    </th>
                    <th class="table-cars-status">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'trangthai'), 'sort-btn-desc': (!isASC && orderBy == 'trangthai')}" @click="toggleOrderBy('trangthai')">Trạng thái</button>
                    </th>
                    <th class="table-cars-actions text-right" v-if="$root.userCan('duyet-tin') || $root.userCan('xoa-tin')">
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
import CarItem from './CarItem';
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Car',
  components: {
    CarItem,
    Modal,
    Pagination,
  },
  data() {
    return {
      q: '',
      message: '',
      orderBy: '',
      isASC: false,
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
      orderBy: 'created_at',
      direction: 'DESC',
    }
    this.$store.dispatch('retrieveCars', data)
    this.debouncedGetQuery = _.debounce(this.search, 500)
  },
  computed: {
    ...mapGetters({
      cars: 'cars',
      pagination: 'carsPagination',
    }),
  },
  methods: {
    getItems(page){
      if(page <= this.pagination.last_page && page >= 1) {
        var data = {
          page: page,
          q: this.q,
          orderBy: this.orderBy,
          direction: this.isASC ? 'ASC' : 'DESC',
        }
        this.$store.dispatch('retrieveCars', data);
      }
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa mẫu tin <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    submit(data) {
      this.$store.dispatch('deleteCar', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
        orderBy: this.orderBy,
        direction: this.isASC ? 'ASC' : 'DESC',
      }
      this.$store.dispatch('retrieveCars', data);
    },
    toggleOrderBy(column){
      if(this.orderBy == column){
        this.isASC = !this.isASC;
      } else {
        this.orderBy = column;
        this.isASC = true;
      }
      var data = {
        page: this.pagination.current_page,
        q: this.q,
        orderBy: this.orderBy,
        direction: this.isASC ? 'ASC' : 'DESC',
      }
      this.$store.dispatch('retrieveCars', data);
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
  width: 15%;
}
.table-cars-status{
  width: 10%;
}
.table-cars-actions{
  width: 15%;
}
</style>