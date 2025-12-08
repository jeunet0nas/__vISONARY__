<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white border-4 border-yellow-500 p-8">
      <div class="text-center mb-6">
        <div
          class="inline-flex items-center justify-center w-20 h-20 bg-yellow-500 rounded-full mb-4"
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
        <h1 class="text-2xl font-bold uppercase text-yellow-600 mb-2">
          Thanh toán đã hủy
        </h1>
        <p class="text-gray-600 mb-4">Bạn đã hủy quá trình thanh toán</p>
      </div>

      <div class="bg-yellow-50 border-2 border-yellow-200 p-4 mb-6">
        <p class="text-sm text-yellow-800 mb-2">
          <span class="font-semibold">⚠️ Lưu ý:</span>
        </p>
        <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
          <li>Không có đơn hàng nào được tạo khi bạn hủy thanh toán</li>
          <li>Giỏ hàng của bạn vẫn được lưu</li>
          <li>Bạn có thể quay lại để thử thanh toán lại bất cứ lúc nào</li>
        </ul>
      </div>

      <div class="border-t-2 border-gray-200 pt-4 mb-6">
        <p class="text-sm text-gray-600">
          💡 <span class="font-semibold">Mẹo:</span> Kiểm tra lại thông tin thẻ
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

      <!-- Help Section -->
      <div class="mt-8 pt-6 border-t-2 border-gray-200 text-center">
        <p class="text-sm text-gray-600 mb-2">Cần hỗ trợ?</p>
        <div class="flex justify-center gap-4 text-sm">
          <a
            href="mailto:support@visionary.com"
            class="text-blue-600 hover:underline"
          >
            📧 Email
          </a>
          <a href="tel:1900xxxx" class="text-blue-600 hover:underline">
            📞 Hotline
          </a>
        </div>
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
