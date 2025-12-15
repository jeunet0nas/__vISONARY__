<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white border-4 border-black p-8">
      <div class="text-center mb-6">
        <div
          class="inline-flex items-center justify-center w-20 h-20 bg-red-500 rounded-full mb-4"
        >
          <svg
            class="w-12 h-12 text-white"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="3"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            ></path>
          </svg>
        </div>
        <h1 class="text-2xl font-bold uppercase text-red-500 mb-2">
          Thanh toán đã hủy
        </h1>
        <p class="text-gray-600 mb-4">Bạn đã hủy quá trình thanh toán</p>
      </div>

      <div class="bg-red-100 border-2 border-red-500 p-4 mb-6">
        <p class="text-sm text-black mb-2">
          <span class="font-semibold">Một vài lưu ý:</span>
        </p>
        <ul class="text-sm text-black space-y-1 list-disc list-inside">
          <li>Giỏ hàng của bạn vẫn được lưu</li>
          <li>Bạn có thể quay lại để thử thanh toán lại bất cứ lúc nào</li>
        </ul>
      </div>

      <div class="border-t-2 border-gray-200 pt-4 mb-6">
        <p class="text-sm text-gray-600">
          <span class="font-semibold">Mẹo:</span> Kiểm tra lại thông tin thẻ
          hoặc thử phương thức thanh toán khác
        </p>
      </div>

      <div class="space-y-3">
        <button
          @click="retryCheckout"
          class="w-full bg-black text-white p-4 font-semibold uppercase hover:bg-gray-800 transition-colors"
        >
          Thử lại thanh toán
        </button>
        <button
          @click="goToCart"
          class="w-full border-2 border-black text-black p-4 font-semibold uppercase hover:bg-black hover:text-white transition-colors"
        >
          Quay về giỏ hàng
        </button>
        <button
          @click="goToHome"
          class="w-full text-gray-600 p-4 font-medium uppercase hover:text-black transition-colors"
        >
          Về trang chủ
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();

const retryCheckout = () => {
  router.push("/checkout");
};

const goToCart = () => {
  router.push("/cart");
};

const goToHome = () => {
  router.push("/");
};
</script>
