<template>
  <div class="w-full lg:w-2/3 p-8 lg:p-12 bg-white">
    <div
      class="flex justify-between items-end mb-10 border-b border-black pb-4"
    >
      <h2 class="text-3xl font-bold uppercase tracking-wider">
        Thông tin cá nhân
      </h2>
    </div>

    <form @submit.prevent="handleSubmit" class="space-y-10">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
        <div class="group relative">
          <input
            v-model="form.customer_name"
            type="text"
            id="customer_name"
            class="peer w-full bg-transparent border-b border-gray-300 focus:border-black outline-none py-2 text-lg transition-colors placeholder-transparent"
            placeholder="Họ tên"
            required
          />
          <label
            for="customer_name"
            class="absolute left-0 -top-3.5 text-gray-500 text-xs font-bold uppercase tracking-widest transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-black"
          >
            Họ và tên
          </label>
          <p
            v-if="serverErrors?.customer_name"
            class="text-red-500 text-xs mt-1 font-mono"
          >
            {{ serverErrors.customer_name[0] }}
          </p>
        </div>

        <div class="group relative">
          <input
            v-model="form.phone_number"
            type="text"
            id="phone"
            class="peer w-full bg-transparent border-b border-gray-300 focus:border-black outline-none py-2 text-lg transition-colors placeholder-transparent"
            placeholder="Số điện thoại"
            required
          />
          <label
            for="phone"
            class="absolute left-0 -top-3.5 text-gray-500 text-xs font-bold uppercase tracking-widest transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-black"
          >
            Số điện thoại
          </label>
          <p
            v-if="serverErrors?.phone_number"
            class="text-red-500 text-xs mt-1 font-mono"
          >
            {{ serverErrors.phone_number[0] }}
          </p>
        </div>
      </div>

      <div class="group relative">
        <input
          v-model="form.email"
          type="email"
          id="email"
          class="peer w-full bg-transparent border-b border-gray-300 focus:border-black outline-none py-2 text-lg transition-colors placeholder-transparent"
          placeholder="Email"
          required
        />
        <label
          for="email"
          class="absolute left-0 -top-3.5 text-gray-500 text-xs font-bold uppercase tracking-widest transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-black"
        >
          Email Address
        </label>
        <p
          v-if="serverErrors?.email"
          class="text-red-500 text-xs mt-1 font-mono"
        >
          {{ serverErrors.email[0] }}
        </p>
      </div>

      <div class="pt-4">
        <h3
          class="text-xs font-bold uppercase text-gray-400 mb-6 tracking-widest"
        >
          Địa chỉ giao hàng
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10 mb-10">
          <div class="group relative">
            <input
              v-model="form.city"
              type="text"
              id="city"
              class="peer w-full bg-transparent border-b border-gray-300 focus:border-black outline-none py-2 text-lg transition-colors placeholder-transparent"
              placeholder="City"
              required
            />
            <label
              for="city"
              class="absolute left-0 -top-3.5 text-gray-500 text-xs font-bold uppercase tracking-widest transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-black"
            >
              Tỉnh / Thành phố
            </label>
            <p
              v-if="serverErrors?.city"
              class="text-red-500 text-xs mt-1 font-mono"
            >
              {{ serverErrors.city[0] }}
            </p>
          </div>

          <div class="group relative">
            <input
              v-model="form.province"
              type="text"
              id="province"
              class="peer w-full bg-transparent border-b border-gray-300 focus:border-black outline-none py-2 text-lg transition-colors placeholder-transparent"
              placeholder="Province"
              required
            />
            <label
              for="province"
              class="absolute left-0 -top-3.5 text-gray-500 text-xs font-bold uppercase tracking-widest transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-black"
            >
              Phường / Xã
            </label>
            <p
              v-if="serverErrors?.province"
              class="text-red-500 text-xs mt-1 font-mono"
            >
              {{ serverErrors.province[0] }}
            </p>
          </div>
        </div>

        <div class="group relative">
          <input
            v-model="form.address"
            type="text"
            id="address"
            class="peer w-full bg-transparent border-b border-gray-300 focus:border-black outline-none py-2 text-lg transition-colors placeholder-transparent"
            placeholder="Address"
            required
          />
          <label
            for="address"
            class="absolute left-0 -top-3.5 text-gray-500 text-xs font-bold uppercase tracking-widest transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-black"
          >
            Địa chỉ
          </label>
          <p
            v-if="serverErrors?.address"
            class="text-red-500 text-xs mt-1 font-mono"
          >
            {{ serverErrors.address[0] }}
          </p>
        </div>
      </div>

      <div class="pt-6 flex justify-end">
        <button
          type="submit"
          class="bg-black text-white px-12 py-4 uppercase tracking-widest text-xs font-bold hover:bg-gray-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
          :disabled="loading"
        >
          <span
            v-if="loading"
            class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"
          ></span>
          {{ loading ? "Updating..." : "Lưu Thay Đổi" }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
const props = defineProps(["userData", "loading", "serverErrors"]);
const emit = defineEmits(["submit-info"]);

const form = reactive({
  customer_name: "",
  email: "",
  phone_number: "",
  city: "",
  province: "",
  address: "",
});

watch(
  () => props.userData,
  (newVal) => {
    if (newVal) {
      form.customer_name = newVal.customer_name || "";
      form.email = newVal.email || "";
      form.phone_number = newVal.phone_number || "";
      form.city = newVal.city || "";
      form.province = newVal.province || "";
      form.address = newVal.address || "";
    }
  },
  { immediate: true, deep: true }
);

const handleSubmit = () => {
  emit("submit-info", form);
};
</script>
