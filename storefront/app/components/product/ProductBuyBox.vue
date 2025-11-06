<template>
  <div
    class="sticky top-24 flex flex-col bg-gray-100 text-black border-black border-2 p-4"
  >
    <div class="flex justify-between items-start">
      <h1 class="text-2xl font-bold uppercase">{{ product.name }}</h1>
    </div>

    <div class="mt-2">
      <p class="text-lg">
        {{ formatPrice(product.price) }}
        <span class="text-sm text-gray-500 ml-2">{{ product.status }}</span>
      </p>
    </div>

    <hr class="border-black my-4" />

    <div class="space-y-2">
      <p class="text-sm leading-relaxed">{{ product.description }}</p>
      <a href="#" class="text-sm font-bold underline inline-block">Read more</a>
    </div>

    <div class="space-y-2 mt-6">
      <p class="font-semibold uppercase text-sm">DETAILS</p>
      <p class="font-semibold uppercase text-sm">SIZE AND FIT</p>
    </div>

    <div class="border border-black p-4 mt-6 space-y-4 bg-white">
      <div>
        <h3 class="text-sm font-semibold">
          {{ selectedVariant.name }}
        </h3>

        <div class="flex space-x-2 mt-2">
          <button
            v-for="variant in product.variants"
            :key="variant.id"
            @click="selectedVariant = variant"
            :disabled="!variant.inStock"
            class="w-10 h-10 border"
            :class="[
              selectedVariant.id === variant.id
                ? 'border-black'
                : 'border-gray-200',
              !variant.inStock
                ? 'opacity-50 cursor-not-allowed line-through'
                : '',
            ]"
          >
            <span class="text-xs">{{ variant.name.substring(0, 1) }}</span>
          </button>
        </div>

        <p class="text-sm text-gray-600 mt-2">
          {{ selectedVariant.variantDescription }}
        </p>
      </div>

      <div>
        <button
          @click="addToBag"
          :disabled="!selectedVariant.inStock"
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
import { useCartStore } from "~/stores/cart";

const { product } = defineProps(["product"]);
const cartStore = useCartStore();

// State cục bộ: Lưu trữ variant đang được chọn
const defaultVariant =
  product.variants.find((v) => v.inStock) || product.variants[0];
const selectedVariant = ref(defaultVariant);

const formatPrice = (price) => {
  if (typeof price !== "number") return price;
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);
};

const addToBag = () => {
  if (!selectedVariant.value.inStock) return;

  const productToAdd = {
    id: `${product.id}-${selectedVariant.value.id}`,
    name: `${product.name} (${selectedVariant.value.name})`,
    price: product.price,
    imageUrl: product.images[0].url,
  };

  cartStore.addItem(productToAdd, 1);
  cartStore.openCart();
};
</script>
