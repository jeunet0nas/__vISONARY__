<template>
  <div class="border-2 border-black">
    <div class="flex justify-between items-center pb-2 bg-black">
      <span class="font-bold text-white text-xl m-2">FILTER</span>
      <span class="font-bold text-white text-xl">(198)</span>
    </div>

    <div class="divide-y divide-gray-200 p-4">
      <FilterGroup
        title="SORT BY"
        :options="['Recommended', 'Newest', 'Rating']"
        type="radio"
        :showViewAll="false"
      />

      <FilterGroup
        title="LENS TYPE"
        :options="['Prescription', 'Light Adaptive']"
        type="checkbox"
        :showViewAll="false"
      />

      <FilterGroup
        title="LENS COLOR"
        :options="['Black', 'Clear', 'Brown', 'Blue', 'Green']"
        type="checkbox"
        :showViewAll="true"
      />

      <FilterGroup
        title="FRAME COLOR"
        :options="['Black', 'Brown', 'Silver', 'Gold', 'Grey']"
        type="checkbox"
        :showViewAll="true"
      />

      <FilterGroup
        title="MATERIALS"
        :options="['Acetate', 'Metal', 'Combination', 'Etc', 'TR']"
        type="checkbox"
        :showViewAll="false"
      />
    </div>
  </div>
</template>

<script setup>
// Nuxt sẽ tự động import FilterGroup.vue
import FilterGroup from "./FilterGroup.vue";
</script>
