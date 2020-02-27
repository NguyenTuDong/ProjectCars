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
                <tr v-if="employee.permissions.length > 0">
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
                <h4 class="comma-list"><span v-for="role in employee.roles" :key="role.id">{{ role.ten }}</span></h4>
                
                <p v-if="employee.email"><a :href="'mailto:' + employee.email">{{employee.email}}</a></p>
                <p v-if="employee.sdt"><a :href="'tel:' + employee.sdt">{{employee.sdt}}</a></p>
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
      id: this.$route.params.id
    };
  },
  created() {
    this.$store.dispatch("getEmployee", this.id);
  },
  computed: {
    employee() {
      return this.$store.getters.employee;
    }
  }
};
</script>

<style lang="scss">
.permissions-table{
  td{
    vertical-align: text-top;
  }
}
</style>