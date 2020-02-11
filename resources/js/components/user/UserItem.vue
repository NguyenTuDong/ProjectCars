<template>
  <tr>
    <td>
      {{user.id}}
    </td>
    <td class="text-center">
      <div class="user-avatar border-gray">
        <img v-if="user.avatar_path != null" :src="user.avatar_path" alt="..." />
      </div>
    </td>
    <td>
      <router-link :to="{ name: 'user-detail', params: { id: user.id }}">
        <h6>{{user.ten}}</h6>
      </router-link>
    </td>
    <td>
      <a :href="'mailto:' + user.email">
        {{user.email}}
      </a>
    </td>
    <td>
      <a :href="'tel:' + user.sdt">
        {{user.sdt}}
      </a>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'UserItem',
  props: {
    user: {
      type: Object,
      required: true,
    }
  },
}
</script>

<style>

</style>