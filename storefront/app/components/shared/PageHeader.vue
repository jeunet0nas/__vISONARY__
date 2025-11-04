<template>
  <div class="bg-black text-white py-8 md:py-12">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-4xl md:text-5xl font-bold tracking-wider">
        {{ title }}
      </h1>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  // Hoặc đơn giản là: defineProps(['title'])
});
</script>
