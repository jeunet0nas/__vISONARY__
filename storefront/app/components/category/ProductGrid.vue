<template>
  <div>
    <div v-if="pending">Loading</div>
    <div v-else-if="error">Error: {{ error.message }}</div>
    <div v-else>
      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-0">
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import ProductCard from "../product/ProductCard.vue";

const {
  data: products,
  pending,
  error,
} = await useFetch("http://localhost:3004/products");

console.log(products.value);
</script>
