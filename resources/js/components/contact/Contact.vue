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
            <div v-if="!contacts" class="lds-dual-ring"></div>
            <div v-else class="card-body">
              <div class="search-form">
                <input v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th class="table-contacts-id">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'id'), 'sort-btn-desc': (!isASC && orderBy == 'id')}" @click="toggleOrderBy('id')">Id</button>
                    </th>
                    <th class="table-contacts-receive">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'users.ten'), 'sort-btn-desc': (!isASC && orderBy == 'users.ten')}" @click="toggleOrderBy('users.ten')">Người nhận</button>
                    </th>
                    <th class="table-contacts-send">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'ten'), 'sort-btn-desc': (!isASC && orderBy == 'ten')}" @click="toggleOrderBy('ten')">Người gửi</button>
                    </th>
                    <th class="table-contacts-email">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'email'), 'sort-btn-desc': (!isASC && orderBy == 'email')}" @click="toggleOrderBy('email')">Email</button>
                    </th>
                    <th class="table-contacts-phone">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'sdt'), 'sort-btn-desc': (!isASC && orderBy == 'sdt')}" @click="toggleOrderBy('sdt')">Số điện thoại</button>
                    </th>
                    <th class="table-contacts-content">
                      <button class="sort-btn" :class="{'sort-btn-asc': (isASC && orderBy == 'noidung'), 'sort-btn-desc': (!isASC && orderBy == 'noidung')}" @click="toggleOrderBy('noidung')">Nội dung</button>
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
          orderBy: this.orderBy,
          direction: this.isASC ? 'ASC' : 'DESC',
        }
        this.$store.dispatch('retrieveContacts', data);
      }
    },
    search() {
      var data = {
        page: 1,
        q: this.q,
        orderBy: this.orderBy,
        direction: this.isASC ? 'ASC' : 'DESC',
      }
      this.$store.dispatch('retrieveContacts', data);
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