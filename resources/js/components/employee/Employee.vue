<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Nhân viên</h4>
            </div>
            <div v-if="!employees" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-employees-id">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'id'), 'sort-btn-desc': (!isASC && orderBy == 'id')}" @click="toggleOrderBy('id')">Id</button>
                    </th>
                    <th class="table-employees-img text-center">
                      Hình
                    </th>
                    <th class="table-employees-name">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'ten'), 'sort-btn-desc': (!isASC && orderBy == 'ten')}" @click="toggleOrderBy('ten')">Tên nhân viên</button>
                    </th>
                    <th class="table-employees-roles">
                      Chức vụ
                    </th>
                    <th class="table-employees-email">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'email'), 'sort-btn-desc': (!isASC && orderBy == 'email')}" @click="toggleOrderBy('email')">Email</button>
                    </th>
                    <th class="table-employees-phone">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'sdt'), 'sort-btn-desc': (!isASC && orderBy == 'sdt')}" @click="toggleOrderBy('sdt')">Số điện thoại</button>
                    </th>
                  </thead>
                  <tbody>
                    <employee-item 
                      v-for="employee in employees" 
                      :key="employee.id" 
                      :employee="employee"
                    >
                    </employee-item>
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
import EmployeeItem from './EmployeeItem'
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Employee',
  components: {
    EmployeeItem,
    Pagination,
  },
  data() {
    return {
      deleting: -1,
      offset: 3,
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
    this.$store.dispatch('retrieveEmployees', data);
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      employees: 'employees',
      pagination: 'employeesPagination',
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
        this.$store.dispatch('retrieveEmployees', data);
      }
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
        orderBy: this.orderBy,
        direction: this.isASC ? 'ASC' : 'DESC',
      }
      this.$store.dispatch('retrieveEmployees', data);
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
      this.$store.dispatch('retrieveEmployees', data);
    }
  }
}
</script>

<style>
.table-employees-id{
  width: 5%;
}
.table-employees-img{
  width: 15%;
}
.table-employees-name{
  width: 20%;
}
.table-employees-roles{
  width: 20%;
}
.table-employees-email{
  width: 20%;
}
.table-employees-phone{
  width: 20%;
}
</style>