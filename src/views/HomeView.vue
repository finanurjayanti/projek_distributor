<script setup lang="ts">
import { isSession } from "@/components/Helper.vue";
</script>

<script lang="ts">
export default {
  name: "HomeView",
  async mounted() {
    if (!(await isSession(this.$cookies.get("sessionid")))) {
      this.$router.push("login");
    }
  },
};
</script>

<template><p>Home</p></template>
