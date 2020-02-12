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
                <input @keyup="search" v-model="q" type="text" class="form-control" placeholder="Tìm kiếm">
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
            </div>
          </div>
        </div>
      </div>
      <div v-if="contacts !== undefined">
        <div v-if="contacts.length > 0" class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- Pagination -->
              <nav class="d-flex">
                <ul class="mx-auto pagination">
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                    <a href="#" aria-label="Previous"
                        @click.prevent="getItems(1)">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                    <a href="#" aria-label="Previous"
                        @click.prevent="getItems(pagination.current_page - 1)">
                        <span aria-hidden="true"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                    </a>
                  </li>
                  <li v-for="(page, id) in pagesNumber" :class="[ page == isActived ? 'active' : '']" :key="id">
                      <a v-if="page == '...'" href="#">{{ page }}</a>
                      <a v-else href="#" @click.prevent="getItems(page)">{{ page }}</a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(pagination.current_page + 1)">
                          <span aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                      </a>
                  </li>
                  <li v-if="pagination.last_page > (offset * 2 + 1)">
                      <a href="#" aria-label="Next" @click.prevent="getItems(pagination.last_page)">
                          <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                      </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ContactItem from './ContactItem'
import { mapGetters } from 'vuex';

export default {
  name: 'Contact',
  components: {
    ContactItem,
  },
  data() {
    return {
      deleting: -1,
      offset: 3,
      q: '',
    }
  },
  created() {
    var data = {
      page: 1,
      q: '',
    }
    this.$store.dispatch('retrieveContacts', data);
  },
  computed: {
    ...mapGetters({
      contacts: 'contacts',
      pagination: 'contactsPagination',
    }),
    isActived() {
        return this.$store.getters.contactsPagination.current_page;
    },
    pagesNumber() {
      var pagination = this.$store.getters.contactsPagination;
      var offset = this.offset;
      if (!pagination.to) {
        return [];
      }
      var from = pagination.current_page - offset;
      if (from > pagination.last_page - (offset * 2)){
        from = pagination.last_page - (offset * 2);
      }
      if (from < 1) {
        from = 1;
      }
      var to = from + (offset * 2);
      if (to >= pagination.last_page) {
        to = pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        if(to < pagination.last_page){
          if(from == to) pagesArray.push(pagination.last_page);
          else if(from == to - 1) pagesArray.push('...');
          else pagesArray.push(from);
        } else {
          pagesArray.push(from);
        }
        from++;
      }
      return pagesArray;
    }
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