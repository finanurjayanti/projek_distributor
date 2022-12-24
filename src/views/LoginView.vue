<script setup lang="ts">
import { login as loginApi } from "@/components/Helper.vue";
import TopoBackground from "@/components/TopoBackgroundComponent.vue";
import Spinner from "@/components/SpinnerComponent.vue";
</script>

<script lang="ts">
export default {
  name: "HomeView",
  data() {
    return {
      isLogin: false,
      isOnFetch: false,
      username: "",
      password: "",
    };
  },
  props: {
    isSession: Boolean,
  },
  methods: {
    async login() {
      this.isOnFetch = true;
      await loginApi(this.username, this.password)
        .then((res) => {
          if (res) {
            this.$cookies.set("sessionid", res);
            location.href = "/home";
          }
        })
        // @ts-ignore
        .finally(() => {
          this.isOnFetch = false;
        });
    },
  },
};
</script>

<template>
  <TopoBackground />
  <div class="row-start-1 row-span-1">
    <div class="grid grid-rows-6 grid-cols-4 grid-flow-col w-screen h-screen">
      <div
        class="group grid grid-rows-6 grid-cols-4 row-start-2 row-span-4 col-start-2 col-span-2 justify-center bg-white/40 flex rounded-3xl shadow-2xl backdrop-blur-sm"
      >
        <div
          class="row-start-1 row-span-2 col-start-2 col-span-2 flex items-center justify-center"
        >
          <span class="flex items-center justify-center">
            <p
              class="font-bold text-8xl text-[#4d6bb9] group-hover:text-emerald-600 transition-all duration-1000"
            >
              Login
            </p>
          </span>
        </div>
        <div
          class="row-start-2 row-span-4 col-start-2 col-span-2 flex items-center justify-center"
        >
          <span class="flex flex-col space-y-4 items-center justify-center">
            <input
              v-model="username"
              type="username"
              placeholder="Username"
              class="form-input px-4 py-3 rounded-full text-gray-800 placeholder:italic placeholder:text-slate-400" />
            <input
              v-model="password"
              type="password"
              placeholder="Password"
              class="form-input px-4 py-3 rounded-full text-gray-800 placeholder:italic placeholder:text-slate-400"
          /></span>
        </div>
        <div
          class="row-start-5 row-span-1 col-start-2 col-span-2 flex items-center justify-center"
        >
          <span
            ><div>
              <button
                @click="login()"
                :disabled="isOnFetch"
                type="button"
                class="rounded-md backdrop-blur-sm bg-black/40 px-5 py-2 text-sm font-medium text-white hover:bg-black/50"
              >
                <Spinner v-if="isOnFetch" />
                <span class="font-bold">Submit</span>
              </button>
            </div></span
          >
        </div>
        <div
          class="row-start-6 row-span-1 col-start-2 col-span-2 flex items-start justify-center"
        >
          <p class="italic text-grey-900">
            Contact admin to register new account
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
