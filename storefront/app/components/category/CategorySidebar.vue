<template>
  <div class="border-2 border-black">
    <div class="flex justify-between items-center pb-2 bg-black">
      <span class="font-bold text-white text-xl m-2">FILTER</span>
      <span class="font-bold text-white text-xl">[198]</span>
    </div>

    <div class="divide-y divide-gray-200 p-4">
      <!-- <FilterGroup
        title="SORT BY"
        :options="['Recommended', 'Newest', 'Rating']"
        type="radio"
        :showViewAll="false"
      /> -->

      <FilterGroup
        title="COLLECTION"
        :options="collectionOptions"
        type="radio"
        :showViewAll="false"
      />

      <FilterGroup
        title="LENS SHAPE"
        :options="['Vuông', 'Oval', 'Cat-eye', 'Wraparound', 'Aviator']"
        type="radio"
        :showViewAll="false"
      />

      <FilterGroup
        title="MATERIALS"
        :options="['Acetate', 'Nylon', 'Kim loại', 'Mixed']"
        type="checkbox"
        :showViewAll="false"
      />
    </div>
  </div>
</template>

<script setup>
import FilterGroup from "./FilterGroup.vue";
import { useCollectionsStore } from "~/stores/useCollectionsStore";
import { storeToRefs } from "pinia";

const collectionsStore = useCollectionsStore();
const { collections } = storeToRefs(collectionsStore);

const collectionOptions = computed(() =>
  collections.value.map((c) => ({ label: c.collection_name, value: c.id }))
);
</script>
