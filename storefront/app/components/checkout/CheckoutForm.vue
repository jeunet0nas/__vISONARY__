<template>
  <form
    @submit.prevent="handleSubmit"
    class="bg-gray-100 border border-black p-4 lg:p-6"
  >
    <div class="mb-6 text-black">
      <h2 class="text-xl font-semibold uppercase mb-4">THÔNG TIN VẬN CHUYỂN</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
        <div class="md:col-span-2">
          <label
            for="fullName"
            class="block text-xs font-medium uppercase mb-1"
          >
            Họ và Tên (Full Name)
          </label>
          <input
            id="fullName"
            v-model="formData.fullName"
            type="text"
            class="w-full border border-black p-3 text-sm focus:outline-none focus:bg-white transition-colors"
            placeholder="Ví dụ: Nguyen Van A"
            required
          />
        </div>

        <div>
          <label for="email" class="block text-xs font-medium uppercase mb-1">
            Email
          </label>
          <input
            id="email"
            v-model="formData.email"
            type="email"
            class="w-full border border-black p-3 text-sm focus:outline-none focus:bg-white transition-colors"
            required
          />
        </div>

        <div>
          <label for="phone" class="block text-xs font-medium uppercase mb-1">
            Số điện thoại
          </label>
          <input
            id="phone"
            v-model="formData.phone_number"
            type="tel"
            class="w-full border border-black p-3 text-sm focus:outline-none focus:bg-white transition-colors"
            required
          />
        </div>

        <div class="md:col-span-2">
          <label for="address" class="block text-xs font-medium uppercase mb-1">
            Địa chỉ (Số nhà, Tên đường)
          </label>
          <input
            id="address"
            v-model="formData.address"
            type="text"
            placeholder="Ví dụ: 123 Đường Lê Lợi"
            class="w-full border border-black p-3 text-sm focus:outline-none focus:bg-white transition-colors"
            required
          />
        </div>

        <div>
          <label
            for="province"
            class="block text-xs font-medium uppercase mb-1"
          >
            Phường / Xã / Quận
          </label>
          <input
            id="province"
            v-model="formData.province"
            type="text"
            placeholder="Nhập phường, xã..."
            class="w-full border border-black p-3 text-sm focus:outline-none focus:bg-white transition-colors"
            required
          />
        </div>

        <div>
          <label for="city" class="block text-xs font-medium uppercase mb-1">
            Tỉnh / Thành phố
          </label>
          <input
            id="city"
            v-model="formData.city"
            type="text"
            placeholder="Nhập tỉnh, thành phố..."
            class="w-full border border-black p-3 text-sm focus:outline-none focus:bg-white transition-colors"
            required
          />
        </div>
      </div>
    </div>

    <hr class="border-black my-6" />

    <div class="mb-6">
      <h2 class="text-xl font-semibold uppercase text-black mb-4">
        PAYMENT METHOD
      </h2>
      <div class="space-y-3">
        <label
          class="flex items-center border p-4 cursor-pointer transition-colors"
          :class="{
            'border-black': formData.paymentMethod === 'cod',
            'border-gray-300': formData.paymentMethod !== 'cod',
          }"
        >
          <input
            type="radio"
            v-model="formData.paymentMethod"
            value="cod"
            class="peer hidden"
          />
          <span
            class="w-5 h-5 mr-3 border-2 rounded-none flex items-center justify-center transition-colors"
            :class="
              formData.paymentMethod === 'cod'
                ? 'border-black bg-black'
                : 'border-gray-300 bg-white'
            "
          >
            <span
              class="block w-2.5 h-2.5 transition-opacity"
              :class="
                formData.paymentMethod === 'cod' ? 'opacity-100' : 'opacity-0'
              "
            ></span>
          </span>
          <span
            class="font-medium transition-colors"
            :class="
              formData.paymentMethod === 'cod' ? 'text-black' : 'text-gray-400'
            "
          >
            Thanh toán khi nhận hàng (COD)
          </span>
        </label>

        <label
          class="flex items-center border p-4 cursor-pointer transition-colors"
          :class="{
            'border-black': formData.paymentMethod === 'qr',
            'border-gray-300': formData.paymentMethod !== 'qr',
          }"
        >
          <input
            type="radio"
            v-model="formData.paymentMethod"
            value="qr"
            class="peer hidden"
          />
          <span
            class="w-5 h-5 mr-3 border-2 rounded-none flex items-center justify-center transition-colors"
            :class="
              formData.paymentMethod === 'qr'
                ? 'border-black bg-black'
                : 'border-gray-300 bg-white'
            "
          >
            <span
              class="block w-2.5 h-2.5 transition-opacity"
              :class="
                formData.paymentMethod === 'qr' ? 'opacity-100' : 'opacity-0'
              "
            ></span>
          </span>
          <span
            class="font-medium transition-colors"
            :class="
              formData.paymentMethod === 'qr' ? 'text-black' : 'text-gray-400'
            "
          >
            Thanh toán qua QR / Banking
          </span>
        </label>
      </div>
    </div>

    <div class="mb-6 text-black">
      <h2 class="text-xl font-semibold uppercase mb-4">DISCOUNT CODE</h2>
      <div class="flex gap-x-2">
        <input
          v-model="couponCode"
          type="text"
          placeholder="Enter coupon"
          class="w-full border border-black p-3 text-sm focus:outline-none"
          :disabled="!!cartStore.appliedCoupon"
        />
        <button
          type="button"
          @click="handleApplyCoupon"
          :disabled="!!cartStore.appliedCoupon"
          class="bg-black text-white p-3 px-6 font-semibold uppercase hover:bg-gray-800 disabled:bg-gray-400"
        >
          APPLY
        </button>
      </div>
      <p v-if="couponError" class="text-red-600 text-sm mt-2">
        {{ couponError }}
      </p>
    </div>

    <hr class="border-black my-6" />

    <div>
      <button
        type="submit"
        :disabled="!isFormValid || isLoading"
        class="w-full bg-black text-white p-4 font-semibold uppercase mt-6 hover:bg-gray-800 disabled:bg-gray-400 disabled:cursor-not-allowed flex justify-center items-center gap-2"
      >
        <span
          v-if="isLoading"
          class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"
        ></span>
        {{ isLoading ? "PROCESSING..." : "CHECKOUT" }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { storeToRefs } from "pinia";
import { useCartStore } from "~/stores/useCartStore";
import { useAuthStore } from "~/stores/useAuthStore";
import { useRouter } from "vue-router";
import axios from "axios";
import { BASE_URL, headersConfig } from "~/helpers/config";

const cartStore = useCartStore();
const authStore = useAuthStore();
const { user, isLoggedIn } = storeToRefs(authStore);
const router = useRouter();

const isLoading = ref(false);
const couponCode = ref("");
const couponError = ref(null);

// --- 1. FORM DATA ---
// Gọn gàng hơn rất nhiều: firstName + lastName -> fullName
const formData = ref({
  fullName: "",
  email: "",
  phone_number: "",
  address: "",
  province: "",
  city: "",
  paymentMethod: "cod",
});

// --- 2. LOGIC AUTO-FILL (Đơn giản hóa) ---
const fillUserData = () => {
  if (isLoggedIn.value && user.value) {
    const u = user.value;

    // Map trực tiếp 1-1, không cần split/join nữa
    formData.value.fullName = u.customer_name || "";
    formData.value.email = u.email || "";
    formData.value.phone_number = u.phone_number || "";
    formData.value.address = u.address || "";
    formData.value.province = u.province || "";
    formData.value.city = u.city || "";
  }
};

onMounted(fillUserData);
watch(user, fillUserData);

// --- 3. VALIDATION ---
const isFormValid = computed(() => {
  const f = formData.value;
  return (
    f.fullName && // Check fullName
    f.email &&
    f.address &&
    f.phone_number &&
    f.province &&
    f.city
  );
});

// --- 4. SUBMIT LOGIC ---
const handleSubmit = async () => {
  if (!isFormValid.value) {
    alert("Vui lòng điền đầy đủ thông tin giao hàng.");
    return;
  }

  isLoading.value = true;

  try {
    // Ghép địa chỉ full string
    const fullAddress = [
      formData.value.address,
      formData.value.province,
      formData.value.city,
    ]
      .filter(Boolean)
      .join(", ");

    const orderPayload = {
      user_id: isLoggedIn.value ? user.value.id : null,

      // Gửi thẳng fullName vào customer_name
      customer_name: formData.value.fullName,
      customer_email: formData.value.email,
      customer_phone: formData.value.phone_number,
      shipping_address: fullAddress,

      shipping_details: {
        city: formData.value.city,
        province: formData.value.province,
        address: formData.value.address,
        phone_number: formData.value.phone_number,
      },

      items: cartStore.items.map((item) => ({
        product_id: item.product.id,
        quantity: item.quantity,
        price: item.product.price,
      })),

      subtotal: cartStore.subtotal,
      discount_amount: cartStore.discountAmount,
      coupon_code: cartStore.appliedCoupon
        ? cartStore.appliedCoupon.code
        : null,
      total_amount: cartStore.finalSubtotal,
      payment_method: formData.value.paymentMethod,
    };

    console.log("--- SENDING PAYLOAD ---", orderPayload);

    // Gọi API (Chỉ 1 lần gọi)
    const config = isLoggedIn.value
      ? headersConfig(authStore.access_token)
      : {};
    const res = await axios.post(`${BASE_URL}/orders`, orderPayload, config);

    alert("Đặt hàng thành công! Mã đơn: " + res.data.order_code);
    cartStore.$reset();
    router.push("/profile/orders");
  } catch (error) {
    console.error(error);
    const msg =
      error.response?.data?.message || "Có lỗi xảy ra, vui lòng thử lại.";
    alert(msg);
  } finally {
    isLoading.value = false;
  }
};

const handleApplyCoupon = async () => {
  couponError.value = null;
  if (!couponCode.value.trim()) {
    couponError.value = "Vui lòng nhập mã.";
    return;
  }
  try {
    await cartStore.applyCoupon(couponCode.value);
    couponCode.value = "";
  } catch (error) {
    couponError.value = error.message;
  }
};
</script>
