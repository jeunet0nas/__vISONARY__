<template>
  <p v-if="error" class="text-red-300 text-sm mt-1">{{ error }}</p>
</template>
<script setup>
defineProps({ error: String });
</script>
