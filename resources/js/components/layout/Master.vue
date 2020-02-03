<template>
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          CT
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Creative Tim
        </a>
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
          <router-link tag="li" :to="{name: 'brand'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Thương hiệu</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'type'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Dòng xe</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'style'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Kiểu dáng</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'color'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Màu xe</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'condition'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Tình trạng</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'origin'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Nguồn gốc</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'fuel'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Nhiên liệu</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'transmission'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Hộp số</p>
            </a>
          </router-link>
          <router-link tag="li" :to="{name: 'convenient'}">
            <a href="#">
              <i class="now-ui-icons design_app"></i>
              <p>Tiện nghi</p>
            </a>
          </router-link>
          <hr class="nav-seq">
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
                  <a class="dropdown-item" :href="route('admin.logout')"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      Đăng xuất
                  </a>
                  <form id="logout-form" :action="route('admin.logout')" method="POST" style="display: none;">
                      <input type="hidden" name="_token" :value="csrf">
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <router-view></router-view>
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
  props: ['routes'],
  data() {
    return {
      
    }
  }, 
  watch: {
    '$route' (to, from) {
      document.title = to.meta.title || 'Admin'
    }
  },
  created() {
    this.$store.dispatch('setRoutes', JSON.parse(this.routes));
  },
  computed: {
    csrf() {
      return this.$store.state.csrf;
    },
    year() {
      var d = new Date();
      return d.getFullYear();
    }
  },
  methods: {
    route(name) {
      return this.$store.getters.route(name);
    }
  }
}
</script>

<style>
.nav-seq{
  width: calc(100% - 30px);
  margin-left: auto;
  margin-right: auto;
  border-color: rgba(255, 255, 255, 0.5);;
}
.card-select{
  min-width: 200px;
}
.preview-btn{
  width: 150px;
}
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
  background-color: white;
  box-shadow: 0 1px 15px 10px rgba(39, 39, 39, 0.1);
  z-index: 1;
}
.pop-up-header{
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
}
.pop-up-header .btn{
  height: 20px;
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
  padding: 20px;
}
.pagination {
  margin: 5px auto;
}
.pagination li.active a{
  text-decoration: underline;
  font-weight: bold;
}
.pagination li a{
  display: block;
  padding: 5px 15px;
  margin: 0 -0.5px;
}
</style>