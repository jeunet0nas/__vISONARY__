<template>
  <div class="relative w-full min-h-[50vh]">
    <TheLoader
      v-if="productsStore.isLoading"
      variant="section"
      text="LOADING COLLECTION"
    />

    <div v-else class="transition-opacity duration-500">
      <div
        v-if="productsStore.products.length > 0"
        class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-0"
      >
        <ProductCard
          v-for="product in productsStore.products"
          :key="product.product_id"
          :product="product"
        />
      </div>

      <div
        v-else
        class="flex flex-col items-center justify-center h-[50vh] text-gray-400 font-mono text-sm"
      >
        <p>[NO DATA FOUND]</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import ProductCard from "../product/ProductCard.vue";
import TheLoader from "~/components/shared/TheLoader.vue";
import { useProductsStore } from "../../stores/useProductsStore";

const productsStore = useProductsStore();
</script>
