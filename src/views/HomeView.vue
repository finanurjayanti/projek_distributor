<script setup lang="ts">
// @ts-nocheck
import { intToIdr } from "@/components/Helper.vue";
import MenuComponent from "@/components/MenuComponent.vue";
import TopoBackground from "@/components/TopoBackgroundComponent.vue";
import FishList from "@/components/FishListComponent.vue";
import TransactionList from "@/components/TransactionListComponent.vue";
import SummaryList from "@/components/SummaryListComponent.vue";
import AddTransactionField from "@/components/AddTransactionFieldElement.vue";
import axios from "axios";
</script>

<script lang="ts">
export default {
  props: {
    isSession: Boolean,
  },
  data() {
    return {
      dialogShow: false,
      transactionDialogShow: false,
      fishMenu: [],
      fishList: [
        {
          nama_ikan: "",
          harga: 0,
          stok: 0,
        },
      ],
      transactionMenu: [],
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
      summaryList: {
        year: {
          jumlah_harga: 0,
          jumlah_kg: 0,
        },
      },
    };
  },
  name: "HomeView",
  async mounted() {
    this.getFishList();
    this.getMonthTransactionList();
    this.getSummaryTransactionList();

    this.fishMenu = [
      {
        text: "Tambah",
        action: () => {
          console.log("Tambah Ikan");
        },
      },
      {
        text: "Edit",
        action: () => {
          console.log("Edit Ikan");
        },
      },
    ];

    this.transactionMenu = [
      {
        text: "Tambah",
        action: () => {
          this.dialogShow = !this.dialogShow;
          this.transactionDialogShow = !this.transactionDialogShow;
        },
      },
    ];
  },
  methods: {
    async getFishList() {
      await axios.get("http://localhost/api/fish-list.php").then((res) => {
        this.fishList = res.data;
      });
    },
    async getMonthTransactionList() {
      await axios
        .get("http://localhost/api/month-transactions.php")
        .then((res) => {
          this.transactionList = res.data;
        });
    },
    async getSummaryTransactionList() {
      await axios
        .get("http://localhost/api/year-transactions.php")
        .then((res) => {
          let summary: any = {};

          for (const transaction of res.data) {
            const month = new Date(transaction.tanggal).toLocaleString(
              "id-ID",
              {
                month: "long",
              }
            );

            if (summary[month]) {
              if (transaction.penjualan == "1") {
                summary[month].jumlah_harga += parseInt(
                  transaction.jumlah_harga
                );
              } else {
                summary[month].jumlah_harga -= parseInt(
                  transaction.jumlah_harga
                );
              }

              summary[month].jumlah_kg += parseInt(transaction.jumlah_kg);
            } else {
              if (transaction.penjualan == "1") {
                summary[month] = {
                  jumlah_harga: parseInt(transaction.jumlah_harga),
                  jumlah_kg: parseInt(transaction.jumlah_kg),
                };
              } else {
                summary[month] = {
                  jumlah_harga: parseInt(`-${transaction.jumlah_harga}`),
                  jumlah_kg: parseInt(transaction.jumlah_kg),
                };
              }
            }
          }

          this.summaryList = summary;
        });
    },
  },
};
</script>

<template>
  <TopoBackground />
  <transition
    enter-active-class="transition duration-100 fade"
    enter-from-class="transform scale-95 opacity-0"
    enter-to-class="transform scale-100 opacity-100"
    leave-active-class="transition duration-75 fade"
    leave-from-class="transform scale-100 opacity-100"
    leave-to-class="transform scale-95 opacity-0"
  >
    <div
      class="w-screen h-screen flex justify-center items-center absolute"
      v-if="dialogShow"
    >
      <AddTransactionField v-if="transactionDialogShow" />
    </div>
  </transition>
  <div class="grid grid-cols-12 grid-rows-6 w-screen h-screen">
    <div
      class="row-start-1 row-span-2 col-start-1 col-span-4 rounded-xl m-3 grid grid-cols-6 grid-rows-6"
    >
      <div
        class="row-start-1 row-span-1 col-start-1 col-span-2 m-1 flex items-center justify-start rounded-md p-2 bg-white/30 backdrop-blur-sm"
      >
        <span class="font-bold text-black text-xl"><p>Daftar Ikan</p></span>
      </div>
      <div
        class="row-start-1 row-span-1 col-start-6 col-span-1 m-1 flex justify-end items-center"
      >
        <MenuComponent menu-text="Menu" :menu-list="fishMenu" />
      </div>
      <div
        class="row-start-2 row-span-1 col-start-1 col-span-6 p-1 overflow-y-scroll scrollbar"
      >
        <FishList fish-name="Nama Ikan" price="Harga" stock="Stok" />
      </div>
      <div
        class="row-start-3 row-span-5 col-start-1 col-span-6 rounded-md border-2 border-[#4d6bb9] scrollbar overflow-y-scroll p-1 flex flex-col space-y-0.5"
      >
        <span v-for="fish of fishList">
          <FishList
            :fish-name="fish.nama_ikan"
            :price="`${intToIdr(fish.harga)}/Kg`"
            :stock="`${fish.stok} Kg`"
          />
        </span>
      </div>
    </div>
    <div
      class="row-start-1 row-span-2 col-start-5 col-span-8 rounded-xl m-3 grid grid-cols-6 grid-rows-6"
    >
      <div
        class="row-start-1 row-span-1 col-start-1 col-span-2 m-1 flex items-center justify-start rounded-md p-2 bg-white/30 backdrop-blur-sm"
      >
        <span class="font-bold text-black text-xl"
          ><p>Transaksi Bulan Ini</p></span
        >
      </div>
      <div
        class="row-start-1 row-span-1 col-start-6 col-span-1 m-1 flex justify-end items-center"
      >
        <MenuComponent menu-text="Menu" :menu-list="transactionMenu" />
      </div>
      <div
        class="row-start-2 row-span-1 col-start-1 col-span-6 p-1 overflow-y-scroll scrollbar"
      >
        <TransactionList
          index="Nomor"
          person-name="Nama"
          fish-name="Nama Ikan"
          type="Tipe"
          value="Jumlah"
          price="Harga"
          date="Tanggal"
        />
      </div>
      <div
        class="row-start-3 row-span-5 col-start-1 col-span-6 rounded-md border-2 border-[#4d6bb9] scrollbar overflow-y-scroll p-1 flex flex-col space-y-0.5"
      >
        <span v-for="(transaction, index) in transactionList">
          <TransactionList
            :index="`${index + 1}`"
            :person-name="transaction.nama_orang"
            :fish-name="transaction.nama_ikan"
            :type="transaction.penjualan == '1' ? 'Penjualan' : 'Pembelian'"
            :value="`${transaction.jumlah_kg} Kg`"
            :price="`${intToIdr(transaction.jumlah_harga)}`"
            :date="transaction.tanggal"
          />
        </span>
      </div>
    </div>
    <div
      class="row-start-3 row-span-3 col-start-1 col-span-12 bg-blue-800 rounded-xl m-3 grid grid-cols-6 grid-rows-12"
    >
      <div
        class="row-start-1 row-span-1 col-start-1 col-span-2 m-1 flex items-center justify-start rounded-md p-2"
      >
        <span class="font-bold text-white text-xl -mt-8"
          ><p>Rekapitulasi Pendapatan</p>
        </span>
      </div>
      <div
        class="row-start-2 row-span-1 col-start-1 col-span-6 p-1 overflow-y-scroll scrollbar"
      >
        <SummaryList month="Bulan" value="Jumlah Kg" profit="Pendapatan" />
      </div>
      <div
        class="row-start-3 row-span-4 col-start-1 col-span-6 flex flex-col space-y-0.5 p-1 overflow-y-scroll scrollbar-white -mt-10"
      >
        <span v-for="month of Object.keys(summaryList)">
          <SummaryList
            :month="month"
            :value="`${summaryList[month].jumlah_kg}`"
            :profit="`${intToIdr(summaryList[month].jumlah_harga)}`"
          />
        </span>
      </div>
    </div>
  </div>
</template>
