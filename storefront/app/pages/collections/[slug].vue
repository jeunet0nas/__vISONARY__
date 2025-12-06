<template>
  <PageHeader title="__collections__" />
  <div v-if="currentCollection">
    <CollectionNavBar
      :collections="collectionsStore.collections"
      :currentSlug="slug"
    />

    <div>
      <div class="w-full bg-gray-100">
        <img
          :src="currentCollection.banner_img"
          :alt="currentCollection.name"
          class="w-full h-auto object-cover"
        />
      </div>

      <div class="container mx-auto px-4 py-8 lg:py-12 max-w-3xl text-center">
        <h1
          class="text-3xl lg:text-4xl font-bold uppercase mb-4 bg-black text-white pt-1.5 pb-1.5"
        >
          {{ currentCollection.collection_name }}
        </h1>
        <p class="text-sm leading-relaxed text-black">
          {{ currentCollection.collection_desc }}
        </p>
      </div>

      <div
        class="container mx-auto px-4 lg:border-2 border-black  bg-gray-100 border-2 mb-14"
      >
        <div
          class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-4 md:gap-y-12 lg:gap-y-24 pt-14 pb-14"
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
  <div v-else>Loading...</div>
</template>

<script setup>
import { useCollectionsStore } from "#imports";
import axios from "axios";
import { ref } from "vue";
import CollectionNavBar from "~/components/collections/CollectionNavBar.vue";
import PageHeader from "~/components/shared/PageHeader.vue";
import { BASE_URL } from "~/helpers/config";

const route = useRoute();
const slug = route.params.slug;

const collectionsStore = useCollectionsStore();
const currentCollection = ref(null);
const fetchCollection = async () => {
  const res = await axios.get(`${BASE_URL}/collections/${slug}/show`);
  currentCollection.value = res.data.data;
};

onMounted(fetchCollection);
watch(() => route.params.slug, fetchCollection);
</script>
