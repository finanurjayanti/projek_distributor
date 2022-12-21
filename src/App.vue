<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
import { isSession } from "./components/Helper.vue";
import MainTab from "@/components/MainTabComponent.vue";
</script>

<script lang="ts">
export default {
  data() {
    return {
      session: false,
      tab: false,
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

    // Show tab menu except on / or /login
    if (!currentPath.match(/^\/(login)?$/)) {
      this.tab = true;
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
  <div v-if="tab" class="fixed bottom-5 translate-x-1/2 inset-x-0 w-6/12">
    <MainTab></MainTab>
  </div>
</template>
