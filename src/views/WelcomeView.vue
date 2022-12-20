<script setup lang="ts">
import TopoBackgroundComponent from "@/components/TopoBackgroundComponent.vue";
</script>

<script lang="ts">
export default {
  name: "WelcomeView",
  props: {
    isSession: Boolean,
  },
};
</script>

<template>
  <TopoBackgroundComponent />
  <div class="grid grid-rows-6 grid-flow-col w-screen h-screen">
    <div class="row-start-1 row-span-3 justify-center flex">
      <div class="flex items-end justify-center">
        <span
          class="font-sans font-bold text-transparent bg-clip-text text-9xl bg-gradient-to-r from-blue-600 to-purple-600"
        >
          <Suspense>
            <p v-if="isSession">Hi.</p>
            <p v-else>Welcome.</p>
          </Suspense>
        </span>
      </div>
    </div>
    <div class="row-start-4 row-span-1 justify-center flex mt-2">
      <a v-if="isSession" href="/home" class="h-max">
        <button
          class="rounded-md backdrop-blur-sm bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
        >
          Home
        </button>
      </a>
      <a v-else href="/login" class="h-max">
        <button
          class="rounded-md backdrop-blur-sm bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
        >
          Login
        </button>
      </a>
    </div>
    <div class="row-start-5 row-span-1"></div>
  </div>
</template>
