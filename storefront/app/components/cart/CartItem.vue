<template>
  <div
    class="relative aspect-square bg-white border-b border-black group overflow-hidden"
  >
    <div class="w-full h-full bg-gray-100">
      <img
        :src="item.product.imageUrl"
        :alt="item.product.name"
        class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-300"
      />
    </div>

    <div
      class="absolute inset-0 bg-black/50 transition-all opacity-0 group-hover:opacity-100 z-10"
    ></div>

    <div class="absolute bottom-0 left-0 right-0 p-4 z-20">
      <div class="flex justify-between items-end">
        <h3 class="text-xs text-black font-semibold truncate pr-2">
          {{ item.product.name }}
        </h3>
        <p class="text-xs text-black font-medium whitespace-nowrap">
          {{ formatPrice(item.product.price) }}
        </p>
      </div>
    </div>

    <div
      class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center space-x-2 bg-white/80 p-1 opacity-0 group-hover:opacity-100 transition-all z-20 text-black"
    >
      <button @click="decreaseQuantity" class="px-2 text-lg hover:bg-gray-200">
        -
      </button>
      <span class="px-2 text-sm font-semibold">{{ item.quantity }}</span>
      <button @click="increaseQuantity" class="px-2 text-lg hover:bg-gray-200">
        +
      </button>
    </div>

    <button
      @click="removeItem"
      class="absolute top-2 right-2 text-xs font-bold text-black bg-white/80 l w-5 h-5 flex items-center justify-center hover:bg-white opacity-0 group-hover:opacity-100 transition-all z-20"
    >
      X
    </button>
  </div>
</template>

<script setup>
// Script không thay đổi
import { useCartStore } from "~/stores/cart";

const { item } = defineProps(["item"]);
const cartStore = useCartStore();

const increaseQuantity = () => {
  cartStore.updateQuantity(item.product.id, item.quantity + 1);
};

const decreaseQuantity = () => {
  cartStore.updateQuantity(item.product.id, item.quantity - 1);
};

const removeItem = () => {
  cartStore.removeItem(item.product.id);
};

const formatPrice = (price) => {
  if (typeof price !== "number") {
    return price;
  }
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);
};
</script>
