<template>
  <div
    class="sticky top-24 flex flex-col bg-gray-100 text-black border-black border-2 p-4"
  >
    <div class="flex justify-between items-start">
      <h1 class="text-2xl font-bold uppercase">
        {{ props.product.product_name }}
      </h1>
    </div>

    <div class="mt-2">
      <p class="text-lg flex items-center gap-2">
        {{ formatPrice(props.product.product_price) }}
        <span
          v-if="props.product.status !== 1"
          class="text-sm text-gray-500 ml-2"
        >
          {{ props.product.status }}
        </span>
        <span
          v-if="props.product.status === 0"
          class="ml-4 inline-block px-3 py-1 rounded bg-black text-white text-xs font-semibold uppercase tracking-wide"
        >
          Out of stock
        </span>
      </p>
    </div>

    <hr class="border-black my-4" />

    <div class="space-y-2">
      <p class="text-sm leading-relaxed">{{ props.product.product_desc }}</p>
    </div>

    <div class="space-y-2 mt-6">
      <p class="font-semibold uppercase text-sm">
        Kiểu dáng : {{ props.product.shape }}
      </p>
      <p class="font-semibold uppercase text-sm">
        Chất liệu : {{ props.product.material }}
      </p>
    </div>

    <div class="border border-black p-4 mt-6 space-y-4 bg-white">
      <div>
        <button
          @click="addToBag"
          :disabled="
            props.product.status === 0 || props.product.product_qty === 0
          "
          class="w-full bg-black text-white p-4 font-semibold uppercase hover:bg-gray-800 disabled:bg-gray-300 disabled:cursor-not-allowed"
        >
          THÊM VÀO GIỎ
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from "~/stores/useCartStore";
import { formatPrice } from "../../utils/format";

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
});
const cartStore = useCartStore();

const addToBag = () => {
  const productToAdd = {
    id: props.product.product_id,
    name: props.product.product_name,
    price: props.product.product_price,
    qty: props.product.product_qty,
    imageUrl: props.product.thumbnail,
  };
  cartStore.addItem(productToAdd, 1);
  cartStore.openCart();
};
</script>
