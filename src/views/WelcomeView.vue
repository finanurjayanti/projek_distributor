<script setup lang="ts">
import { ArrowRightCircleIcon } from "@heroicons/vue/24/solid";
</script>

<script lang="ts">
export default {
  name: "WelcomeView",
};
</script>

<template>
  <div class="grid grid-rows-6 grid-flow-col w-screen h-screen">
    <div class="row-start-1 row-span-3 justify-center flex">
      <div class="flex items-end justify-center">
        <h1
          class="font-sans font-bold text-transparent bg-clip-text text-8xl bg-gradient-to-r from-blue-600 to-pink-600"
        >
          Welcome.
        </h1>
      </div>
    </div>
    <div class="row-start-4 row-span-1 justify-center flex">
      <a href="/login" class="h-max">
        <ArrowRightCircleIcon
          class="h-8 w-8 transition-all fill-purple-800 duration-300 hover:scale-125 hover:fill-emerald-600"
        />
      </a>
    </div>
    <div class="row-start-5 row-span-1"></div>
  </div>
</template>
