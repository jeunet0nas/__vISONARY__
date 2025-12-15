<template>
  <aside class="w-full lg:w-1/3 flex flex-col border-r border-black h-full">
    <div
      class="p-8 border-b border-black flex flex-col items-center justify-center relative"
    >
      <div
        class="relative group cursor-pointer w-48 h-48 overflow-hidden bg-gray-100"
      >
        <img
          :src="avatarPreview || user?.profile_img"
          alt="Avatar"
          class="w-full h-full object-cover"
        />

        <label
          class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
        >
          <span
            class="text-white uppercase text-xs tracking-widest font-bold border border-white px-4 py-2"
          >
            Change Photo
          </span>
          <input
            type="file"
            class="hidden"
            accept="image/*"
            @change="handleFileChange"
          />
        </label>
      </div>

      <p class="mt-6 font-mono text-sm uppercase tracking-widest font-bold">
        {{ user?.customer_name || "Visionary Member" }}
      </p>
    </div>

    <nav class="flex flex-col">
      <NuxtLink
        to="/profile"
        class="p-6 border-b border-black hover:bg-black hover:text-white transition-colors uppercase tracking-widest text-xs font-bold flex items-center justify-between group"
        active-class="bg-black text-white"
      >
        <span>Thông tin tài khoản</span>
        <span class="opacity-0 group-hover:opacity-100 transition-opacity"
          >→</span
        >
      </NuxtLink>

      <NuxtLink
        to="/profile/orders"
        class="p-6 border-b border-black hover:bg-black hover:text-white transition-colors uppercase tracking-widest text-xs font-bold flex items-center justify-between group"
      >
        <span>Lịch sử đơn hàng</span>
        <span class="opacity-0 group-hover:opacity-100 transition-opacity"
          >→</span
        >
      </NuxtLink>

      <NuxtLink
        to="/profile/password"
        class="p-6 border-b border-black hover:bg-black hover:text-white transition-colors uppercase tracking-widest text-xs font-bold flex items-center justify-between group"
      >
        <span>Đổi mật khẩu</span>
        <span class="opacity-0 group-hover:opacity-100 transition-opacity"
          >→</span
        >
      </NuxtLink>

      <button
        @click="$emit('logout')"
        class="p-6 text-left hover:bg-red-600 hover:text-white transition-colors uppercase tracking-widest text-xs font-bold w-full"
      >
        Đăng xuất
      </button>
    </nav>
  </aside>
</template>

<script setup>
const props = defineProps(["user"]);
const emit = defineEmits(["update-avatar", "logout"]);
const avatarPreview = ref(null);

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    avatarPreview.value = URL.createObjectURL(file);
    emit("update-avatar", file);
  }
};
</script>
