<template>
  <div>
    <div v-if="pending">Loading</div>
    <div v-else-if="error">Error: {{ error.message }}</div>
    <div v-else>
      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-0">
        <ProductCard
          v-for="product in productsStore.products"
          :key="product.product_id"
          :product="product"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import ProductCard from "../product/ProductCard.vue";
import { useProductsStore } from "../../stores/useProductsStore";

const productsStore = useProductsStore();
</script>
