<template>
  <div class="flex items-center justify-center min-h-screen bg-black">
    <div class="w-full max-w-md p-8 space-y-6 bg-white border-4 border-black">
      <h1 class="text-3xl font-bold text-center text-gray-900">
        enter
        <NuxtLink to="/" class="text-white hover:underline bg-black p-2"
          >VISIONARY</NuxtLink
        >
      </h1>

      <form class="space-y-6" @submit.prevent="handleLogin">
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
              v-model="data.user.email"
              class="w-full px-3 py-2 border border-black focus:outline-none focus:ring-black focus:border-black text-black"
            />
            <ErrorMessage :error="authStore.validationErrors.email?.[0]" />
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">
            Password
          </label>
          <div class="mt-1">
            <input
              id="password"
              name="password"
              :type="showPassword ? 'text' : 'password'"
              autocomplete="current-password"
              v-model="data.user.password"
              class="w-full px-3 py-2 border border-black focus:outline-none focus:ring-black focus:border-black text-black"
            />
          </div>
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
          <ErrorMessage :error="authStore.validationErrors.password?.[0]" />
        </div>

        <div class="flex items-center justify-end">
          <div class="text-sm">
            <a href="#" class="font-medium text-black hover:underline">
              Forgot your password?
            </a>
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="w-full px-4 py-2 text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black"
          >
            Sign In
          </button>
        </div>
      </form>

      <p class="text-sm text-center text-gray-600">
        Don't have an account?
        <NuxtLink to="/register" class="font-medium text-black hover:underline">
          Sign up
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
const showPassword = ref(false);

const authStore = useAuthStore();
const router = useRouter();

const data = reactive({
  user: {
    email: "",
    password: "",
  },
});

onMounted(() => authStore.clearValidationErrors());

const handleLogin = async () => {
  authStore.clearValidationErrors();
  authStore.isLoading = true;
  try {
    const res = await axios.post(`${BASE_URL}/user/login`, data.user);
    if (res.data.error) {
      toast.add({
        title: "Đăng nhập thất bại!",
        description: res.data.error,
        color: "error",
      });
    } else {
      authStore.setIsLoggedIn();
      authStore.setUser(res.data.user);
      authStore.setToken(res.data.access_token);
      toast.add({
        title: "Đăng nhập thành công!",
        description: res.data.message,
        color: "success",
      });
      router.push("/");
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      authStore.setValidationErrors(error.response.data.errors);
    }
  } finally {
    authStore.isLoading = false;
  }
};
</script>
