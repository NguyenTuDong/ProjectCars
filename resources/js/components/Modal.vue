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

<style lang="scss" scoped>
.pop-up{
  position: fixed;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(39, 39, 39, 0.2);
  display: none;
  z-index: 9999;
}
.pop-up-inner{
  position: absolute;
  top: 50%;
  right: 50%;
  transform: translate(50%, -50%);
  width: 500px;
  background-color: #f96332;
  color: #fff;
  box-shadow: 0 10px 50px 0 rgba(0,0,0,.5);
  z-index: 1;
}
.pop-up-header{
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
}
.pop-up-title{
  font-size: 1rem;
  font-weight: bold;
}
.pop-up-body{
  padding: 30px 20px;
  text-align: center;
}
.pop-up-footer{
  padding: 16px 24px;
  display: flex;
  justify-content: space-around;

  button{
    margin: 0;
  }

  button:first-child{
    opacity: .5;
  }
}
</style>