<template>
  <div class="pop-up">
    <div class="pop-up-inner">
      <div class="pop-up-header">
        <div class="pop-up-title">Thông báo</div>
        <button @click="cancel" type="button" rel="tooltip" title="" class="btn btn-link btn-neutral" data-original-title="Remove">
          <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
      </div>
      <div class="pop-up-body" v-html="message">
      </div>
      <div class="pop-up-footer">
        <button @click="submit" class="btn btn-link btn-neutral">Xóa</button>
        <button @click="cancel" class="btn btn-link btn-neutral">Hủy</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Modal',
  props: {
    message: {
      type: String,
      required: true,
    }
  },
  data(){
    return {
      data: null,
    }
  },
  methods: {
    show(data){
      this.data = data;
      $('.pop-up').fadeIn(300);
    },
    cancel(){
      $('.pop-up').fadeOut(300);
    },
    submit() {
      this.$emit('submit', this.data);
      $('.pop-up').fadeOut(300);
    }
  }
}
</script>

<style>

</style>