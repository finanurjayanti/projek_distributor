<script setup lang="ts">
import { XCircleIcon } from "@heroicons/vue/20/solid";
</script>

<template>
  <div
    class="w-5/6 h-4/6 bg-white/60 backdrop-blur-md rounded-xl shadow-xl grid grid-cols-6 grid-rows-6 ring-1 ring-white/40"
  >
    <div
      class="row-start-1 row-span-1 col-start-6 col-span-1 flex justify-end items-start"
    >
      <span class="w-6 h-6 rounded-full bg-transparent m-1">
        <XCircleIcon as="svg" class="fill-gray-700" />
      </span>
    </div>
  </div>
</template>
