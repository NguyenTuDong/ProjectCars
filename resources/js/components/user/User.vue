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
            <div v-if="!users" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-users-id">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'id'), 'sort-btn-desc': (!isASC && orderBy == 'id')}" @click="toggleOrderBy('id')">Id</button>
                    </th>
                    <th class="table-users-img text-center">
                      Hình
                    </th>
                    <th class="table-users-name">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'ten'), 'sort-btn-desc': (!isASC && orderBy == 'ten')}" @click="toggleOrderBy('ten')">Tên người dùng</button>
                    </th>
                    <th class="table-users-email">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'email'), 'sort-btn-desc': (!isASC && orderBy == 'email')}" @click="toggleOrderBy('email')">Email</button>
                    </th>
                    <th class="table-users-phone">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'sdt'), 'sort-btn-desc': (!isASC && orderBy == 'sdt')}" @click="toggleOrderBy('sdt')">Số điện thoại</button>
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
      q: '',
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
          orderBy: this.orderBy,
          direction: this.isASC ? 'ASC' : 'DESC',
        }
        this.$store.dispatch('retrieveUsers', data);
      }
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
        orderBy: this.orderBy,
        direction: this.isASC ? 'ASC' : 'DESC',
      }
      this.$store.dispatch('retrieveUsers', data);
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