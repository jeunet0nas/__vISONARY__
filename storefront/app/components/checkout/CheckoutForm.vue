<template>
  <form
    @submit.prevent="handleSubmit"
    class="bg-gray-100 border border-black p-4 lg:p-6"
  >
    <div class="mb-6 text-black">
      <h2 class="text-xl font-semibold uppercase mb-4">DELIVERY OPTIONS</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
        <div>
          <label
            for="firstName"
            class="block text-xs font-medium uppercase mb-1"
          >
            First Name
          </label>
          <input
            id="firstName"
            v-model="formData.firstName"
            type="text"
            class="w-full border border-black p-3 text-sm"
            required
          />
        </div>

        <div>
          <label
            for="lastName"
            class="block text-xs font-medium uppercase mb-1"
          >
            Last Name
          </label>
          <input
            id="lastName"
            v-model="formData.lastName"
            type="text"
            class="w-full border border-black p-3 text-sm"
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
            class="w-full border border-black p-3 text-sm"
            required
          />
        </div>

        <div>
          <label for="phone" class="block text-xs font-medium uppercase mb-1">
            Phone Number
          </label>
          <input
            id="phone"
            v-model="formData.phone"
            type="tel"
            class="w-full border border-black p-3 text-sm"
            required
          />
        </div>

        <div class="md:col-span-2">
          <label for="address" class="block text-xs font-medium uppercase mb-1">
            Shipping
          </label>
          <input
            id="address"
            v-model="formData.address"
            type="text"
            placeholder="Address"
            class="w-full border border-black p-3 text-sm"
            required
          />
        </div>

        <div>
          <label
            for="postalCode"
            class="block text-xs font-medium uppercase mb-1 sr-only"
          >
            Postal Code
          </label>
          <input
            id="postalCode"
            v-model="formData.postalCode"
            type="text"
            placeholder="Postal Code"
            class="w-full border border-black p-3 text-sm"
            required
          />
        </div>

        <div>
          <label
            for="city"
            class="block text-xs font-medium uppercase mb-1 sr-only"
          >
            City
          </label>
          <input
            id="city"
            v-model="formData.city"
            type="text"
            placeholder="City"
            class="w-full border border-black p-3 text-sm"
            required
          />
        </div>

        <div class="md:col-span-2">
          <label
            for="country"
            class="block text-xs font-medium uppercase mb-1 sr-only"
          >
            Country
          </label>
          <input
            id="country"
            v-model="formData.country"
            type="text"
            placeholder="Country"
            class="w-full border border-black p-3 text-sm"
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
            Thanh toán qua QR
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
          class="w-full border border-black p-3 text-sm"
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
        :disabled="!isFormValid"
        class="w-full bg-black text-white p-4 font-semibold uppercase mt-6 hover:bg-gray-800 disabled:bg-gray-400 disabled:cursor-not-allowed"
      >
        CHECKOUT
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, computed } from "vue";
import { useCartStore } from "~/stores/useCartStore";

const cartStore = useCartStore();
const couponCode = ref("");
const couponError = ref(null);

const formData = ref({
  firstName: "",
  lastName: "",
  email: "",
  phone: "",
  address: "",
  postalCode: "",
  city: "",
  country: "",
  paymentMethod: "cod",
});

const isFormValid = computed(() => {
  const requiredFields = [
    formData.value.firstName,
    formData.value.lastName,
    formData.value.email,
    formData.value.address,
    formData.value.phone,
    formData.value.postalCode,
    formData.value.city,
    formData.value.country,
  ];

  return requiredFields.every((field) => field && field.trim() !== "");
});

const handleSubmit = () => {
  if (!isFormValid.value) {
    alert("Vui lòng điền đầy đủ thông tin giao hàng.");
    return;
  }

  const orderPayload = {
    customerDetails: { ...formData.value },
    cartItems: cartStore.items.map((item) => ({
      id: item.product.id,
      name: item.product.name,
      quantity: item.quantity,
      price: item.product.price,
    })),
    total: cartStore.subtotal,
  };

  console.log("--- SUBMITTING ORDER ---", orderPayload);
  alert("Đơn hàng đã được gửi đi (Kiểm tra Console Log)!");
};

const handleApplyCoupon = async () => {
  console.log(1);
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
