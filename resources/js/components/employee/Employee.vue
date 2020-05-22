<template>
  <div>
    <div class="panel-header panel-header-sm"></div>
    <div id="add-employee" class="pop-up" v-if="$root.userCan('them-nhan-vien')">
      <div class="pop-up-inner">
        <div class="pop-up-header">
          <div class="pop-up-title">Thêm nhân viên</div>
          <button
            @click="cancel"
            type="button"
            rel="tooltip"
            title
            class="btn btn-neutral"
            data-original-title="Remove"
          >
            <i class="now-ui-icons ui-1_simple-remove"></i>
          </button>
        </div>
        <div id="form-valid" class="pop-up-body">
          <div class="row">
            <label class="col-md-3 col-form-label">Username</label>
            <div class="col-md-9">
              <div class="form-group valid">
                <input type="text" class="form-control" v-model="newName"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-md-3 col-form-label">Email</label>
            <div class="col-md-9">
              <div class="form-group valid">
                <input type="email" class="form-control" v-model="newEmail" email="true"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-md-3 col-form-label">Password</label>
            <div class="col-md-9">
              <div class="form-group valid">
                <input id="registerPassword" type="password" class="form-control" v-model="newPassword" minlength="8"/>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-md-3 col-form-label">Confirm Password</label>
            <div class="col-md-9">
              <div class="form-group valid">
                <input id="registerPasswordConfirmation" type="password" class="form-control" v-model="confirmation" equalTo="#registerPassword"/>
              </div>
            </div>
          </div>
        </div>
        <div class="pop-up-footer">
          <button @click="submit" class="btn btn-neutral">Thêm</button>
          <button @click="cancel" class="btn btn-neutral">Hủy</button>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Nhân viên</h4>
              <button
                v-if="employees && $root.userCan('them-nhan-vien')"
                class="btn btn-primary ml-auto"
                @click="addEmployee"
              >Thêm nhân viên</button>
            </div>
            <div v-if="!employees" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm" />
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class="text-primary">
                    <th class="table-employees-id">
                      <button
                        class="sort-btn"
                        :class="{'sort-btn-asc': (isASC && orderBy == 'id'), 'sort-btn-desc': (!isASC && orderBy == 'id')}"
                        @click="toggleOrderBy('id')"
                      >Id</button>
                    </th>
                    <th class="table-employees-img text-center">Hình</th>
                    <th class="table-employees-name">
                      <button
                        class="sort-btn"
                        :class="{'sort-btn-asc': (isASC && orderBy == 'ten'), 'sort-btn-desc': (!isASC && orderBy == 'ten')}"
                        @click="toggleOrderBy('ten')"
                      >Tên nhân viên</button>
                    </th>
                    <th class="table-employees-roles">Chức vụ</th>
                    <th class="table-employees-email">
                      <button
                        class="sort-btn"
                        :class="{'sort-btn-asc': (isASC && orderBy == 'email'), 'sort-btn-desc': (!isASC && orderBy == 'email')}"
                        @click="toggleOrderBy('email')"
                      >Email</button>
                    </th>
                    <th class="table-employees-phone">
                      <button
                        class="sort-btn"
                        :class="{'sort-btn-asc': (isASC && orderBy == 'sdt'), 'sort-btn-desc': (!isASC && orderBy == 'sdt')}"
                        @click="toggleOrderBy('sdt')"
                      >Số điện thoại</button>
                    </th>
                    <th v-if="$root.userCan('xoa-nhan-vien')" class="table-employees-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <employee-item
                      v-for="employee in employees"
                      :key="employee.id"
                      :employee="employee"
                      @showPopup="showPopup"
                    ></employee-item>
                  </tbody>
                </table>
                <div class="d-flex" v-if="$root.userCan('them-nhan-vien')">
                  <button class="btn btn-primary ml-auto" @click="addEmployee">Thêm nhân viên</button>
                </div>
              </div>
              <pagination :pagination="pagination" :getItems="getItems"></pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <modal
      ref="modal"
      :message="message"
      @submit="deleteEmployee"
    ></modal>
  </div>
</template>

<script>
import EmployeeItem from './EmployeeItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Employee',
  components: {
    EmployeeItem,
    Modal,
    Pagination,
  },
  data() {
    return {
      newName: '',
      newEmail: '',
      newPassword: '',
      confirmation: '',
      message: '',
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
  mounted() {
    this.$root.validation('#form-valid');
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
    addEmployee() {
      $('#add-employee').fadeIn(300);
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa nhân viên <b>"+data.ten+"</b> không?";
      console.log(this.message);
      this.$refs.modal.show(data);
    },
    cancel(){
      $('#add-employee').fadeOut(300);
      this.newName = "";
      this.newEmail = "";
      this.newPassword = "";
      this.confirmation = "";
    },
    submit() {
      if(this.$root.validation('#form-valid')){
        var formData = new FormData();
        formData.append("name", this.newName);
        formData.append("email", this.newEmail);
        formData.append("password", this.newPassword);

        this.$store.dispatch('createEmployee', formData);
        this.newName = "";
        this.newEmail = "";
        this.newPassword = "";
        this.confirmation = "";
        $('.pop-up').fadeOut(300);
      }
    },
    deleteEmployee(data) {
      this.$store.dispatch('deleteEmployee', data.id);
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

<style lang="scss" scoped>
.table-employees-id {
  width: 5%;
}
.table-employees-img {
  width: 15%;
}
.table-employees-name {
  width: 20%;
}
.table-employees-roles {
  width: 20%;
}
.table-employees-email {
  width: 20%;
}
.table-employees-phone {
  width: 15%;
}
.table-employees-actions {
  width: 5%;
}

.pop-up {
  position: fixed;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(39, 39, 39, 0.2);
  display: none;
  z-index: 9999;
}
.pop-up-inner {
  position: absolute;
  top: 50%;
  right: 50%;
  transform: translate(50%, -50%);
  width: 700px;
  background-color: #fff;
  box-shadow: 0 10px 50px 0 rgba(0, 0, 0, 0.5);
  z-index: 1;
}
.pop-up-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
}
.pop-up-title {
  font-size: 1rem;
  font-weight: bold;
}
.pop-up-body {
  padding: 30px 20px;
}
.pop-up-footer {
  padding: 16px 24px;
  display: flex;
  justify-content: space-around;

  button {
    margin: 0;
  }

  button:last-child {
    opacity: 0.5;
  }
}

.col-form-label{
  text-align: right;
}
</style>