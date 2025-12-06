<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: "section",
    validator: (value) => ["page", "section", "inline"].includes(value),
  },
  text: {
    type: String,
    default: "",
  },
});

// Tính toán Class cho container bao ngoài
const containerClasses = computed(() => {
  switch (props.variant) {
    case "page":
      return "fixed inset-0 z-[9999] bg-black text-white flex-col";

    case "section":
      return "absolute inset-0 z-10 bg-white/90 backdrop-blur-[2px] text-black flex-col";

    case "inline":
      return "relative inline-flex flex-row items-center gap-3";

    default:
      return "";
  }
});

// Tính toán kích thước Icon
const iconSize = computed(() => {
  return props.variant === "inline" ? "w-4 h-4" : "w-10 h-10";
});

const displayText = computed(() => {
  if (props.text) return props.text;
  if (props.variant === "inline") return ""; // Inline mặc định không hiện chữ
  return "PROCESSING DATA";
});
</script>

<template>
  <div
    class="flex items-center justify-center transition-all duration-300 font-mono"
    :class="containerClasses"
  >
    <div class="relative flex items-center justify-center" :class="iconSize">
      <div class="absolute inset-0 border border-current opacity-20"></div>

      <div
        class="absolute inset-0 border border-transparent border-t-current border-r-current animate-spin"
      ></div>

      <div
        v-if="variant !== 'inline'"
        class="w-1/3 h-1/3 bg-current rotate-45 animate-pulse"
      ></div>
    </div>

    <div
      v-if="displayText"
      class="text-[10px] tracking-[0.2em] font-bold animate-pulse uppercase"
      :class="variant === 'inline' ? '' : 'mt-4'"
    >
      {{ displayText }}
    </div>
  </div>
</template>

<style scoped></style>
