<template>
  <header class="bg-white sticky top-0 z-50 w-full border-2 border-black">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid h-16 grid-cols-10">
        <div class="col-span-2 flex items-center justify-start">
          <NuxtLink
            to="/category"
            class="text-xs lg:text-sm font-medium tracking-wider uppercase transition-colors hover:text-gray-500 text-black"
          >
            GLASSESS
          </NuxtLink>
        </div>

        <div
          class="col-span-6 h-full border-l-0 md:border-l-2 border-r-0 md:border-r-2 border-black flex items-center justify-center"
        >
          <NuxtLink
            to="/"
            class="text-2xl lg:text-5xl font-bold tracking-wider uppercase text-black"
            >VISIONARY
          </NuxtLink>
        </div>

        <div class="col-span-2 flex items-center justify-end gap-6">
          <NuxtLink
            to="/login"
            class="text-xs lg:text-sm font-medium tracking-wider uppercase transition-colors hover:text-gray-500 text-black"
          >
            Login
          </NuxtLink>
          <button
            type="button"
            @click="cartStore.openCart"
            class="text-xs lg:text-sm font-medium tracking-wider uppercase transition-colors hover:text-gray-500 text-black"
          >
            Bag [{{ cartStore.itemCount }}]
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useCartStore } from "~/stores/cart";

const cartStore = useCartStore();
</script>
