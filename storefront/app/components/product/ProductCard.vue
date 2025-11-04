<template>
  <div
    class="border border-black group w-48 lg:w-52.5 mx-auto relative overflow-hidden"
  >
    <a href="#">
      <div class="aspect-square w-full overflow-hidden bg-gray-100">
        <img
          :src="product.imageUrl"
          :alt="product.name"
          class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-300"
        />
      </div>

      <div
        class="absolute bottom-0 left-0 right-0 p-4 from-black/70 to-transparent text-white"
      >
        <div class="flex justify-between items-end">
          <h3 class="text-xs text-black font-semibold truncate pr-2">
            {{ product.name }}
          </h3>
          <p class="text-xs text-black font-medium whitespace-nowrap">
            {{ formatPrice(product.price) }}
          </p>
        </div>
      </div>
    </a>
  </div>
</template>

<script setup>
const { product } = defineProps(["product"]);
// Bỏ console.log (hoặc giữ lại nếu bạn muốn debug)

const formatPrice = (price) => {
  if (typeof price !== "number") {
    return price; // Trả về nguyên bản nếu không phải là số
  }
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);
};
</script>
