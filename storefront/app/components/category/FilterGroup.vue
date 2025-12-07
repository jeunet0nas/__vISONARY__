<template>
  <div class="py-4">
    <h3 class="text-sm font-semibold uppercase tracking-wider mb-3 text-black">
      {{ title }}
    </h3>

    <div class="space-y-2">
      <label
        v-for="option in options"
        :key="typeof option === 'object' ? option.value : option"
        class="flex items-center space-x-2 cursor-pointer text-black"
      >
        <input
          :type="type"
          :name="title"
          class="sr-only peer"
          :value="typeof option === 'object' ? option.value : option"
          :checked="
            type === 'checkbox'
              ? Array.isArray(modelValue) &&
                modelValue.includes(
                  typeof option === 'object' ? option.value : option
                )
              : modelValue ===
                (typeof option === 'object' ? option.value : option)
          "
          @change="
            onInputChange(
              $event,
              typeof option === 'object' ? option.value : option
            )
          "
        />

        <div
          class="w-4 h-4 border border-black rounded-sm peer-checked:bg-black transition-colors duration-150"
        ></div>

        <span class="text-sm">{{
          typeof option === "object" ? option.label : option
        }}</span>
      </label>

      <button v-if="showViewAll" class="text-sm text-gray-500 underline mt-2">
        View all
      </button>
    </div>
  </div>
</template>

<script setup>
const emit = defineEmits(["change"]);
const props = defineProps({
  title: String,
  options: Array,
  type: {
    type: String,
    default: "checkbox",
  },
  showViewAll: Boolean,
  modelValue: {
    type: [Array, String, Number, null],
    default: null,
  },
});

function onInputChange(e, value) {
  if (props.type === "checkbox") {
    let arr = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    if (e.target.checked) {
      if (!arr.includes(value)) arr.push(value);
    } else {
      arr = arr.filter((v) => v !== value);
    }
    emit("change", arr);
  } else {
    emit("change", value);
  }
}
</script>
