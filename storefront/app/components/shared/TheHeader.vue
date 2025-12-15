<template>
  <header class="bg-white sticky top-0 z-50 w-full border-2 border-black">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid h-16 grid-cols-10">
        <div class="col-span-2 flex items-center justify-start gap-6">
          <NuxtLink
            to="/category"
            class="text-xs lg:text-sm font-medium tracking-wider uppercase transition-colors hover:text-gray-500 text-black"
          >
            ALL
          </NuxtLink>
          <NuxtLink
            v-if="collectionsStore.collections.length"
            :to="`/collections/${collectionsStore.collections[0].slug}`"
            class="text-xs lg:text-sm font-medium tracking-wider uppercase transition-colors hover:text-gray-500 text-black"
          >
            COLL.
          </NuxtLink>
        </div>

        <div
          class="col-span-6 h-full border-l-0 md:border-l-2 border-r-0 md:border-r-2 border-black flex items-center justify-center"
        >
          <NuxtLink
            to="/"
            class="text-2xl lg:text-5xl font-bold tracking-wider uppercase text-black"
          >
            VISIONARY
          </NuxtLink>
        </div>

        <div class="col-span-2 flex items-center justify-end gap-6">
          <ClientOnly>
            <template #fallback>
              <span
                class="text-xs lg:text-sm font-medium tracking-wider uppercase text-black"
                >...</span
              >
            </template>

            <div
              v-if="authStore.access_token && authStore.user"
              class="flex items-center gap-4"
            >
              <NuxtLink
                to="/profile"
                class="text-xs lg:text-sm font-bold tracking-wider uppercase text-black hover:underline truncate max-w-20 lg:max-w-[120px]"
                :title="authStore.user.customer_name"
              >
                <Icon name="uil:user" style="color: black" />
              </NuxtLink>
            </div>

            <NuxtLink
              v-else
              to="/login"
              class="text-xs lg:text-sm font-medium tracking-wider uppercase transition-colors hover:text-gray-500 text-black"
            >
              Login
            </NuxtLink>
          </ClientOnly>

          <button
            type="button"
            @click="cartStore.openCart"
            class="text-xs lg:text-sm font-medium tracking-wider uppercase transition-colors hover:text-gray-500 text-black"
          >
            Bag [{{ cartStore.itemCount }}]
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useCartStore } from "~/stores/useCartStore";
import { useCollectionsStore } from "~/stores/useCollectionsStore";
import { useAuthStore } from "~/stores/useAuthStore";
import { headersConfig, BASE_URL } from "~/helpers/config";
import axios from "axios";

const cartStore = useCartStore();
const authStore = useAuthStore();
const collectionsStore = useCollectionsStore();
const toast = useToast();
const router = useRouter();

onMounted(() => {
  if (!collectionsStore.collections.length) {
    collectionsStore.fetchCollections();
  }
});

const handleLogout = async () => {
  try {
    await axios.post(
      `${BASE_URL}/user/logout`,
      null,
      headersConfig(authStore.access_token)
    );

    toast.add({
      title: "Đăng xuất thành công",
      description: "Hẹn gặp lại bạn sớm!",
      color: "info",
    });
  } catch (error) {
    console.error("Logout API error:", error);
  } finally {
    authStore.clearAuthData();
    router.push("/login");
  }
};
</script>
