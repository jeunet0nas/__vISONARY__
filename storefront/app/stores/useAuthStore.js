import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    isLoggedIn: false,
    user: null,
    access_token: "",
    validationErrors: null,
    isLoading: false,
  }),
  persist: true,
  actions: {
    setIsLoggedIn() {
      this.isLoggedIn = true;
    },
    setUser(user) {
      this.user = user;
    },
    setToken(token) {
      this.token = token;
    },
    clearAuthData() {
      (this.isLoading = false), (this.user = null), (this.access_token = "");
    },
    setValidationErrors(errors) {
      this.validationErrors = errors;
    },
    clearValidationError() {
      this.validationErrors = null;
    },
  },
});
