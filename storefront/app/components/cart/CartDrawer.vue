<template>
  <Transition name="slide-fade">
    <div v-if="cartStore.isOpen" class="fixed inset-0 z-100" aria-modal="true">
      <div
        class="absolute inset-0 bg-black/30"
        @click="cartStore.closeCart"
      ></div>

      <div
        class="absolute top-0 right-0 bottom-0 z-50 w-full max-w-md bg-white border-l border-b border-black"
      >
        <div class="flex flex-col h-full">
          <header
            class="flex items-center justify-between p-4 border-b border-black"
          >
            <h2 class="font-semibold uppercase text-black">
              BAG [{{ cartStore.itemCount }}]
            </h2>
            <button
              @click="cartStore.closeCart"
              class="font-semibold uppercase text-gray-500"
            >
              CLOSE
            </button>
          </header>

          <div class="flex-1 overflow-y-auto p-4">
            <div
              v-if="cartStore.items.length > 0"
              class="grid grid-cols-2 gap-px bg-black border-2 border-black"
            >
              <CartItem
                v-for="item in cartStore.items"
                :key="item.product.id"
                :item="item"
              />
              <div
                class="flex items-center justify-center aspect-square bg-gray-100 border-black"
              >
                <NuxtLink
                  to="/category"
                  class="text-3xl text-gray-400"
                  @click="cartStore.closeCart"
                >
                  +
                </NuxtLink>
              </div>
            </div>

            <div v-else class="text-center p-10 text-black">
              <p>Your bag is empty.</p>
            </div>
          </div>

          <footer class="p-4 border-t border-black">
            <div class="flex justify-between items-center mb-4 text-black">
              <span class="font-semibold uppercase">SUBTOTAL</span>
              <span class="font-semibold">
                {{ formatPrice(cartStore.subtotal) }}
              </span>
            </div>
            <button
              class="w-full bg-black text-white p-4 font-semibold uppercase"
            >
              CHECKOUT NOW
            </button>
          </footer>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease-out;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(100%);
  opacity: 0;
}
</style>

<script setup>
import { useCartStore } from "~/stores/useCartStore";
import CartItem from "./CartItem.vue";
import { formatPrice } from "~/utils/format";

const cartStore = useCartStore();
</script>
