import { it } from "@nuxt/ui/runtime/locale/index.js";
import { defineStore } from "pinia";

export const useCartStore = defineStore("cart", {
  state: () => ({
    isOpen: false,
    items: [],
    appliedCoupon: null,
  }),
  persist: true,

  getters: {
    itemCount(state) {
      return state.items.reduce((total, item) => total + item.quantity, 0);
    },

    subtotal(state) {
      return state.items.reduce((total, item) => {
        return total + item.product.price * item.quantity;
      }, 0);
    },

    discountAmount(state) {
      if (!state.appliedCoupon || !state.appliedCoupon.discount) {
        return 0;
      }
      const discountPercentage = state.appliedCoupon.discount;
      return (this.subtotal * discountPercentage) / 100;
    },

    finalSubtotal(state) {
      return this.subtotal - this.discountAmount;
    },
  },

  actions: {
    openCart() {
      this.isOpen = true;
    },
    closeCart() {
      this.isOpen = false;
    },
    toggleCart() {
      this.isOpen = !this.isOpen;
    },

    addItem(product, quantity = 1) {
      const existingItem = this.items.find(
        (item) => item.product.id === product.id
      );

      if (existingItem) {
        const maxAdd = product.qty - existingItem.quantity;
        if (maxAdd > 0) {
          existingItem.quantity += Math.min(quantity, maxAdd);
        }
      } else {
        this.items.push({ product, quantity });
      }
    },

    updateQuantity(productId, newQuantity) {
      const item = this.items.find((item) => item.product.id === productId);

      if (item) {
        if (newQuantity > 0) {
          item.quantity = Math.min(newQuantity, item.product.qty);
        } else {
          this.removeItem(productId);
        }
      }
    },

    removeItem(productId) {
      this.items = this.items.filter((item) => item.product.id !== productId);
    },

    async applyCoupon(couponCode) {
      console.log(1);

      if (couponCode.toUpperCase() === "SALE10") {
        const couponData = {
          code: "SALE10",
          discount: 10,
        };
        this.appliedCoupon = couponData;
        console.log("Coupon Applied!");
      } else {
        this.appliedCoupon = null;
        console.error("Invalid Coupon");
        throw new Error("Invalid Coupon");
      }
    },

    removeCoupon() {
      this.appliedCoupon = null;
      console.log("Coupon deleted");
    },
  },
});
