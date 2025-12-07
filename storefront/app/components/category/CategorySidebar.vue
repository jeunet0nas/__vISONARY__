<template>
  <div class="border-2 border-black mb-16">
    <div class="flex justify-between items-center pb-2 bg-black">
      <span class="font-bold text-white text-xl m-2">FILTER</span>
      <span class="font-bold text-white text-xl">[{{ productCount }}]</span>
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
        type="checkbox"
        :showViewAll="false"
        :modelValue="selectedCollections"
        @change="(val) => onFilterChange('collection', val)"
      />

      <FilterGroup
        title="LENS SHAPE"
        :options="['Vuông', 'Oval', 'Cat-eye', 'Wraparound', 'Aviator']"
        type="checkbox"
        :showViewAll="false"
        :modelValue="selectedShapes"
        @change="(val) => onFilterChange('shape', val)"
      />

      <FilterGroup
        title="MATERIALS"
        :options="['Acetate', 'Nylon', 'Kim loại', 'Mixed']"
        type="checkbox"
        :showViewAll="false"
        :modelValue="selectedMaterials"
        @change="(val) => onFilterChange('material', val)"
      />
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import FilterGroup from "./FilterGroup.vue";
import { useCollectionsStore } from "~/stores/useCollectionsStore";
import { storeToRefs } from "pinia";

const props = defineProps({
  productCount: {
    type: Number,
    default: 0,
  },
});

const emit = defineEmits(["filter-change"]);

const collectionsStore = useCollectionsStore();
const { collections } = storeToRefs(collectionsStore);

const collectionOptions = computed(() =>
  collections.value.map((c) => ({ label: c.collection_name, value: c.slug }))
);

const selectedCollections = ref([]);
const selectedShapes = ref([]);
const selectedMaterials = ref([]);

function onFilterChange(type, val) {
  if (type === "collection") selectedCollections.value = val;
  if (type === "shape") selectedShapes.value = val;
  if (type === "material") selectedMaterials.value = val;
  emit("filter-change", {
    collections: selectedCollections.value,
    shapes: selectedShapes.value,
    materials: selectedMaterials.value,
  });
}
</script>
