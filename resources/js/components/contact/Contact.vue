<template>
  <div>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Liên hệ</h4>
            </div>
            <div class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-contacts-id">
                      Id
                    </th>
                    <th class="table-contacts-receive">
                      Người nhận
                    </th>
                    <th class="table-contacts-send">
                      Người gửi
                    </th>
                    <th class="table-contacts-email">
                      Email
                    </th>
                    <th class="table-contacts-phone">
                      Số điện thoại
                    </th>
                    <th class="table-contacts-content">
                      Nội dung
                    </th>
                  </thead>
                  <tbody>
                    <contact-item 
                      v-for="contact in contacts" 
                      :key="contact.id" 
                      :contact="contact"
                    >
                    </contact-item>
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
import ContactItem from './ContactItem'
import Pagination from '../Pagination';
import { mapGetters } from 'vuex';

export default {
  name: 'Contact',
  components: {
    ContactItem,
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
    this.$store.dispatch('retrieveContacts', data);
    this.debouncedGetQuery = _.debounce(this.search, 500);
  },
  computed: {
    ...mapGetters({
      contacts: 'contacts',
      pagination: 'contactsPagination',
    }),
  },
  methods: {
    getItems(page){
      if(!this.isAdd && page <= this.pagination.last_page && page >= 1) {
        var data = {
          page: page,
          q: this.q,
        }
        this.$store.dispatch('retrieveContacts', data);
      }
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
      }
      this.$store.dispatch('retrieveContacts', data);
    }
  }
}
</script>

<style>
.table-contacts-id{
  width: 5%;
}
.table-contacts-receive{
  width: 20%;
}
.table-contacts-name{
  width: 20%;
}
.table-contacts-email{
  width: 15%;
}
.table-contacts-phone{
  width: 15%;
}
.table-contacts-content{
  width: 25%;
}
</style>