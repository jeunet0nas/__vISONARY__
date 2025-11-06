<template>
  <div v-if="product" class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-10 gap-8">
      <div class="lg:col-span-6">
        <ProductGallery :images="product.images" />
      </div>

      <div class="lg:col-span-4">
        <ProductBuyBox :product="product" />
      </div>
    </div>
  </div>
  <div v-else class="text-center p-20">
    <p>Loading product...</p>
  </div>
</template>

<script setup>
import { ref } from "vue";

// 1. Lấy `slug` từ URL
const route = useRoute();
const slug = route.params.slug;

// 2. GIẢ LẬP DỮ LIỆU SẢN PHẨM (Mock Data)
// Sau này, chúng ta sẽ thay thế phần này bằng `useFetch`
// để gọi API Laravel bằng `slug`.
const product = ref({
  id: 123,
  slug: "pico-02",
  name: "PICO 02",
  price: 385000,
  status: "To be restocked",
  description:
    "Discover the Pico 02 glasses from Gentle Monster’s new Pocket collection. Composed with a refined structure, this piece features a light and solid fit.",
  images: [
    {
      id: 1,
      url: "https://gm-prd-resource.gentlemonster.com/catalog/product/bulk/baa14485-61a3-434f-8c4c-40d861d8f877/11004655_FRONT.jpg",
    },
    {
      id: 2,
      url: "https://gm-prd-resource.gentlemonster.com/catalog/product/bulk/2cf3f4ed-0c6a-4b5c-a543-eceff3d74812/11004914_D_45.jpg",
    },
    {
      id: 3,
      url: "https://gm-prd-resource.gentlemonster.com/catalog/product/bulk/d0a8e9fa-be24-4c91-b6e6-6d6db6568db4/11004914_SIDE.jpg",
    },
    {
      id: 4,
      url: "https://gm-prd-resource.gentlemonster.com/catalog/product/bulk/2a48343c-6131-4fd5-9df9-6fe4dc592984/11004914_D_45_DETAIL.jpg",
    },
    {
      id: 5,
      url: "https://gm-prd-resource.gentlemonster.com/catalog/product/bulk/b36fbcca-f4db-419d-9ede-251e0807d5f4/11004914_SIDE_DETAIL.jpg",
    },
    {
      id: 6,
      url: "https://gm-prd-resource.gentlemonster.com/catalog/product/package/57358e1d-1019-43a7-bd21-b5de5460cd7b/2025-OPT-package.jpg",
    },
  ],
  variants: [
    { id: "v1", name: "Silver", inStock: true },
    { id: "v2", name: "Black", inStock: false },
    { id: "v3", name: "Gold", inStock: true },
  ],
});

// 3. (Tùy chọn) Kiểm tra nếu slug không khớp (sau này)
// if (product.value.slug !== slug) { ... xử lý 404 ... }
</script>
