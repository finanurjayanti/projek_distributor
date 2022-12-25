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
    class="group relative rounded-md bg-[#4d6bb9] w-fit h-fit p-1 pl-3 pr-3 flex items-start justify-center hover:bg-white transition-all duration-100"
  >
    <MenuButton class="font-bold text-white group-hover:text-[#4d6bb9]">{{
      menuText
    }}</MenuButton>
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        class="absolute w-44 rounded-md bg-white/60 p-1 mt-10 right-0 origin-top-right ml-2 shadow-xl"
      >
        <span v-for="menu of menuList">
          <MenuItem>
            <button
              class="w-full h-full text-left rounded-md backdrop-blur-sm font-bold text-[#4d6bb9] hover:bg-[#4d6bb9] hover:text-white"
              @click="menu.action()"
            >
              <span class="ml-2">{{ menu.text }}</span>
            </button>
          </MenuItem>
        </span>
      </MenuItems>
    </transition>
  </Menu>
</template>
