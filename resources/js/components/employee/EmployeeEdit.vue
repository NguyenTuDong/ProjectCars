<template>
  <div>
    <div v-if="!loaded" class="lds-dual-ring-wrapper">
      <div class="lds-dual-ring"></div>
    </div>
    <div class="panel-header panel-header-sm"></div>
    <button @click="$router.go(-1)" class="btn-back">
      <i class="now-ui-icons arrows-1_minimal-left"></i> Trở lại
    </button>
    <div class="content">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="title">Chỉnh sửa thông tin</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-5 pr-1">
                  <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" class="form-control" placeholder="Họ và tên" v-model="newName">
                  </div>
                </div>
                <div class="col-md-3 px-1">
                  <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="tel" class="form-control" placeholder="Số điện thoại" v-model="newPhone">
                  </div>
                </div>
                <div class="col-md-4 pl-1">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" placeholder="Email" v-model="newEmail">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-8 pr-1">
                  <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" class="form-control" placeholder="Địa chỉ" v-model="newAddress">
                  </div>
                </div>
                <div class="col-md-4 pl-1">
                  <div class="form-group">
                    <label>CMND</label>
                    <input type="number" class="form-control" placeholder="Chứng minh nhân dân" v-model="newID">
                  </div>
                </div>
              </div>

              <!-- <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Giới thiệu</label>
                    <textarea rows="4" cols="80" class="form-control" placeholder="Đây sẽ là lời giới thiệu của bạn" v-model="newDescription"></textarea>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-user">
            <div class="user-cover">
              <img v-if="$root.auth.cover_path != null" :src="$root.auth.cover_path" alt="..." />
              <img :src="previewCover" alt="">
              <input @change="coverPreview" type="file" ref="newCover" value="Chọn ảnh" style="display: none">
              <button @click="showFormCover"><i class="far fa-edit"></i></button>
            </div>
            <div class="card-body">
              <div class="author">
                <div class="user-avatar border-gray">
                  <img v-if="$root.auth.avatar_path != null" :src="$root.auth.avatar_path" alt="..." />
                  <img :src="previewAvatar" alt="">
                  <input @change="avatarPreview" type="file" ref="newAvatar" value="Chọn ảnh" style="display: none">
                  <button @click="showFormAvatar"><i class="far fa-edit"></i></button>
                </div>
                
                <h5 class="title">{{$root.auth.ten}}</h5>
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
                  <span v-for="role in $root.auth.roles" :key="role.id">{{ role.ten }}</span>
                </h4>
                
                <p v-if="$root.auth.email"><a :href="'mailto:' + $root.auth.email">{{$root.auth.email}}</a></p>
                <p v-if="$root.auth.sdt"><a :href="'tel:' + $root.auth.sdt">{{$root.auth.sdt}}</a></p>
                <button v-if="isChanged" class="btn btn-primary" @click="update">Lưu</button>
                <button v-if="isChanged" class="btn btn-default" @click="cancel">Hủy</button>
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
  name: "EmployeeEdit",
  data() {
    return {
      newName: "",
      newPhone: "",
      newEmail: "",
      newAddress: "",
      newID: "",
      // newDescription: "",
      currentRoles: [],
      roles: [],
      previewAvatar: "",
      previewCover: "",
      loaded: false,
    };
  },
  watch: {
    auth(to, from) {
      this.newName = to.ten;
      this.newPhone = to.sdt;
      this.newEmail = to.email;
      this.newAddress = to.diachi;
      this.newID = to.cmnd;
      this.currentRoles.length = 0;
      this.roles.length = 0;
      to.roles.forEach(ele => {
        this.currentRoles.push(ele.id);
        this.roles.push(ele.id);
      })
      this.previewAvatar = "";
      this.previewCover = "";
      this.loaded = true;
    },
  },
  created() {
    this.$store.dispatch("allRoles");
  },
  computed: {
    auth() {
      return this.$store.getters.auth;
    },
    allRoles() {
      return this.$store.getters.allRoles;
    },
    isChanged() {
      return JSON.stringify(this.roles) !== JSON.stringify(this.currentRoles) ||
        this.newName !== this.auth.ten ||
        this.newPhone !== this.auth.sdt ||
        this.newEmail !== this.auth.email ||
        this.newAddress !== this.auth.diachi ||
        this.newID !== this.auth.cmnd ||
        this.previewAvatar !== "" ||
        this.previewCover !== ""
    }
  },
  methods: {
    update() {
      var formData = new FormData();
      formData.append("name", this.newName);
      formData.append("phone", this.newPhone);
      formData.append("email", this.newEmail);
      formData.append("address", this.newAddress);
      formData.append("cmnd", this.newID);
      formData.append("roles", JSON.stringify(this.roles));
      
      if(this.$refs.newAvatar.files[0] != null) {
        formData.append("avatar", this.$refs.newAvatar.files[0]);
      }
      if(this.$refs.newCover.files[0] != null) {
        formData.append("cover", this.$refs.newCover.files[0]);
      }
      this.$store.dispatch("updateEmployee", formData);
      this.loaded = false;
    },
    cancel() {
      this.newName = this.auth.ten;
      this.newPhone = this.auth.sdt;
      this.newEmail = this.auth.email;
      this.newAddress = this.auth.diachi;
      this.newID = this.auth.cmnd;
      
      this.previewAvatar = "";
      this.previewCover = "";

      this.currentRoles.length = 0;
      this.roles.length = 0;
      this.auth.roles.forEach(ele => {
        this.currentRoles.push(ele.id);
        this.roles.push(ele.id);
      })
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
    },
    showFormAvatar() {
      this.$refs.newAvatar.click();
    },
    avatarPreview() 
    { 
      var input = this.$refs.newAvatar;
      var self = this;

      if (input.files && input.files[0]) 
      {
          var reader = new FileReader(); 
          reader.onload = function(e) { 
              self.previewAvatar = e.target.result;
          } 
          reader.readAsDataURL(input.files[0]); 
      } 
    },
    showFormCover() {
      this.$refs.newCover.click();
    },
    coverPreview() 
    { 
      var input = this.$refs.newCover;
      var self = this;

      if (input.files && input.files[0]) 
      {
          var reader = new FileReader(); 
          reader.onload = function(e) { 
              self.previewCover = e.target.result;
          } 
          reader.readAsDataURL(input.files[0]); 
      } 
    },
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
.user-avatar{
  position: relative;
  z-index: 1;
  img{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
  }
  button{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba($color: #000000, $alpha: .5);
    border: 0;
    z-index: 1;
    opacity: 0;
    -webkit-transition: opacity 300ms ease;
    transition: opacity 300ms ease;
    font-size: 1.7rem;
    color: white;
  }
  &:hover{
    button{
      opacity: 1;
    }
  }
}
.user-cover{
  position: relative;
  img{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
  }
  button{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba($color: #000000, $alpha: .5);
    border: 0;
    z-index: 1;
    opacity: 0;
    -webkit-transition: opacity 300ms ease;
    transition: opacity 300ms ease;
    font-size: 1rem;
    color: white;
    text-align: right;
    line-height: 200px;

  }
  &:hover{
    button{
      opacity: 1;
    }
  }
}
</style>