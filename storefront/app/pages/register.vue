<template>
  <div class="flex items-center justify-center min-h-screen bg-black">
    <div class="w-full max-w-md p-8 space-y-6 bg-white border-4 border-black">
      <h1 class="text-3xl font-bold text-center text-gray-900">
        seize
        <NuxtLink to="/" class="text-white hover:underline bg-black p-2"
          >VISIONARY</NuxtLink
        >
      </h1>

      <form class="space-y-6" @submit.prevent="handleRegister">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">
            Full Name
          </label>
          <div class="mt-1">
            <input
              id="name"
              name="name"
              type="text"
              autocomplete="name"
              class="w-full px-3 py-2 border border-black focus:outline-none focus:ring-black focus:border-black text-black"
              v-model="data.user.customer_name"
            />
            <ErrorMessage
              :error="authStore.validationErrors.customer_name?.[0]"
            />
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">
            Email address
          </label>
          <div class="mt-1">
            <input
              id="email"
              name="email"
              type="email"
              autocomplete="email"
              class="w-full px-3 py-2 border border-black focus:outline-none focus:ring-black focus:border-black text-black"
              v-model="data.user.email"
            />
            <ErrorMessage :error="authStore.validationErrors.email?.[0]" />
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">
            Password
          </label>
          <div class="mt-1 relative">
            <input
              id="password"
              name="password"
              :type="showPassword ? 'text' : 'password'"
              autocomplete="new-password"
              v-model="data.user.password"
              class="w-full px-3 py-2 border border-black focus:outline-none focus:ring-black focus:border-black pr-10 text-black"
            />
            <div class="mt-2 flex items-center">
              <label
                class="flex items-center space-x-2 cursor-pointer select-none"
              >
                <input
                  id="show-password"
                  type="checkbox"
                  v-model="showPassword"
                  class="sr-only peer"
                />
                <div
                  class="w-4 h-4 border border-black rounded-sm peer-checked:bg-black transition-colors duration-150"
                ></div>
                <span class="text-sm text-gray-700">Show password</span>
              </label>
            </div>
          </div>
          <ErrorMessage :error="authStore.validationErrors.password?.[0]" />
        </div>

        <div>
          <label
            for="password_confirmation"
            class="block text-sm font-medium text-gray-700"
          >
            Confirm Password
          </label>
          <div class="mt-1 relative">
            <input
              id="password_confirmation"
              name="password_confirmation"
              :type="showPasswordConfirm ? 'text' : 'password'"
              autocomplete="new-password"
              v-model="data.user.password_confirmation"
              class="w-full px-3 py-2 border border-black focus:outline-none focus:ring-black focus:border-black pr-10 text-black"
            />
            <div class="mt-2 flex items-center">
              <label
                class="flex items-center space-x-2 cursor-pointer select-none"
              >
                <input
                  id="show-password_confirm"
                  type="checkbox"
                  v-model="showPasswordConfirm"
                  class="sr-only peer"
                />
                <div
                  class="w-4 h-4 border border-black rounded-sm peer-checked:bg-black transition-colors duration-150"
                ></div>
                <span class="text-sm text-gray-700">Show password</span>
              </label>
            </div>
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="w-full px-4 py-2 text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black"
          >
            Sign Up
          </button>
        </div>
      </form>

      <p class="text-sm text-center text-gray-600">
        Already have an account?
        <NuxtLink
          onclick="handleRegister"
          to="/login"
          class="font-medium text-black hover:underline"
        >
          Sign in
        </NuxtLink>
      </p>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: "auth",
});

import axios from "axios";
import { ref } from "vue";
import ErrorMessage from "~/components/shared/ErrorMessage.vue";
import { BASE_URL } from "~/helpers/config";
import { useAuthStore } from "~/stores/useAuthStore";
const showPassword = ref(false);
const showPasswordConfirm = ref(false);

const toast = useToast();
const router = useRouter();
const authStore = useAuthStore();
const data = reactive({
  user: {
    customer_name: "",
    email: "",
    password: "",
    password_confirmation: "",
  },
});

onMounted(() => authStore.clearValidationErrors());

const handleRegister = async () => {
  if (data.user.password !== data.user.password_confirmation) {
    toast.add({
      title: "Lỗi",
      description: "Mật khẩu và xác nhận mật khẩu không trùng khớp.",
      color: "error",
    });
    return;
  }
  authStore.clearValidationErrors();
  authStore.isLoading = true;

  try {
    const res = await axios.post(`${BASE_URL}/user/register`, data.user);
    toast.add({
      title: "Thành công",
      description: res.data.message,
      color: "success",
    });
    router.push("/login");
  } catch (error) {
    if (error.response && error.response.status === 422) {
      authStore.setValidationErrors(error.response.data.errors);
    }
  } finally {
    authStore.isLoading = false;
  }
};
</script>
