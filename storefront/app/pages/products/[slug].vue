<template>
  <div v-if="product" class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-10 gap-8">
      <div class="lg:col-span-6">
        <ProductGallery :images="productDetailsStore.productImages" />
      </div>

      <div class="lg:col-span-4">
        <ProductBuyBox :product="product" />
      </div>
    </div>
  </div>
  <div v-else class="text-center p-20">
    <p>Loading product...</p>
  </div>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { useProductDetailsStore } from "../../stores/useProductDetailsStore";
import { useRoute } from "vue-router";

const productDetailsStore = useProductDetailsStore();
const route = useRoute();

const product = computed(() => productDetailsStore.product);

onMounted(() => productDetailsStore.fetchProduct(route.params.slug));
</script>
