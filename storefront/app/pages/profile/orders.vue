<template>
  <PageHeader title="__your orders__" />

  <div class="container mx-auto px-4 py-8 min-h-screen">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <div class="lg:col-span-7">
        <div
          class="bg-white border-2 border-black p-0 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all"
        >
          <div class="p-6 border-b-2 border-black bg-white">
            <h3
              class="text-xl font-black uppercase flex items-center tracking-wider text-black"
            >
              <Icon name="mdi:clipboard-text-outline" class="h-6 w-6 mr-3" />
              Danh sách hóa đơn
            </h3>
          </div>

          <div v-if="isLoading" class="text-center py-16">
            <Icon
              name="mdi:loading"
              class="h-12 w-12 animate-spin text-black mx-auto"
            />
            <p class="mt-4 font-bold uppercase tracking-wide text-sm">
              Đang tải dữ liệu...
            </p>
          </div>

          <div v-else-if="hasOrders">
            <div class="overflow-x-auto">
              <table class="w-full text-sm text-left">
                <thead
                  class="bg-black text-white uppercase text-xs font-bold tracking-wider"
                >
                  <tr>
                    <th class="px-6 py-4">Mã đơn</th>
                    <th class="px-6 py-4">Tổng tiền</th>
                    <th class="px-6 py-4">Ngày đặt</th>
                    <th class="px-6 py-4 text-center">Trạng thái</th>
                    <th class="px-6 py-4"></th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-black">
                  <tr
                    v-for="(order, index) in visibleOrders"
                    :key="order.id"
                    class="hover:bg-gray-50 transition-colors group cursor-pointer"
                    @click="handleSelectOrder(order)"
                  >
                    <td class="px-6 py-4 font-bold text-gray-950">
                      #{{ order.id }}
                    </td>
                    <td
                      class="px-6 py-4 text-gray-950 font-extrabold text-base"
                    >
                      {{ formatPrice(order.total_amount) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                      {{ formatDate(order.created_at) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                      <span
                        v-if="order.status === 'completed'"
                        class="inline-block bg-green-700 text-white text-[10px] uppercase px-2 py-1 font-bold tracking-wide border border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]"
                      >
                        Hoàn tất
                      </span>
                      <span
                        v-else
                        class="inline-block bg-gray-200 text-black text-[10px] uppercase px-2 py-1 font-bold tracking-wide border border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]"
                      >
                        {{ order.status_label || "Đang xử lý" }}
                      </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                      <button
                        class="text-[10px] uppercase font-bold border border-black px-4 py-2 transition-all duration-200"
                        :class="
                          selectedOrder?.id === order.id
                            ? 'bg-black text-white shadow-none translate-x-0.5 translate-y-0.5'
                            : 'bg-white text-black hover:bg-black hover:text-white shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5'
                        "
                      >
                        Xem
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div
              v-if="canLoadMore"
              class="flex justify-center p-6 border-t-2 border-black bg-gray-50"
            >
              <button
                @click="loadMore"
                class="bg-white border border-black text-black px-8 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5"
              >
                Tải thêm
              </button>
            </div>
          </div>

          <div v-else class="text-center py-16 px-6">
            <Icon
              name="mdi:package-variant-closed"
              class="h-20 w-20 text-black mx-auto mb-6 opacity-20"
            />
            <h2 class="text-2xl font-black uppercase mb-2 tracking-tighter">
              Không có đơn hàng!
            </h2>
            <p class="text-gray-600 mb-8">
              "Hãy thử chọn cho bạn 1 diện mạo mới."
            </p>
            <NuxtLink
              to="/catalog"
              class="inline-block bg-black text-white border border-black px-8 py-3 text-xs font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all shadow-[4px_4px_0px_0px_rgba(150,150,150,1)]"
            >
              Mua sắm ngay
            </NuxtLink>
          </div>
        </div>
      </div>

      <div class="lg:col-span-5">
        <div
          v-if="selectedOrder"
          class="bg-white border-2 border-black sticky top-4 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.2)]"
        >
          <div
            class="bg-black text-white p-4 flex justify-between items-center"
          >
            <h4 class="text-lg font-bold uppercase tracking-wider">
              Hóa đơn #{{ selectedOrder.id }}
            </h4>
            <span class="text-xs font-mono bg-white text-black px-2 py-1">
              {{ formatDate(selectedOrder.created_at) }}
            </span>
          </div>

          <div class="p-6">
            <div
              class="grid grid-cols-2 gap-y-4 text-sm mb-6 border-b-2 border-dashed border-gray-300 pb-6"
            >
              <div class="flex flex-col">
                <span class="text-xs text-gray-500 uppercase font-bold mb-1"
                  >Thanh toán</span
                >
                <span
                  class="font-bold uppercase text-gray-800 flex items-center gap-1"
                >
                  <Icon name="mdi:credit-card-outline" class="w-4 h-4" />
                  {{ selectedOrder.payment_method }}
                </span>
              </div>
              <div class="flex flex-col text-right">
                <span class="text-xs text-gray-500 uppercase font-bold mb-1"
                  >Trạng thái</span
                >
                <span
                  :class="
                    selectedOrder.status === 'completed'
                      ? 'text-green-700'
                      : 'text-blue-700'
                  "
                  class="font-bold uppercase"
                >
                  {{ selectedOrder.status_label || selectedOrder.status }}
                </span>
              </div>
              <div class="col-span-2 flex flex-col mt-2">
                <span class="text-xs text-gray-500 uppercase font-bold mb-1"
                  >Địa chỉ nhận hàng</span
                >
                <span
                  class="font-medium text-sm text-gray-800 leading-relaxed border-l-2 border-black pl-3 ml-1"
                >
                  {{ selectedOrder.shipping_address }}
                </span>
              </div>
            </div>

            <h5
              class="font-black uppercase text-gray-600 text-xs mb-4 flex items-center gap-2"
            >
              <span class="w-2 h-2 bg-black block"></span>
              Chi tiết sản phẩm
            </h5>

            <div
              class="space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar"
            >
              <div
                v-for="(item, idx) in selectedOrder.items"
                :key="idx"
                class="group flex justify-between items-start pb-3 border-b border-gray-100 last:border-0"
              >
                <div class="flex-1 pr-4">
                  <NuxtLink
                    :to="`/products/${item.slug}`"
                    class="font-bold text-sm text-gray-800 uppercase group-hover:underline decoration-2 decoration-black underline-offset-2 transition-all"
                  >
                    {{ item.product_name }}
                  </NuxtLink>
                  <div class="text-xs text-gray-500 mt-1 font-mono">
                    {{ formatPrice(item.price) }} x {{ item.quantity }}
                  </div>
                </div>
                <div class="font-bold font-mono text-gray-700 text-sm">
                  {{ formatPrice(item.subtotal) }}
                </div>
              </div>
            </div>

            <div class="mt-6 pt-4 border-t-4 border-black space-y-2">
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Tạm tính:</span>
                <span class="font-mono text-gray-800">{{
                  formatPrice(selectedOrder.subtotal)
                }}</span>
              </div>
              <div
                v-if="selectedOrder.discount_amount > 0"
                class="flex justify-between text-sm text-red-600"
              >
                <span>Giảm giá:</span>
                <span class="font-mono font-bold"
                  >- {{ formatPrice(selectedOrder.discount_amount) }}</span
                >
              </div>

              <div
                class="flex justify-between items-center pt-2 mt-2 border-t border-dashed border-gray-400"
              >
                <span
                  class="font-black text-gray-800 uppercase text-lg tracking-tighter"
                  >Tổng cộng</span
                >
                <span class="font-black text-2xl text-red-700 tracking-tight">
                  {{ formatPrice(selectedOrder.total_amount) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <div
          v-else-if="hasOrders"
          class="bg-white border-2 border-dashed border-gray-300 p-10 h-full flex flex-col items-center justify-center text-gray-400"
        >
          <Icon
            name="mdi:receipt-text-outline"
            class="w-16 h-16 mb-4 opacity-50"
          />
          <p class="uppercase font-bold text-sm tracking-wide">
            Chọn hóa đơn để xem chi tiết
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { storeToRefs } from "pinia";
import { useAuthStore } from "~/stores/useAuthStore";
import { useRouter } from "vue-router";
import axios from "axios";
import { BASE_URL, headersConfig } from "~/helpers/config";
import { formatDate, formatPrice } from "~/utils/format";
import PageHeader from "~/components/shared/PageHeader.vue";
import auth from "~/middleware/auth";

const authStore = useAuthStore();
const { isLoggedIn } = storeToRefs(authStore);
const router = useRouter();

const orders = ref([]);
const isLoading = ref(false);
const selectedOrder = ref(null);
const ordersToShow = ref(5);

const fetchOrders = async () => {
  isLoading.value = true;
  try {
    const res = await axios.get(
      `${BASE_URL}/orders`,
      headersConfig(authStore.access_token)
    );

    if (res.data.success) {
      orders.value = res.data.orders;
    }
  } catch (error) {
    console.error("Error fetching orders:", error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  if (!isLoggedIn.value) {
    router.push("/login");
  } else {
    fetchOrders();
  }
});

const hasOrders = computed(() => {
  return orders.value && orders.value.length > 0;
});

const visibleOrders = computed(() => {
  if (!hasOrders.value) return [];
  return orders.value.slice(0, ordersToShow.value);
});

const canLoadMore = computed(() => {
  if (!hasOrders.value) return false;
  return ordersToShow.value < orders.value.length;
});

const handleSelectOrder = (order) => {
  selectedOrder.value = order;
};

const loadMore = () => {
  ordersToShow.value += 5;
};

definePageMeta({
  middleware: "auth",
});
</script>
