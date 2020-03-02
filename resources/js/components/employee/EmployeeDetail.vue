<template>
  <div>
    <div class="panel-header panel-header-sm"></div>
    <button @click="$router.go(-1)" class="btn-back">
      <i class="now-ui-icons arrows-1_minimal-left"></i> Trở lại
    </button>
    <div class="content">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="title">Thông tin chi tiết</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <p><b>Ngày tạo: </b>{{employee.created_at}}</p>
                </div>
                <div class="col-md-6">
                  <p><b>CMND: </b>{{employee.cmnd}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <p><b>Địa chỉ: </b>{{employee.diachi}}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h5 class="title">Quyền</h5>
            </div>
            <div class="card-body">
              <table class="permissions-table">
                <tr v-for="role in employee.roles" :key="role.id">
                  <td v-if="employee.roles.length > 0">{{ role.ten }}:</td>
                  <td class="blocks" v-if="employee.roles.length > 0">
                    <span v-for="permission in role.permissions" :key="permission.id">
                      {{ permission.ten }}
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Khác: 
                  </td>
                  <td class="blocks">
                    <span v-for="role in employee.permissions" :key="role.id">
                      {{ permission.ten }}
                    </span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h5 class="title">Hoạt động</h5>
            </div>
            <div class="card-body">
              
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-user">
            <div class="user-cover">
              <img v-if="employee.cover_path != null" :src="employee.cover_path" alt="..." />
            </div>
            <div class="card-body">
              <div class="author">
                <div class="user-avatar border-gray">
                  <img v-if="employee.avatar_path != null" :src="employee.avatar_path" alt="..." />
                </div>
                
                <h5 class="title">{{employee.ten}}</h5>
                <h4 class="comma-list" v-if="$root.userCan('phan-quyen')">
                  <select class="select-role" v-for="(r, index) in roles" :key="index" :ref="'role-'+index" @change="changeRole(index, r)">
                    <option v-if="roles.length > 1" value="remove">Không</option>
                    <option v-for="roleItem in allRoles" :key="roleItem.id" :value="roleItem.id" :selected="roleItem.id == r">{{ roleItem.ten }}</option>
                  </select>
                  <button @click="addRole" type="button" class="btn btn-primary btn-round btn-icon btn-icon-mini btn-neutral">
                      <i class="now-ui-icons ui-1_simple-add"></i>
                  </button>
                </h4>
                <h4 v-else class="comma-list">
                  <span v-for="role in employee.roles" :key="role.id">{{ role.ten }}</span>
                </h4>
                
                <p v-if="employee.email"><a :href="'mailto:' + employee.email">{{employee.email}}</a></p>
                <p v-if="employee.sdt"><a :href="'tel:' + employee.sdt">{{employee.sdt}}</a></p>
                <button v-if="JSON.stringify(roles) !== JSON.stringify(currentRoles)" class="btn btn-primary" @click="updateRole">Lưu</button>
              </div>
            </div>
            <!-- <hr /> -->
            <!-- <div class="button-container">
              <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-facebook-f"></i>
              </button>
              <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-twitter"></i>
              </button>
              <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-google-plus-g"></i>
              </button>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EmployeeDetail",
  data() {
    return {
      id: this.$route.params.id,
      currentRoles: [],
      roles: [],
    };
  },
  watch: {
    $route(to, from) {
      this.id = this.$route.params.id,
      this.$store.dispatch("getEmployee", this.id);
    },
    employee(to, from) {
      this.currentRoles.length = 0;
      this.roles.length = 0;
      to.roles.forEach(ele => {
        this.currentRoles.push(ele.id);
        this.roles.push(ele.id);
      })
    },
  },
  created() {
    this.$store.dispatch("getEmployee", this.id);
    this.$store.dispatch("allRoles");
  },
  computed: {
    employee() {
      return this.$store.getters.employee;
    },
    allRoles() {
      return this.$store.getters.allRoles;
    },
  },
  methods: {
    updateRole() {
      var formData = new FormData();
      formData.append("id", this.id);
      formData.append("roles", JSON.stringify(this.roles));
      this.$store.dispatch("updateEmployeeRoles", formData);
    },
    changeRole(index, id) {
      if(this.$refs["role-"+index][0].value == 'remove'){
        this.$delete(this.roles, index);
      } else {
        this.$set(this.roles, index, parseInt(this.$refs["role-"+index][0].value));
      }
    },
    addRole() {
      this.$set(this.roles, this.roles.length, 6);
    }
  }
};
</script>

<style lang="scss" scope>
.permissions-table{
  td{
    vertical-align: text-top;
  }
}
.select-role{
  text-align: center;
  text-align-last: center;
}
</style>