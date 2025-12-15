<template>
  <PageHeader title="__your's info__" />
  <main class="min-h-screen bg-white text-black pt-24 pb-20">
    <div class="container mx-auto px-4 max-w-6xl">
      <div
        class="flex flex-col lg:flex-row border border-black shadow-none min-h-[600px]"
      >
        <Sidebar
          :user="user"
          @update-avatar="handleUpdateAvatar"
          @logout="handleLogout"
        />

        <InfoForm
          :user-data="user"
          :loading="authStore.isLoading"
          :server-errors="authStore.validationErrors"
          @submit-info="handleUpdateInfo"
        />
      </div>
    </div>
  </main>
</template>

<script setup>
import { onMounted } from "vue";
import { storeToRefs } from "pinia";
import Sidebar from "~/components/profile/Sidebar.vue";
import InfoForm from "~/components/profile/InfoForm.vue";
import PageHeader from "~/components/shared/PageHeader.vue";
import { useAuthStore } from "~/stores/useAuthStore";
import axios from "axios";
import { BASE_URL, headersConfig } from "~/helpers/config";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const router = useRouter();
const toast = useToast();

const handleUpdateAvatar = async (file) => {
  authStore.clearValidationErrors();
  authStore.isLoading = true;

  const config = headersConfig(authStore.access_token);
  delete config.headers["Content-type"];

  const formData = new FormData();
  formData.append("profile_img", file);
  formData.append("_method", "PUT");

  try {
    const res = await axios.post(
      `${BASE_URL}/user/profile/update`,
      formData,
      headersConfig(authStore.access_token, formData, config)
    );

    authStore.setUser(res.data.user);
    toast.add({
      title: "Thành công!",
      description: res.data.message,
      color: "success",
    });
  } catch (error) {
    console.error("Upload failed:", error);
    if (error?.response?.status === 422) {
      authStore.setValidationErrors(error.response.data.errors);
    }
    toast.add({
      title: "Thất bại",
      description: "Ảnh có định dạng không hợp lệ!",
      color: "error",
    });
  } finally {
    authStore.isLoading = false;
  }
};

const handleUpdateInfo = async (formDataPayload) => {
  authStore.clearValidationErrors();
  authStore.isLoading = true;

  try {
    const res = await axios.put(
      `${BASE_URL}/user/profile/update`,
      formDataPayload,
      headersConfig(authStore.access_token)
    );

    authStore.setUser(res.data.user);
    toast.add({
      title: "Thành công!",
      description: res.data.message,
      color: "success",
    });
  } catch (error) {
    console.error("Update info failed:", error);
    if (error?.response?.status === 422) {
      authStore.setValidationErrors(error.response.data.errors);
    } else {
      alert("Có lỗi xảy ra. Vui lòng thử lại.");
    }
  } finally {
    authStore.isLoading = false;
  }
};

const handleLogout = async () => {
  try {
    await axios.post(
      `${BASE_URL}/user/logout`,
      null,
      headersConfig(authStore.access_token)
    );

    toast.add({
      title: "Đăng xuất thành công",
      description: "Hẹn gặp lại bạn !",
      color: "info",
    });
  } catch (error) {
    console.error("Logout error:", error);
  } finally {
    authStore.clearAuthData();
    router.push("/login");
  }
};

onMounted(() => {
  authStore.clearValidationErrors();
});

definePageMeta({
  middleware: "auth",
});

useHead({
  title: "Hồ sơ cá nhân | VISIONARY",
  meta: [
    {
      name: "description",
      content: "Quản lý thông tin tài khoản",
    },
  ],
});
</script>
