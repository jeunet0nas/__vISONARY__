<template>
  <main class="min-h-screen bg-white text-black pt-24 pb-20">
    <div class="container mx-auto px-4 max-w-6xl">
      <div class="flex flex-col lg:flex-row border border-black min-h-[600px]">
        <Sidebar :user="user" active-menu="password" />

        <div
          class="flex-1 relative bg-white lg:border-l border-black flex flex-col"
        >
          <div
            class="p-8 border-b border-black flex justify-between items-end bg-gray-50"
          >
            <div>
              <h2 class="text-2xl font-black uppercase tracking-tighter mb-1">
                Thay đổi mật khẩu
              </h2>
            </div>
          </div>

          <TheLoader
            v-if="isLoading"
            variant="section"
            text="ENCRYPTING DATA"
          />

          <div class="flex-1 p-8 lg:p-12 flex flex-col justify-center">
            <div class="max-w-2xl mx-auto w-full">
              <form @submit.prevent="handleChangePassword" class="space-y-8">
                <div class="group">
                  <div class="flex justify-between mb-2">
                    <label class="text-xs font-bold uppercase tracking-widest">
                      Current Key
                    </label>
                    <button
                      type="button"
                      @click="showCurrent = !showCurrent"
                      class="text-[10px] font-mono text-gray-400 hover:text-black uppercase hover:underline"
                    >
                      {{ showCurrent ? "[ MASK ]" : "[ REVEAL ]" }}
                    </button>
                  </div>
                  <div class="relative">
                    <input
                      v-model="form.current_password"
                      :type="showCurrent ? 'text' : 'password'"
                      class="w-full bg-gray-50 border-b border-black py-3 px-4 text-sm font-mono focus:outline-none focus:bg-black focus:text-white transition-colors placeholder-gray-400"
                      placeholder="ENTER CURRENT PASSWORD"
                      :class="{
                        'border-red-500 bg-red-50':
                          errors && errors.current_password,
                      }"
                    />
                    <div
                      class="absolute top-0 right-0 w-2 h-2 border-t border-r border-black opacity-20 group-hover:opacity-100 transition-opacity"
                    ></div>
                  </div>
                  <p
                    v-if="errors && errors.current_password"
                    class="mt-1 text-[10px] text-red-600 font-mono font-bold uppercase"
                  >
                    :: {{ errors.current_password[0] }}
                  </p>
                </div>

                <div
                  class="space-y-6 pt-4 border-t border-dashed border-gray-300"
                >
                  <div class="group">
                    <div class="flex justify-between mb-2">
                      <label
                        class="text-xs font-bold uppercase tracking-widest"
                      >
                        New Key
                      </label>
                      <button
                        type="button"
                        @click="showNew = !showNew"
                        class="text-[10px] font-mono text-gray-400 hover:text-black uppercase hover:underline"
                      >
                        {{ showNew ? "[ MASK ]" : "[ REVEAL ]" }}
                      </button>
                    </div>
                    <input
                      v-model="form.new_password"
                      :type="showNew ? 'text' : 'password'"
                      class="w-full bg-gray-50 border-b border-black py-3 px-4 text-sm font-mono focus:outline-none focus:bg-black focus:text-white transition-colors placeholder-gray-400"
                      placeholder="ENTER NEW PASSWORD (MIN 8 CHARS)"
                      :class="{
                        'border-red-500 bg-red-50':
                          errors && errors.new_password,
                      }"
                    />
                    <p
                      v-if="errors && errors.new_password"
                      class="mt-1 text-[10px] text-red-600 font-mono font-bold uppercase"
                    >
                      :: {{ errors.new_password[0] }}
                    </p>
                  </div>

                  <div class="group">
                    <label
                      class="block text-xs font-bold uppercase tracking-widest mb-2"
                    >
                      Confirm Key
                    </label>
                    <input
                      v-model="form.new_password_confirmation"
                      type="password"
                      class="w-full bg-gray-50 border-b border-black py-3 px-4 text-sm font-mono focus:outline-none focus:bg-black focus:text-white transition-colors placeholder-gray-400"
                      placeholder="REPEAT NEW PASSWORD"
                    />
                  </div>
                </div>

                <div class="pt-8 flex items-center justify-end">
                  <button
                    type="submit"
                    class="bg-black text-white px-8 py-4 text-xs font-black uppercase tracking-[0.2em] border border-black hover:bg-white hover:text-black transition-all flex items-center gap-4 group"
                    :disabled="isLoading"
                  >
                    <span>Cập nhật mật khẩu</span>
                    <Icon
                      name="mdi:arrow-right"
                      class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                    />
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div
            class="p-2 border-t border-black bg-white flex justify-end text-[10px] font-mono text-gray-500 uppercase"
          >
            <span>ID: {{ user?.customer_id || "GUEST" }}</span>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, reactive } from "vue";
import { storeToRefs } from "pinia";
import Sidebar from "~/components/profile/Sidebar.vue";
import TheLoader from "~/components/shared/TheLoader.vue";
import { useAuthStore } from "~/stores/useAuthStore";
import axios from "axios";
import { BASE_URL, headersConfig } from "~/helpers/config";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const toast = useToast();

const isLoading = ref(false);
const showCurrent = ref(false);
const showNew = ref(false);

const form = reactive({
  current_password: "",
  new_password: "",
  new_password_confirmation: "",
});

const errors = ref({});

const handleChangePassword = async () => {
  errors.value = {};

  if (form.new_password !== form.new_password_confirmation) {
    toast.add({
      title: "ERROR: MISMATCH",
      description: "New password confirmation does not match.",
      color: "error",
    });
    return;
  }

  isLoading.value = true;

  try {
    await new Promise((r) => setTimeout(r, 1000));

    const payload = {
      current_password: form.current_password,
      new_password: form.new_password,
      new_password_confirmation: form.new_password_confirmation,
    };

    const res = await axios.put(
      `${BASE_URL}/user/change-password`,
      payload,
      headersConfig(authStore.access_token)
    );

    toast.add({
      title: "SYSTEM UPDATE",
      description: "Password credentials updated successfully.",
      color: "success",
    });

    form.current_password = "";
    form.new_password = "";
    form.new_password_confirmation = "";
  } catch (error) {
    console.error("Password update error:", error);

    if (error?.response?.status === 422) {
      toast.add({
        title: "Mật khẩu không đúng",
        description: "Mật khẩu cũ không hợp lệ!",
        color: "error",
      });
    } else {
      toast.add({
        title: "FATAL ERROR",
        description: error.response?.data?.message || "Connection interrupted.",
        color: "error",
      });
    }
  } finally {
    isLoading.value = false;
  }
};

definePageMeta({
  middleware: "auth",
});

useHead({
  title: "Đổi mật khẩu | VISIONARY",
  meta: [{ name: "description", content: "Thay đổi mật khẩu tài khoản" }],
});
</script>

<style scoped>
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
  -webkit-box-shadow: 0 0 0 30px #f9fafb inset !important;
  -webkit-text-fill-color: #000 !important;
  transition: background-color 5000s ease-in-out 0s;
}

input:focus:-webkit-autofill {
  -webkit-box-shadow: 0 0 0 30px #000 inset !important;
  -webkit-text-fill-color: #fff !important;
}
</style>
