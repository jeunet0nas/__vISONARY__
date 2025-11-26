<template>
  <div
    class="border border-black group w-46 lg:w-52.5 mx-auto relative overflow-hidden"
  >
    <NuxtLink :to="`/products/${product.slug}`">
      <div class="aspect-square w-full overflow-hidden bg-gray-100">
        <img
          :src="product.thumbnail"
          :alt="product.product_name"
          class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-300"
        />
      </div>

      <div
        class="absolute bottom-0 left-0 right-0 p-4 from-black/70 to-transparent text-white"
      >
        <div class="flex justify-between items-end">
          <h3 class="text-xs text-black font-semibold truncate pr-2">
            {{ product.product_name }}
          </h3>
          <p class="text-xs text-black font-medium whitespace-nowrap">
            {{ formatPrice(product.product_price) }}
          </p>
        </div>
      </div>
    </NuxtLink>
  </div>
</template>

<script setup>
import { formatPrice } from "~/utils/format";
const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
});
</script>
