<template>
  <tr>
    <td>
      {{employee.id}}
    </td>
    <td class="text-center">
      <div class="user-avatar mb-0">
        <img v-if="employee.avatar_path != null" :src="employee.avatar_path" alt="..." />
      </div>
    </td>
    <td>
      <router-link :to="{ name: 'employee-detail', params: { id: employee.id }}">
        <h6>{{employee.ten}}</h6>
      </router-link>
    </td>
    <td class="comma-list">
      <span v-for="role in employee.roles" :key="role.id">{{ role.ten }}</span>
    </td>
    <td>
      <a :href="'mailto:' + employee.email">
        {{employee.email}}
      </a>
    </td>
    <td>
      <a :href="'tel:' + employee.sdt">
        {{employee.sdt}}
      </a>
    </td>
    <td v-if="$root.userCan('xoa-nhan-vien')" class="td-actions text-right">
      <button @click="showPopup" type="button" rel="tooltip" title="Xóa" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'EmployeeItem',
  props: {
    employee: {
      type: Object,
      required: true,
    }
  },
  methods: {
    showPopup() {
      this.$emit('showPopup', this.employee);
    },
  }
}
</script>

<style>

</style>