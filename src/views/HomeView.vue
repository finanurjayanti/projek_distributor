<script setup lang="ts">
import TopoBackground from "@/components/TopoBackgroundComponent.vue";
import FishList from "@/components/FishListComponent.vue";
import TransactionList from "@/components/TransactionListComponent.vue";
import axios from "axios";
</script>

<script lang="ts">
export default {
  data() {
    return {
      fishList: [
        {
          nama_ikan: "",
          harga: 0,
          stok: 0,
        },
      ],
      transactionList: [
        {
          nama_orang: "",
          nama_ikan: "",
          penjualan: 0,
          jumlah_kg: 0,
          jumlah_harga: 0,
          tanggal: "",
        },
      ],
    };
  },
  name: "HomeView",
  async mounted() {
    await this.getFishList();
    await this.getDayTransactionList();
  },
  methods: {
    async getFishList() {
      await axios.get("http://localhost/api/fish-list.php").then((res) => {
        this.fishList = res.data;
      });
    },
    async getDayTransactionList() {
      await axios
        .get("http://localhost/api/day-transactions.php")
        .then((res) => {
          this.transactionList = res.data;
        });
    },
  },
};
</script>

<template>
  <TopoBackground />
  <div class="grid grid-cols-12 grid-rows-6 w-screen h-screen">
    <div
      class="row-start-1 row-span-2 col-start-1 col-span-5 rounded-xl m-3 grid grid-cols-6 grid-rows-6"
    >
      <div
        class="row-start-1 row-span-1 col-start-1 col-span-2 m-1 flex items-center justify-start rounded-md p-2 bg-white/30 backdrop-blur-sm"
      >
        <span class="font-bold text-black text-xl"><p>Daftar Ikan</p></span>
      </div>
      <div
        class="row-start-2 row-span-5 col-start-1 col-span-6 rounded-md border-2 border-[#4d6bb9] scrollbar overflow-y-scroll p-1 flex flex-col space-y-0.5"
      >
        <span v-for="fish of fishList">
          <FishList
            :fish-name="fish.nama_ikan"
            :price="fish.harga"
            :stock="fish.stok"
          />
        </span>
      </div>
    </div>
    <div
      class="row-start-1 row-span-2 col-start-6 col-span-7 rounded-xl m-3 grid grid-cols-6 grid-rows-6"
    >
      <div
        class="row-start-1 row-span-1 col-start-1 col-span-2 m-1 flex items-center justify-start rounded-md p-2 bg-white/30 backdrop-blur-sm"
      >
        <span class="font-bold text-black text-xl"
          ><p>Transaksi Hari Ini</p></span
        >
      </div>
      <div
        class="row-start-2 row-span-5 col-start-1 col-span-6 rounded-md border-2 border-[#4d6bb9] scrollbar overflow-y-scroll p-1 flex flex-col space-y-0.5"
      >
        <span v-for="(transaction, index) in transactionList">
          <TransactionList
            :index="index + 1"
            :person-name="transaction.nama_orang"
            :fish-name="transaction.nama_ikan"
            :is-sold="transaction.penjualan"
            :value="transaction.jumlah_kg"
            :price="transaction.jumlah_harga"
            :date="transaction.tanggal"
          />
        </span>
      </div>
    </div>
    <div
      class="row-start-3 row-span-3 col-start-1 col-span-12 bg-blue-900 rounded-xl m-3 grid grid-cols-6 grid-rows-6"
    >
      <div
        class="row-start-1 row-span-1 col-start-1 col-span-3 m-1 flex items-center justify-start rounded-md p-2"
      >
        <span class="font-medium text-white"
          ><p>Rekapitulasi Pendapatan</p>
        </span>
      </div>
    </div>
  </div>
</template>
