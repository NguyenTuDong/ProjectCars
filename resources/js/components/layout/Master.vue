<template>
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
      <div class="logo">
        <router-link :to="{name: 'dashboard'}" class="simple-text logo-mini">
          CA
        </router-link>
        <router-link :to="{name: 'dashboard'}" class="simple-text logo-normal">
          Cars | Admin
        </router-link>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
           <router-link tag="li" :to="{name: 'dashboard'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </router-link>
          <hr class="nav-seq">
           <router-link tag="li" :to="{name: 'car'}" :class="{ 'is-disable': !$root.userCan('xem-tin') && (!$root.userCan('duyet-tin') || !$root.userCan('xoa-tin')) }">
            <a href="#">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Mẫu tin</p>
            </a>
          </router-link>
           <router-link tag="li" :to="{name: 'user'}" :class="{ 'is-disable': !$root.userCan('xem-khach-hang') }">
            <a href="#">
              <i class="now-ui-icons users_single-02"></i>
              <p>Người dùng</p>
            </a>
          </router-link>
           <router-link tag="li" :to="{name: 'contact'}" :class="{ 'is-disable': !$root.userCan('xem-lien-he') }">
            <a href="#">
              <i class="now-ui-icons ui-1_email-85"></i>
              <p>Liên hệ</p>
            </a>
          </router-link>
          <hr class="nav-seq">
          <router-link tag="li" :to="{name: 'brand'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons objects_diamond"></i>
              <p>Thương hiệu</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'type'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons shopping_tag-content"></i>
              <p>Dòng xe</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'style'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons education_glasses"></i>
              <p>Kiểu dáng</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'color'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons design_palette"></i>
              <p>Màu xe</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'condition'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons media-2_sound-wave"></i>
              <p>Tình trạng</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'origin'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons location_world"></i>
              <p>Xuất xứ</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'fuel'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons education_atom"></i>
              <p>Nhiên liệu</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'transmission'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons objects_spaceship"></i>
              <p>Hộp số</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'convenient'}" :class="{ 'is-disable': !$root.userCan('quan-ly-danh-muc') }">
            <a href="#">
              <i class="now-ui-icons ui-2_like"></i>
              <p>Tiện nghi</p>
            </a>
          </router-link>
          <hr class="nav-seq">
          <router-link tag="li" :to="{name: 'role'}" :class="{ 'is-disable': !$root.userCan('quan-ly-chuc-vu') }">
            <a href="#">
              <i class="now-ui-icons ui-2_like"></i>
              <p>Chức vụ</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'employee'}" :class="{ 'is-disable': !$root.userCan('xem-nhan-vien') }">
            <a href="#">
              <i class="now-ui-icons ui-2_like"></i>
              <p>Nhân viên</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'report'}" :class="{ 'is-disable': !$root.userCan('bao-cao') }">
            <a href="#">
              <i class="now-ui-icons ui-2_like"></i>
              <p>Báo cáo</p>
            </a>
          </router-link>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            
            <!-- <a slot-scope="props" class="navbar-brand" href="#pablo">{{props.page}}</a>
            <a class="navbar-brand" href="#pablo">sdfafd</a> -->
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <router-link :to="{name: 'employee-detail', params: { id: $root.auth.id || 1 }}" class="dropdown-item">
                    Trang cá nhân
                  </router-link>
                  <router-link :to="{name: 'employee-edit'}" class="dropdown-item">
                    Cập nhật thông tin
                  </router-link>
                  <a class="dropdown-item" :href="$root.route('admin.logout')"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      Đăng xuất
                  </a>
                  <form id="logout-form" :action="$root.route('admin.logout')" method="POST" style="display: none;">
                      <input type="hidden" name="_token" :value="csrf">
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <!-- <transition name="fade" mode="out-in"> -->
        <router-view></router-view>
      <!-- </transition> -->
      <footer class="footer">
        <div class=" container-fluid ">
          <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy;{{year}}, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by Dong Nguyen.
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Master',
  data() {
    return {
      
    }
  }, 
  watch: {
    '$route' (to, from) {
      document.title = to.meta.title || 'Admin'
    }
  },
  computed: {
    year() {
      var d = new Date();
      return d.getFullYear();
    },
    csrf() {
      return this.$store.getters.csrf;
    }
  }
}
</script>

<style lang="scss">
.lds-dual-ring {
  display: block;
  width: 80px;
  height: 80px;
  margin: 80px auto;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid #fa7a50;
  border-color: #fa7a50 transparent #fa7a50 transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.lds-dual-ring-wrapper{
  position: fixed;
  top: 0;
  right: 0;
  width: calc(100% - 260px);
  height: 100%;
  background-color: rgba($color: #fff, $alpha: .8);
  z-index: 1000;
  .lds-dual-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    margin: 0;
  }
}

.sidebar-wrapper{
  /* width */
  &::-webkit-scrollbar {
    width: 10px;
  }

  /* Track */
  &::-webkit-scrollbar-track {
    background: transparent; 
    transition: 300ms ease;
  }
  
  /* Handle */
  &::-webkit-scrollbar-thumb {
    background: rgba($color: #000, $alpha: .2);
    transition: 300ms ease;
    border-radius: 5px;

    &:hover{
    background: rgba($color: #000, $alpha: .4);
    }
  }
}
body{
  /* width */
  &::-webkit-scrollbar {
    width: 10px;
  }

  /* Track */
  &::-webkit-scrollbar-track {
    background: transparent; 
    transition: 300ms ease;
  }
  
  /* Handle */
  &::-webkit-scrollbar-thumb {
    background: rgba($color: #000, $alpha: .2);
    transition: 300ms ease;
    border-radius: 5px;

    &:hover{
    background: rgba($color: #000, $alpha: .4);
    }
  }
}
.nav{
  .is-disable{
    opacity: .5;
    pointer-events: none;
  }
}
.nav-seq{
  width: calc(100% - 30px);
  margin-left: auto;
  margin-right: auto;
  border-color: rgba(255, 255, 255, 0.5);;
}
.card-select{
  min-width: 200px;
}
.search-form{
  display: flex;
  margin-bottom: 10px;
  input{
    width: 200px;
    margin-left: auto;
  }
}
.table .form-group{
  margin-bottom: 0;
}
.records-ratio{
  display: inline-block;
  width: 0;
  height: 10px;
  background-color: #fa7a50;
  margin-right: 30px;
}
.blocks {
  font-size: 0;
  margin: 0 -2px;
  span{
    display: inline-block;
    background-color: #eee;
    font-size: 11px;
    color: #2A5788;
    padding: 4px 8px;
    margin: 4px;
    font-weight: 600;
    letter-spacing: .7px;
    border-radius: 3px;
  }
}
.blocks-edit {
  font-size: 0;
  margin: 0 -2px;
  span{
    display: inline-block;
    background-color: #eee;
    font-size: 11px;
    color: gray;
    padding: 4px 8px;
    margin: 4px;
    font-weight: 600;
    letter-spacing: .7px;
    border-radius: 3px;
    cursor: pointer;
    &.is-selected{
      color: #2A5788;
    }
  }
}
.comma-list{
  span:not(:last-child){
    &::after{
      content: ',';
    }
  }
}
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
.sort-btn{
  background-color: transparent;
  border: 0;
  padding: 0;
  color: #f96332;
  font-weight: bold;
  &:focus{
    outline: none;
  }
  &-asc{
    &::after{
      content: ' 🡅';
      color: #dbdbdb;
    }
  }
  &-desc{
    &::after{
      content: ' 🡇';
      color: #dbdbdb;
    }
  }
}
</style>