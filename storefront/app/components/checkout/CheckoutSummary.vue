<template>
  <div class="sticky top-24 border border-black">
    <div
      class="p-4 grid grid-cols-2 gap-px bg-black border-l border-t border-r border-black"
    >
      <CartItem
        v-for="item in cartStore.items"
        :key="item.product.id"
        :item="item"
      />
      <div
        class="flex items-center justify-center aspect-square bg-white border-b border-black"
      >
        <button class="text-3xl text-gray-400">+</button>
      </div>
    </div>

    <div class="p-4 border-t border-black space-y-2 text-black">
      <div class="flex justify-between text-lg">
        <span class="font-semibold uppercase">SUBTOTAL</span>
        <span>{{ formatPrice(cartStore.subtotal) }}</span>
      </div>

      <div class="flex justify-between text-lg">
        <span class="font-semibold uppercase">SHIPPING</span>
        <span>{{ formatPrice(shippingCost) }}</span>
      </div>

      <div v-if="cartStore.appliedCoupon" class="flex justify-between text-lg">
        <span class="font-semibold uppercase flex items-center">
          DISCOUNT - {{ cartStore.appliedCoupon.code }}
          <button @click="cartStore.removeCoupon" class="ml-2">[X]</button>
        </span>
        <span>-{{ formatPrice(cartStore.discountAmount) }}</span>
      </div>
    </div>

    <div class="p-4 border-t border-black text-black">
      <div class="flex justify-between text-xl font-bold">
        <span class="uppercase">TOTAL</span>
        <span>{{ formatPrice(cartStore.finalSubtotal + shippingCost) }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useCartStore } from "~/stores/useCartStore";
import CartItem from "~/components/cart/CartItem.vue";
import { formatPrice } from "~/utils/format";

const cartStore = useCartStore();
const shippingCost = ref(0);
</script>
