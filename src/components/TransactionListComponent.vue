<script lang="ts">
export default {
  props: {
    index: Number,
    personName: String,
    fishName: String,
    type: String,
    value: String,
    price: String,
    date: String,
  },
};
</script>

<template>
  <div
    class="v-full h-max rounded-md bg-white/90 backdrop-md p-1 grid grid-cols-12"
  >
    <span
      class="font-medium col-start-1 col-span-1 flex justify-center items-center"
      ><p>{{ index }}</p></span
    >
    <span
      class="font-medium col-start-2 col-span-2 flex justify-center items-center"
      ><p>{{ personName }}</p></span
    >
    <span
      class="font-medium col-start-4 col-span-2 flex justify-center items-center"
      ><p>{{ fishName }}</p></span
    >
    <span
      class="font-medium col-start-6 col-span-2 flex justify-center items-center"
      ><p>{{ type }}</p></span
    >
    <span
      class="font-medium col-start-8 col-span-1 flex justify-center items-center"
      ><p>{{ value }}</p></span
    >

    <span
      class="font-medium col-start-9 col-span-2 flex justify-center items-center"
      ><p>{{ price }}</p></span
    >
    <span
      class="font-medium col-start-11 col-span-2 flex justify-center items-center"
      ><p>{{ date }}</p></span
    >
  </div>
</template>
