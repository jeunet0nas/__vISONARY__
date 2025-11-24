<template>
  <div class="py-4">
    <h3 class="text-sm font-semibold uppercase tracking-wider mb-3 text-black">
      {{ title }}
    </h3>

    <div class="space-y-2">
      <label
        v-for="option in options"
        :key="option"
        class="flex items-center space-x-2 cursor-pointer text-black"
      >
        <input :type="type" :name="title" class="sr-only peer" />

        <div
          class="w-4 h-4 border border-black rounded-sm peer-checked:bg-black transition-colors duration-150"
        ></div>

        <span class="text-sm">{{ option }}</span>
      </label>

      <button v-if="showViewAll" class="text-sm text-gray-500 underline mt-2">
        View all
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  options: Array,
  type: {
    type: String,
    default: "checkbox",
  },
  showViewAll: Boolean,
});
</script>
