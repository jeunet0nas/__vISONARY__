<template>
  <UApp :toaster="toaster">
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>

    <CartDrawer />
  </UApp>
</template>

<script setup lang="ts">
const toaster = {
  position: "bottom-right" as const,
  duration: 4000,
  max: 5,
  expand: true,
};
</script>
