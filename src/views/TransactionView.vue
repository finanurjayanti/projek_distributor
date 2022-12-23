<script setup lang="ts">
import TopoBackground from "@/components/TopoBackgroundComponent.vue";
import TransactionList from "@/components/TransactionListComponent.vue";
import { intToIdr } from "@/components/Helper.vue";
import axios from "axios";
</script>

<script lang="ts">
export default {
  data() {
    return {
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
    this.getSummaryTransactionList();
  },
  methods: {
    async getSummaryTransactionList() {
      await axios.get("http://localhost/api/transactions.php").then((res) => {
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
      class="row-start-1 row-span-5 col-start-1 col-span-12 rounded-xl m-2 bg-white/20 backdrop-blur-md shadow-xl border-4 border-[#4d6bb9] p-1 flex flex-col space-y-1"
    >
      <span class="overflow-y-scroll scrollbar">
        <TransactionList
          :index="0"
          person-name="Nama"
          fish-name="Nama Ikan"
          type="Tipe"
          value="Jumlah"
          price="Harga"
          date="Tanggal"
        />
      </span>
      <div class="overflow-y-scroll scrollbar flex flex-col space-y-0.5">
        <span v-for="(transaction, index) in transactionList">
          <TransactionList
            :index="index + 1"
            :person-name="transaction.nama_orang"
            :fish-name="transaction.nama_ikan"
            :type="transaction.penjualan ? 'Penjualan' : 'Pembelian'"
            :value="`${transaction.jumlah_kg} Kg`"
            :price="`${intToIdr(transaction.jumlah_harga)}`"
            :date="transaction.tanggal"
          />
        </span>
      </div>
    </div>
  </div>
</template>
