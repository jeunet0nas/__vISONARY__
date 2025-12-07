<template>
  <div class="w-full border-b-2 border-black">
    <nav class="flex overflow-x-auto whitespace-nowrap scrollbar-hide">
      <NuxtLink
        v-for="collection in collections"
        :key="collection.slug"
        :to="`/collections/${collection.slug}`"
        class="px-4 py-3 text-sm font-medium uppercase tracking-wider transition-colors"
        :class="getActiveClass(collection.slug)"
      >
        {{ collection.collection_name }}
      </NuxtLink>
    </nav>
  </div>
</template>

<script setup>
const props = defineProps({
  collections: {
    type: Array,
    required: true,
  },
  currentSlug: {
    type: String,
    required: true,
  },
});

const getActiveClass = (slug) => {
  if (slug === props.currentSlug) {
    return "text-black font-bold";
  } else {
    return "text-gray-500 hover:text-black";
  }
};
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
