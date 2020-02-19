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
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
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
  width: 20%;
}
.table-cars-actions{
  width: 20%;
}
</style>