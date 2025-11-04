<template>
  <div>
    <TheHeader />
    <main>
      <slot />
    </main>
  </div>
</template>

<script setup>
import TheHeader from "~/components/shared/TheHeader.vue";
</script>
