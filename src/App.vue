<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
import { isSession } from "./components/Helper.vue";
</script>

<script lang="ts">
export default {
  data() {
    return {
      session: false,
    };
  },
  async created() {
    const currentPath = window.location.pathname;
    const cookies = this.$cookies.get("sessionid");

    await isSession(cookies).then((res) => {
      this.session = res;
    });

    // Redirect depends on sessions is valid or not
    if (!currentPath.match(/^\/(login)?$/)) {
      if (!cookies || !this.session) {
        this.$router.push("login");
      }
    } else if (currentPath == "/login") {
      if (this.session) {
        this.$router.push("home");
      }
    }
  },
};
</script>

<template>
  <head>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="1" />
    <link
      href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap"
      rel="stylesheet"
    />
  </head>
  <RouterView :isSession="session" />
</template>
