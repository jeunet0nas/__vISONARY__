<template>
  <main class="flex min-h-screen flex-col lg:flex-row bg-white text-black">
    <section class="w-full h-160 lg:w-2/5 lg:h-screen">
      <NuxtImg
        src="https://gm-dev-resource.gentlemonster.com/catalog/category/sunglasses/image/f02d53b6-7f2d-4d7f-8eff-f3710bdada86/4.jentlesalon_collectionplp_mo.jpg"
        alt="VISIONARY Hero Image"
        class="h-full w-full object-cover"
        preload
      />
    </section>

    <section class="w-full lg:w-3/5 flex flex-col">
      <div
        class="w-full lg:h-3/5 order-first lg:border-l lg:border-black flex flex-col lg:flex-row"
      >
        <div class="w-full lg:w-1/3 p-6 lg:p-12 flex items-center">
          <h2
            class="text-3xl lg:text-5xl font-semibold uppercase tracking-wider"
          >
            New Arrivals
          </h2>
        </div>

        <div
          class="w-full lg:w-2/3 p-6 lg:p-12 flex items-center justify-center"
        >
          <div class="grid grid-cols-2 gap-2 md:gap-4 max-w-md">
            <ProductCard
              v-for="product in newArrivals"
              :key="product.id"
              :product="product"
            />
          </div>
        </div>
      </div>
      <div
        class="w-full lg:h-2/5 bg-black flex items-center justify-center p-12 order-last"
      >
        <blockquote
          class="text-xl lg:text-4xl leading-relaxed uppercase font-semibold text-right text-white"
        >
          "Not just eyewear. It’s a mainframe for your face."
        </blockquote>
      </div>
    </section>
  </main>
</template>

<script setup>
import { ref } from "vue";
import ProductCard from "~/components/product/ProductCard.vue";

const newArrivals = ref([
  {
    id: 1,
    name: "Jennie - Wispy Y8",
    price: 380000,
    imageUrl: "https://via.placeholder.com/400x400/f0f0f0/333?text=Wispy+Y8",
    slug: "jennie-wispy-y8",
  },
  {
    id: 2,
    name: "Jennie - Jem",
    price: 420000,
    imageUrl: "https://via.placeholder.com/400x400/f0f0f0/333?text=Jem",
    slug: "jennie-jem",
  },
  {
    id: 3,
    name: "Jennie - Wispy GR8",
    price: 380000,
    imageUrl: "https://via.placeholder.com/400x400/f0f0f0/333?text=Wispy+GR8",
    slug: "jennie-wispy-gr8",
  },
  {
    id: 4,
    name: "Sản phẩm 4",
    price: 500000,
    imageUrl: "https://via.placeholder.com/400x400/f0f0f0/333?text=Sản+phẩm+4",
    slug: "san-pham-4",
  },
]);

useHead({
  title: "VISIONARY - Trang chủ",
  meta: [
    {
      name: "description",
      content: "Khám phá những sản phẩm mới nhất từ VISIONARY.",
    },
  ],
});
</script>
