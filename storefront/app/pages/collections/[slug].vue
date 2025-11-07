<template>
  <PageHeader title="__collections__" />
  <div>
    <CollectionNavBar :collections="allCollections" :currentSlug="slug" />

    <div>
      <div class="w-full bg-gray-100">
        <img
          :src="currentCollection.heroImage"
          :alt="currentCollection.name"
          class="w-full h-auto object-cover"
        />
      </div>

      <div class="container mx-auto px-4 py-8 lg:py-12 max-w-3xl text-center">
        <h1
          class="text-3xl lg:text-4xl font-bold uppercase mb-4 bg-black text-white pt-1.5 pb-1.5"
        >
          {{ currentCollection.name }}
        </h1>
        <p class="text-sm leading-relaxed text-black">
          {{ currentCollection.description }}
        </p>
      </div>

      <div class="container mx-auto px-4 lg:border border-black bg-gray-100">
        <div
          class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-4 md:gap-y-12 lg:gap-y-24 pt-14"
        >
          <ProductCard
            v-for="product in currentCollection.products"
            :key="product.id"
            :product="product"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import CollectionNavBar from "~/components/collections/CollectionNavBar.vue";
import PageHeader from "~/components/shared/PageHeader.vue";

const route = useRoute();
const slug = route.params.slug;

const allCollections = ref([
  { name: "2025 FALL", slug: "2025-fall" },
  { name: "2025 BOLD", slug: "2025-bold" },
  { name: "Pocket", slug: "pocket" },
  { name: "Maison Margiela", slug: "maison-margiela" },
  { name: "Jentle Salon", slug: "jentle-salon" },
  { name: "Overwatch", slug: "overwatch" },
]);

const currentCollection = ref({
  name: "Jentle Salon",
  slug: "jentle-salon",
  heroImage:
    "https://gm-dev-resource.gentlemonster.com/catalog/category/sunglasses/image/74a04575-0eb8-4954-a666-65f6f9a10b0d/4.jentlesalon_collectionplp_pc.jpg",
  description:
    "Introducing ‘JENTLE SALON,’ the third project imagined by Gentle Monster and JENNIE. The two creative forces present a collaborative collection that transcends the realm of eyewear through its eye-catching charm designs, encouraging a diverse expression of style.",
  products: [
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
      imageUrl:
        "https://via.placeholder.com/400x400/f0f0f0/333?text=Sản+phẩm+4",
      slug: "san-pham-4",
    },
    {
      id: 5,
      name: "Sản phẩm 4",
      price: 500000,
      imageUrl:
        "https://via.placeholder.com/400x400/f0f0f0/333?text=Sản+phẩm+4",
      slug: "san-pham-4",
    },
  ],
});
</script>
