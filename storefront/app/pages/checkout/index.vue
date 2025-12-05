<template>
  <PageHeader title="__checkout__" class="mb-8" />
  <div>
    <div class="container mx-auto px-4">
      <div class="flex flex-col-reverse lg:flex-row lg:gap-x-8">
        <div class="w-full lg:w-3/5">
          <CheckoutForm />
        </div>

        <div class="w-full lg:w-2/5 mb-8 lg:mb-0">
          <CheckoutSummary />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PageHeader from "~/components/shared/PageHeader.vue";

// Bảo vệ route - chỉ cho phép user đã login
definePageMeta({
  middleware: "auth",
});
</script>
