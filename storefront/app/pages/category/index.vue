<template>
  <PageHeader title="__glasses__" />
  <Spacer />
  <div class="w-[92%] mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <aside class="md:col-span-1">
        <CategorySidebar />
      </aside>
      <main class="md:col-span-3">
        <ProductGrid />
      </main>
    </div>
  </div>
</template>

<script setup>
import PageHeader from "~/components/shared/PageHeader.vue";
import Spacer from "~/components/shared/Spacer.vue";
import CategorySidebar from "~/components/category/CategorySidebar.vue";
import ProductGrid from "~/components/category/ProductGrid.vue";
</script>
