<template>
  <div>
    <TheHeader />
    <main>
      <slot />
    </main>
    <TheFooter />
  </div>
</template>

<script setup>
import TheFooter from "~/components/shared/TheFooter.vue";
import TheHeader from "~/components/shared/TheHeader.vue";
</script>
