<template>
  <tr>
    <td>
      {{contact.id}}
    </td>
    <td>
      <router-link :to="{ name: 'user-detail', params: { id: contact.users_id }}">
        <h6>{{contact.users.ten}}</h6>
      </router-link>
    </td>
    <td>
      <h6>{{contact.ten}}</h6>
    </td>
    <td>
      <a class="d-block mb-2" :href="'mailto:' + contact.email">
        {{contact.email}}
      </a>
    </td>
    <td>
      <a class="d-block mb-2" :href="'tel:' + contact.sdt">
        {{contact.sdt}}
      </a>
    </td>
    <td>
      <p>
        {{contact.noidung}}
      </p>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'ContactItem',
  props: {
    contact: {
      type: Object,
      required: true,
    }
  },
}
</script>

<style>

</style>