<script setup lang="ts">
import { TabGroup, TabList, Tab } from "@headlessui/vue";
</script>

<script lang="ts">
export default {
  methods: {
    changeTab(index: number) {
      this.$router.push(tabList[index].route);
    },
  },
};

const tabList = [
  {
    name: "Home",
    route: "home",
  },
  {
    name: "Transaction",
    route: "transaction",
  },
  {
    name: "Logout",
    route: "logout",
  },
];
</script>

<template>
  <TabGroup @change="changeTab">
    <TabList
      class="flex space-x-1 rounded-xl bg-black/10 p-1 backdrop-blur-sm shadow-xl transition-all duration-200"
    >
      <Tab
        v-for="tab of tabList"
        as="template"
        :key="tab.name"
        v-slot="{ selected }"
      >
        <button
          :class="[
            'w-full rounded-lg py-2.5 text-sm font-bold leading-5 text-blue-700',
            'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
            selected
              ? 'bg-white shadow'
              : 'text-gray-700 hover:bg-white/[0.12] hover:text-emerald-600',
          ]"
        >
          {{ tab.name }}
        </button>
      </Tab>
    </TabList>
  </TabGroup>
</template>
