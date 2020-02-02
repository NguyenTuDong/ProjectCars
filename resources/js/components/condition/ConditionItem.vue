<template>
  <tr>
    <td>
      {{id}}
    </td>
    <td v-if="editing != id">
      {{ten}}
    </td>
    <td v-else>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Tình trạng" v-model="newName">
      </div>
      <span class="text-danger" v-if="nameError != ''">{{nameError}}</span>
    </td>
    <td class="td-actions text-right">
      <button v-if="editing != id" @click="edit" type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i class="now-ui-icons ui-2_settings-90"></i>
      </button>
      <button v-if="editing != id" @click="showPopup" type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-remove"></i>
      </button>
      <button v-if="editing == id" @click="updateCondition" type="button" rel="tooltip" title="" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_check"></i>
      </button>
      <button v-if="editing == id" @click="cancle" type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i class="now-ui-icons ui-1_simple-delete"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
  name: 'ConditionItem',
  props: {
    condition: {
      type: Object,
      required: true,
    },
    editing: {
      type: Number,
      required: true,
    }
  },
  data() {
    return {
      id: this.condition.id,
      ten: this.condition.ten,
      newName: this.condition.ten,
      nameError: "",
    }
  },
  methods: {
    edit() {
      this.$emit('changeEditing', this.id);
      this.newName = this.ten;
    },
    showPopup() {
      this.$emit('showPopup', this.id);
    },
    cancle() {
      this.$emit('changeEditing', -1);
    },
    updateCondition() {
      if(this.newName == ""){
        this.nameError = "Vui lòng nhập tình trạng!";
      } else {
        this.nameError = "";
      }
      
      if(this.newName != ""){
        var formData = new FormData();
        formData.append("name", this.newName);

        var data = {
          id: this.id,
          formData: formData,
        }

        this.$store.dispatch('updateCondition', data);
        this.ten = this.newName;
        this.newName = "";
        this.$emit('changeEditing', -1);
      }
    },
  }
}
</script>

<style>
</style>