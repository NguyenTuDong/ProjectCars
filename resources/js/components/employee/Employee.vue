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
            <div class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-employees-id">
                      Id
                    </th>
                    <th class="table-employees-img text-center">
                      Hình
                    </th>
                    <th class="table-employees-name">
                      Tên nhân viên
                    </th>
                    <th class="table-employees-roles">
                      Chức vụ
                    </th>
                    <th class="table-employees-email">
                      Email
                    </th>
                    <th class="table-employees-phone">
                      Số điện thoại
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
        }
        this.$store.dispatch('retrieveEmployees', data);
      }
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
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