<template>
  <div>
    <div class="panel-header panel-header-sm"></div>
    <button @click="$router.go(-1)" class="btn-back">
      <i class="now-ui-icons arrows-1_minimal-left"></i> Trở lại
    </button>
    <div class="content">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="title">Thông tin chi tiết</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <p><b>Ngày tạo: </b>{{user.created_at}}</p>
                </div>
                <div class="col-md-6">
                  <p><b>CMND: </b>{{user.cmnd}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <p><b>Địa chỉ: </b>{{user.diachi}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p><b>Số đăng ký kinh doanh: </b>{{user.sodkkd}}</p>
                </div>
                <div class="col-md-6">
                  <p><b>Mã số thuế: </b>{{user.mst}}</p>
                </div>
              </div>
              <div v-html="user.gioithieu"></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-user">
            <div class="user-cover">
              <img v-if="user.cover_path != null" :src="user.cover_path" alt="..." />
            </div>
            <div class="card-body">
              <div class="author">
                <div class="user-avatar border-gray">
                  <img v-if="user.avatar_path != null" :src="user.avatar_path" alt="..." />
                </div>
                
                <h5 class="title">{{user.ten}}</h5>
                <p><a :href="'mailto:' + user.email">{{user.email}}</a></p>
                <p><a :href="'tel:' + user.sdt">{{user.sdt}}</a></p>
              </div>
            </div>
            <!-- <hr /> -->
            <!-- <div class="button-container">
              <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-facebook-f"></i>
              </button>
              <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-twitter"></i>
              </button>
              <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                <i class="fab fa-google-plus-g"></i>
              </button>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "UserDetail",
  data() {
    return {
      id: this.$route.params.id
    };
  },
  created() {
    this.$store.dispatch("getUser", this.id);
  },
  computed: {
    user() {
      return this.$store.getters.user;
    }
  }
};
</script>

<style lang="scss">
.btn-back {
  position: absolute;
  top: 40px;
  left: 30px;
  background-color: transparent;
  padding: 0;
  color: white;
  border: 0;
  cursor: pointer;
  z-index: 1100;
}
.user-cover{
  height: 120px;
  overflow: hidden;
  position: relative;
  img{
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
.user-avatar{
  width: 124px;
  height: 124px;
  border: 1px solid #FFFFFF;
  position: relative;
  overflow: hidden;
  border-radius: 50%;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 15px;
  img{
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
</style>