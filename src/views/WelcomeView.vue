<script setup lang="ts">
import { ArrowRightCircleIcon } from "@heroicons/vue/24/solid";
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
    <div class="row-start-4 row-span-1 justify-center flex">
      <a v-if="isSession" href="/home" class="h-max">
        <ArrowRightCircleIcon
          class="h-8 w-8 transition-all fill-emerald-600 duration-300 hover:scale-125 hover:fill-indigo-700"
        />
      </a>
      <a v-else href="/login" class="h-max">
        <ArrowRightCircleIcon
          class="h-8 w-8 transition-all fill-indigo-700 duration-300 hover:scale-125 hover:fill-emerald-600"
        />
      </a>
    </div>
    <div class="row-start-5 row-span-1"></div>
  </div>
</template>
