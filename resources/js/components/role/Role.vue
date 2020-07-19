<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Chức vụ</h4>
              <button v-if="roles && $root.userCan('quan-ly-chuc-vu')" class="btn btn-primary ml-auto" @click="addRole">Thêm chức vụ</button>
            </div>
            <div v-if="!roles" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-roles-id">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'id'), 'sort-btn-desc': (!isASC && orderBy == 'id')}" @click="toggleOrderBy('id')">Id</button>
                    </th>
                    <th class="table-roles-name">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'ten'), 'sort-btn-desc': (!isASC && orderBy == 'ten')}" @click="toggleOrderBy('ten')">Chức vụ</button>
                    </th>
                    <th class="table-roles-slug">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'slug'), 'sort-btn-desc': (!isASC && orderBy == 'slug')}" @click="toggleOrderBy('slug')">Slug</button>
                    </th>
                    <th class="table-roles-permissions">
                      Quyền
                    </th>
                    <th class="table-roles-admins">
                      Nhân viên
                    </th>
                    <th v-if="$root.userCan('quan-ly-chuc-vu')" class="table-roles-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <role-item 
                      v-for="role in roles" 
                      :key="role.id" 
                      :role="role"
                      :editing="editing"
                      :permissions="permissions"
                      @changeEditing="changeEditing"
                      @showPopup="showPopup"
                    ></role-item>
                    <tr v-if="isAdd && $root.userCan('quan-ly-chuc-vu')">
                      <td></td>
                      <td>
                        <div class="form-group">
                          <input ref="newName" type="text" class="form-control" placeholder="Chức vụ" v-model="newName">
                        </div>
                        <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
                      </td>
                      <td>{{slug}}</td>
                      <td></td>
                      <td colspan="2" class="td-actions text-right">
                        <button @click="createRole" class="btn btn-primary my-1">Thêm chức vụ</button>
                        <button @click="isAdd = false" class="btn btn-danger my-1">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="!isAdd && $root.userCan('quan-ly-chuc-vu')" class="d-flex">
                  <button class="btn btn-primary ml-auto" @click="addRole">Thêm chức vụ</button>
                </div>
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
import RoleItem from './RoleItem'
import Modal from '../Modal';
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Role',
  components: {
    RoleItem,
    Modal,
    Pagination,
  },
  data() {
    return {
      editing: -1,
      isAdd: false,
      newName: "",
      nameError: "",
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
    this.$store.dispatch('retrieveRoles', data);
    this.$store.dispatch('retrievePermissions');
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      roles: 'roles',
      pagination: 'rolesPagination',
      permissions: 'permissions',
    }),
    slug() {
      return this.$root.changeToSlug(this.newName);
    }
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
        this.$store.dispatch('retrieveRoles', data);
      }
    },
    changeEditing(id) {
      this.editing = id;
    },
    showPopup(data){
      this.message = "Bạn có muốn xóa chức vụ <b>"+data.ten+"</b> không?";
      this.$refs.modal.show(data);
    },
    addRole() {
      var data = {
        page: this.pagination.last_page,
        q: this.q,
        orderBy: this.orderBy,
        direction: this.isASC ? 'ASC' : 'DESC',
      }
      this.$store.dispatch('retrieveRoles', data);
      this.isAdd = true;
      this.$nextTick(() => {
        this.$refs.newName.focus();
      });
    },
    createRole() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập chức vụ!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);
        formData.append("slug", this.slug);

        this.$store.dispatch('createRole', formData);
        this.newName = "";
        this.isAdd = false;
      }
    },
    submit(data) {
      this.$store.dispatch('deleteRole', data.id);
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
        orderBy: this.orderBy,
        direction: this.isASC ? 'ASC' : 'DESC',
      }
      this.$store.dispatch('retrieveRoles', data);
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
      this.$store.dispatch('retrieveRoles', data);
    }
  }
}
</script>

<style>
.table-roles-id{
  width: 5%;
}
.table-roles-name{
  width: 10%;
}
.table-roles-slug{
  width: 10%;
}
.table-roles-permissions{
  width: 45%;
}
.table-roles-admins{
  width: 10%;
}
.table-roles-actions{
  width: 20%;
}
</style>