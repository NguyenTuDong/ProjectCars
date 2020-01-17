<template>
  <div>
    <slot></slot>
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex card-header">
              <h4 class="card-title">Thương hiệu</h4>
              <button class="btn btn-primary ml-auto" @click="isAdd = true">Thêm thương hiệu</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      Id
                    </th>
                    <th>
                      Logo
                    </th>
                    <th>
                      Tên thương hiệu
                    </th>
                    <th class="td-actions text-right">
                      Tác vụ
                    </th>
                  </thead>
                  <tbody>
                    <brand-item 
                      v-for="brand in brands" 
                      :key="brand.id" 
                      :brand="brand"
                      :editing="editing"
                      @changeEditing="changeEditing"
                    ></brand-item>
                    <tr v-if="isAdd">
                      <td>
                      </td>
                      <td>
                        <h6 class="text-primary my-3">Ảnh cập nhật:</h6>
                        <div>
                          <img id="preview-logo" :src="preview" alt="">
                          <button id="preview-btn" @click="showForm" class="btn btn-primary btn-block">Chọn ảnh</button>
                          <input id="preview-file" @change="imagePreview" type="file" ref="logo" value="Chọn ảnh" style="display: none">
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="Tên Thương Hiệu" :value="newName">
                        </div>
                      </td>
                      <td class="td-actions text-right">
                        <button class="btn btn-primary">Thêm thương hiệu</button>
                        <button class="btn btn-danger">Hủy</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BrandItem from './BrandItem'

export default {
  name: 'Brand',
  components: {
    BrandItem,
  },
  data() {
    return {
      editing: -1,
      isAdd: false,
      newLogo: null,
      newName: null,
      preview: null,
    }
  },
  computed: {
    brands() {
      return this.$store.getters.getBrands;
    }
  },
  methods: {
    changeEditing(id) {
      this.editing = id;
    }
  }
}
</script>

<style>

</style>