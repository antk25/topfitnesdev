<!-- Vue component -->
<template>
  <div>
    <multiselect v-model="value" :options="options"></multiselect>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

// register globally
// Vue.component("multiselect", Multiselect);

export default {
  // OR register locally
  components: { Multiselect },
  data() {
    return {
      value: null,
      options: ["list", "of", "options"],
    };
  },
};
</script>