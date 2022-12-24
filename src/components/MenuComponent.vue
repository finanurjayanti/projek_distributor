<script setup lang="ts">
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
</script>

<script lang="ts">
interface MenuListInterface {
  text: string;
  action: Function;
}
export default {
  props: {
    menuText: String,
    menuList: Array<MenuListInterface>,
  },
};
</script>

<template>
  <Menu
    as="div"
    class="relative inline-block rounded-md bg-[#4d6bb9] w-fit h-fit p-1 pl-3 pr-3 flex items-start justify-center"
  >
    <MenuButton class="font-bold text-white">{{ menuText }}</MenuButton>
    <MenuItems
      class="absolute w-44 rounded-md bg-white/60 backdrop-blur-sm p-1 mt-10 right-0 origin-top-right ml-2 shadow-xl"
    >
      <span v-for="menu of menuList">
        <MenuItem>
          <button
            class="w-full h-4 text-left rounded-md font-bold text-[#4d6bb9] hover:bg-[#4d6bb9] hover:text-white w-full h-full"
            @click="menu.action()"
          >
            <span class="ml-2">{{ menu.text }}</span>
          </button>
        </MenuItem>
      </span>
    </MenuItems>
  </Menu>
</template>
