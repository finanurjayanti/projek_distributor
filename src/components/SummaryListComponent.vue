<script lang="ts">
export default {
  props: {
    month: String,
    profit: String,
    value: String,
  },
};
</script>

<template>
  <div
    class="v-full h-max rounded-md bg-white/90 backdrop-md p-1 grid grid-cols-3"
  >
    <span
      class="font-medium col-start-1 col-span-1 flex justify-center items-center"
      ><p>{{ month }}</p></span
    >
    <span
      class="font-medium col-start-2 col-span-1 flex justify-center items-center"
      ><p>{{ value }}</p></span
    >
    <span
      class="font-medium col-start-3 col-span-1 flex justify-center items-center"
      ><p>{{ profit }}</p></span
    >
  </div>
</template>
