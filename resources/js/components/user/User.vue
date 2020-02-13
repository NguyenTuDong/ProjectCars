<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Người dùng</h4>
            </div>
            <div class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-users-id">
                      Id
                    </th>
                    <th class="table-users-img text-center">
                      Hình
                    </th>
                    <th class="table-users-name">
                      Tên người dùng
                    </th>
                    <th class="table-users-email">
                      Email
                    </th>
                    <th class="table-users-phone">
                      Số điện thoại
                    </th>
                  </thead>
                  <tbody>
                    <user-item 
                      v-for="user in users" 
                      :key="user.id" 
                      :user="user"
                    >
                    </user-item>
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
  </div>
</template>

<script>
import UserItem from './UserItem'
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'User',
  components: {
    UserItem,
    Pagination,
  },
  data() {
    return {
      deleting: -1,
      offset: 3,
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
    this.$store.dispatch('retrieveUsers', data);
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      users: 'users',
      pagination: 'usersPagination',
    }),
  },
  methods: {
    getItems(page){
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) {
        var data = {
          page: page,
          q: this.q,
        }
        this.$store.dispatch('retrieveUsers', data);
      }
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveUsers', data);
    }
  }
}
</script>

<style>
.table-users-id{
  width: 5%;
}
.table-users-img{
  width: 15%;
}
.table-users-name{
  width: 40%;
}
.table-users-email{
  width: 20%;
}
.table-users-phone{
  width: 20%;
}
</style>