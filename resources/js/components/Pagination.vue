<template>
  <div class="row align-items-center" v-if="pagination.total > 0">
    <div class="col-md-6">
      Hiển thị {{pagination.from}} đến {{pagination.to}} trong số {{pagination.total}} mục
    </div>
    <div class="col md-6" v-if="pagination.last_page > 1">
      <nav>
        <ul class="pagination-custom text-right">
          <li :class="[ isActived == 1 ? 'disabled' : '']">
            <a href="#" aria-label="Previous"
                @click.prevent="getItems(1)">
                <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
            </a>
          </li>
          <li :class="[ isActived == 1 ? 'disabled' : '']">
            <a href="#" aria-label="Previous"
                @click.prevent="getItems(pagination.current_page - 1)">
                <span aria-hidden="true"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
            </a>
          </li>
          <li v-for="(page, id) in pagesNumber" :class="[ page == isActived ? 'active' : '']" :key="id">
              <a v-if="page == '...'">{{ page }}</a>
              <a v-else href="#" @click.prevent="getItems(page)">{{ page }}</a>
          </li>
          <li :class="[ isActived == pagination.last_page ? 'disabled' : '']">
              <a href="#" aria-label="Next" @click.prevent="getItems(pagination.current_page + 1)">
                  <span aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
              </a>
          </li>
          <li :class="[ isActived == pagination.last_page ? 'disabled' : '']">
              <a href="#" aria-label="Next" @click.prevent="getItems(pagination.last_page)">
                  <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
              </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Pagination',
  props: {
    pagination: {
      type: Object,
      required: true,
    },
    getItems: {
      type: Function,
      required: true,
    }
  },
  data(){
    return {
      offset: 3,
    }
  },
  computed: {
    isActived() {
        return this.pagination.current_page;
    },
    pagesNumber() {
      var offset = this.offset;
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - offset;
      if (from > this.pagination.last_page - (offset * 2)){
        from = this.pagination.last_page - (offset * 2);
      }
      if (from < 1) {
        from = 1;
      }
      var to = from + (offset * 2);
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        if(to < this.pagination.last_page){
          if(from == to) pagesArray.push(this.pagination.last_page);
          else if(from == to - 1) pagesArray.push('...');
          else pagesArray.push(from);
        } else {
          pagesArray.push(from);
        }
        from++;
      }
      return pagesArray;
    },
  }
}
</script>

<style lang="scss">
.pagination-custom {
  li {
    display: inline-block;
    &.active a{
      box-shadow: 0 1px 15px 1px rgba(39,39,39,.1);
      background-color: #f96332;
      border-color: #f96332;
      color: #fff;
    }
    &.disabled{
      opacity: .5;
      pointer-events: none;
    }
  }
  a{
    display: block;
    border: 0;
    border-radius: 30px;
    transition: all .3s;
    padding: 0 11px;
    margin: 0 3px;
    min-width: 30px;
    text-align: center;
    height: 30px;
    line-height: 30px;
    color: #2c2c2c;
    cursor: pointer;
    font-size: 14px;
    text-transform: uppercase;
    background: transparent;
    outline: none;
    &:hover{
      text-decoration: none;
      background-color: hsla(0,0%,87%,.3);
    }
  }
}
</style>