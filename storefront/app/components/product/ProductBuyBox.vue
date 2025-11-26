<template>
  <div
    class="sticky top-24 flex flex-col bg-gray-100 text-black border-black border-2 p-4"
  >
    <div class="flex justify-between items-start">
      <h1 class="text-2xl font-bold uppercase">
        {{ product.product_name }}
      </h1>
    </div>

    <div class="mt-2">
      <p class="text-lg flex items-center gap-2">
        {{ formatPrice(product.product_price) }}
        <span v-if="product.status !== 1" class="text-sm text-gray-500 ml-2">
          {{ product.status }}
        </span>
        <span
          v-if="product.status === 0"
          class="ml-4 inline-block px-3 py-1 rounded bg-black text-white text-xs font-semibold uppercase tracking-wide"
        >
          Out of stock
        </span>
      </p>
    </div>

    <hr class="border-black my-4" />

    <div class="space-y-2">
      <p class="text-sm leading-relaxed">{{ product.product_desc }}</p>
      <a href="#" class="text-sm font-bold underline inline-block">Read more</a>
    </div>

    <div class="space-y-2 mt-6">
      <p class="font-semibold uppercase text-sm">DETAILS</p>
      <p class="font-semibold uppercase text-sm">SIZE AND FIT</p>
    </div>

    <div class="border border-black p-4 mt-6 space-y-4 bg-white">
      <div>
        <button
          @click="addToBag"
          :disabled="product.status === 0 || product.product_qty === 0"
          class="w-full bg-black text-white p-4 font-semibold uppercase hover:bg-gray-800 disabled:bg-gray-300 disabled:cursor-not-allowed"
        >
          ADD TO BAG
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useCartStore } from "~/stores/useCartStore";
import { formatPrice } from "../../utils/format";

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
});
const { product } = props;
const cartStore = useCartStore();

const addToBag = () => {
  const productToAdd = {
    id: product.product_id,
    name: product.product_name,
    price: product.product_price,
    qty: product.product_qty,
    imageUrl: product.thumbnail,
  };
  cartStore.addItem(productToAdd, 1);
  cartStore.openCart();
};
</script>
