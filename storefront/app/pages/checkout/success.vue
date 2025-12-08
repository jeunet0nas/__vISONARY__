<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
      <!-- Loading State -->
      <div
        v-if="isVerifying"
        class="bg-white border-4 border-black p-8 text-center"
      >
        <div class="flex justify-center mb-4">
          <div
            class="w-16 h-16 border-4 border-black border-t-transparent rounded-full animate-spin"
          ></div>
        </div>
        <h2 class="text-xl font-bold uppercase mb-2">Đang xác thực...</h2>
        <p class="text-gray-600">Vui lòng đợi trong giây lát</p>
        <p v-if="retryCount > 0" class="text-sm text-gray-500 mt-2">
          Đang xử lý ({{ retryCount }}/{{ maxRetries }})
        </p>
      </div>

      <!-- Success State -->
      <div
        v-else-if="paymentSuccess"
        class="bg-white border-4 border-green-600 p-8"
      >
        <div class="text-center mb-6">
          <div
            class="inline-flex items-center justify-center w-20 h-20 bg-green-600 rounded-full mb-4"
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
                d="M5 13l4 4L19 7"
              ></path>
            </svg>
          </div>
          <h1 class="text-2xl font-bold uppercase text-green-600 mb-2">
            Thanh toán thành công!
          </h1>
          <p class="text-gray-600 mb-4">Cảm ơn bạn đã mua hàng tại Visionary</p>
        </div>

        <div
          v-if="orderInfo"
          class="border-t-2 border-gray-200 pt-6 mb-6 space-y-3"
        >
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Mã đơn hàng:</span>
            <span class="font-bold">#{{ orderInfo.id }}</span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Trạng thái:</span>
            <span
              class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold uppercase rounded"
            >
              {{ orderInfo.status }}
            </span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Tổng tiền:</span>
            <span class="font-bold text-lg"
              >{{ formatPrice(orderInfo.total) }}đ</span
            >
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Khách hàng:</span>
            <span class="font-medium">{{ orderInfo.customer_name }}</span>
          </div>
        </div>

        <div class="bg-blue-50 border-2 border-blue-200 p-4 mb-6">
          <p class="text-sm text-blue-800">
            <span class="font-semibold">📧 Email xác nhận</span> đã được gửi đến
            địa chỉ email của bạn.
          </p>
        </div>

        <div class="space-y-3">
          <button
            @click="goToOrders"
            class="w-full bg-black text-white p-4 font-semibold uppercase hover:bg-gray-800 transition-colors"
          >
            Xem đơn hàng
          </button>
          <button
            @click="goToHome"
            class="w-full border-2 border-black text-black p-4 font-semibold uppercase hover:bg-black hover:text-white transition-colors"
          >
            Tiếp tục mua sắm
          </button>
        </div>
      </div>

      <!-- Error State -->
      <div v-else class="bg-white border-4 border-red-600 p-8">
        <div class="text-center mb-6">
          <div
            class="inline-flex items-center justify-center w-20 h-20 bg-red-600 rounded-full mb-4"
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
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </div>
          <h1 class="text-2xl font-bold uppercase text-red-600 mb-2">
            Có lỗi xảy ra
          </h1>
          <p class="text-gray-600 mb-4">
            {{
              errorMessage ||
              "Không thể xác thực thanh toán. Vui lòng liên hệ hỗ trợ."
            }}
          </p>
        </div>

        <div class="space-y-3">
          <button
            @click="goToOrders"
            class="w-full bg-black text-white p-4 font-semibold uppercase hover:bg-gray-800 transition-colors"
          >
            Kiểm tra đơn hàng
          </button>
          <button
            @click="goToHome"
            class="w-full border-2 border-black text-black p-4 font-semibold uppercase hover:bg-black hover:text-white transition-colors"
          >
            Về trang chủ
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useCartStore } from "~/stores/useCartStore";
import { useAuthStore } from "~/stores/useAuthStore";
import axios from "axios";
import { BASE_URL, headersConfig } from "~/helpers/config";

const router = useRouter();
const route = useRoute();
const cartStore = useCartStore();
const authStore = useAuthStore();

const isVerifying = ref(true);
const paymentSuccess = ref(false);
const orderInfo = ref(null);
const errorMessage = ref("");
const retryCount = ref(0);
const maxRetries = 3;

const formatPrice = (price) => {
  return new Intl.NumberFormat("vi-VN").format(price);
};

const verifyPayment = async () => {
  const sessionId = route.query.session_id;

  if (!sessionId) {
    errorMessage.value = "Không tìm thấy thông tin phiên thanh toán";
    isVerifying.value = false;
    return;
  }

  try {
    const res = await axios.post(
      `${BASE_URL}/stripe/verify-session`,
      { session_id: sessionId },
      headersConfig(authStore.access_token)
    );

    if (res.data.success) {
      // Kiểm tra nếu order đã được tạo bởi webhook
      if (res.data.order) {
        paymentSuccess.value = true;
        orderInfo.value = res.data.order;

        // Clear cart sau khi xác nhận thành công
        cartStore.$reset();
        isVerifying.value = false;
      } else {
        // Webhook chưa chạy xong, retry sau 2 giây
        if (retryCount.value < maxRetries) {
          retryCount.value++;
          console.log(
            `Webhook chưa xong, retry lần ${retryCount.value}/${maxRetries}...`
          );
          setTimeout(() => {
            verifyPayment();
          }, 2000);
        } else {
          // Đã retry max lần, vẫn chưa có order
          errorMessage.value =
            'Đơn hàng đang được xử lý. Vui lòng kiểm tra lại trong "Đơn hàng của tôi" sau vài phút.';
          isVerifying.value = false;
          // Vẫn clear cart vì payment đã thành công trên Stripe
          cartStore.$reset();
        }
      }
    } else {
      errorMessage.value = res.data.message || "Không thể xác thực thanh toán";
      isVerifying.value = false;
    }
  } catch (error) {
    console.error("Verify payment error:", error);
    errorMessage.value = error.response?.data?.message || "Lỗi kết nối server";
    isVerifying.value = false;
  }
};

const goToOrders = () => {
  router.push("/profile/orders");
};

const goToHome = () => {
  router.push("/");
};

onMounted(() => {
  verifyPayment();
});
</script>
