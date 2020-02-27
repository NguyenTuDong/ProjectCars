<template>
  <tr>
    <td>
      {{role.id}}
    </td>
    <td v-if="editing != role.id">
      {{role.ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Chức vụ" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td>
      <div class="slug">{{role.slug}}</div>
    </td>
    <td v-if="editing != role.id">
      <div class="blocks">
        <span v-for="permission in role.permissions" :key="permission.id">{{permission.ten}}</span>
      </div>
    </td>
    <td v-else>
      <div class="blocks-edit">
        <span 
          v-for="permission in permissions" 
          :key="permission.id" 
          :class="{ 'is-selected': isSelected(permission.id) }"
          @click="togglePermission(permission.id)"
          >{{permission.ten}}</span>
      </div>
    </td>
    <td>
      <div class="admin-list">
        <div class="admin-item" v-for="admin in role.admins" :key="admin.key">
          <div class="admin-avatar" :class="{ 'is-current': admin.id == $root.auth.id }">
            <img :src="admin.avatar_path" alt="">
          </div>
          <div class="admin-info">
            <div class="admin-name">{{admin.ten}}</div>
          </div>
        </div>
      </div>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != role.id && role.slug != 'admin'" @click="edit" type="button" rel="tooltip" title="Chỉnh sửa" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons design-2_ruler-pencil"></i>
      </button>
      <button v-if="editing != role.id && role.slug != 'admin'" @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == role.id && role.slug != 'admin'" @click="updateRole" type="button" rel="tooltip" title="Xác nhận" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == role.id && role.slug != 'admin'" @click="cancle" type="button" rel="tooltip" title="Hủy" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'RoleItem',
  props: {
    role: {
      type: Object,
      required: true,
    },
    editing: {
      type: Number,
      required: true,
    },
    permissions: {
      type: Array,
      required: true,
    }
  },
  data() {
    return {
      newName: this.role.ten,
      newPermission: [],
      nameError: "",
    }
  },
  computed: {
    roles_permissions() {
      return this.role.permissions.map(function(item) {
        return item.id;
      })
    },
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.role.id);
      this.newName = this.role.ten;
    },
    isSelected(id) {
      return this.roles_permissions.includes(id);
    },
    togglePermission(id) {
      if(this.isSelected(id)){
        var index = this.roles_permissions.findIndex((obj) => {
          return obj == id;
        });
        this.roles_permissions.splice(index, 1);
      } else {
        this.roles_permissions.push(id);
      }
      this.$forceUpdate();
    },
    showPopup() {
      this.$emit('showPopup', this.role);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateRole() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập chức vụ!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);
        formData.append("permissions", JSON.stringify(this.roles_permissions));

        var data = {
          id: this.role.id,
          formData: formData,
        }

        this.$store.dispatch('updateRole', data);
        this.newName = "";
        this.$emit('changeEditing', -1);
      }
    },
  }
}
</script>

<style lang="scss">
.admin{
  &-list{
    display: flex;
    flex-wrap: wrap;
    margin-left: 25px;
  }
  &-item{
    position: relative;
    margin-left: -25px;
    &:hover {
      z-index: 1;
      .admin-avatar{
        box-shadow: 0 1px 15px 1px rgba(39, 39, 39, 0.1);
      }
      .admin-info{
        display: block;
      }
    }
  }
  &-avatar{
    width: 50px;
    height: 50px;
    border: 2px solid #e3e3e3;
    border-radius: 50%;
    overflow: hidden;
    background-color: white;
    img{
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    &.is-current{
      border-color: #2A5788;
    }
  }
  &-info{
    position: absolute;
    top: 60px;
    left: 50%;
    transform: translateX(-50%);
    background-color: white;
    padding: 20px;
    border-radius: 0.1875rem;;
    z-index: 1;
    display: none;
    box-shadow: 0 1px 15px 1px rgba(39, 39, 39, 0.1);
    width: 300px;
    text-align: center;
    &::before{
      content: '';
      display: block;
      width: 10px;
      height: 10px;
      background-color: white;
      position: absolute;
      top: -5px;
      left: 50%;
      transform: translateX(-50%) rotate(45deg);
    }
  }
}
.slug{
  color: #9a9a9a;
  font-weight: 300;
}
</style>