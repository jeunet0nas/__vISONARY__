import axios from "axios";
import { BASE_URL } from "~/helpers/config";

export const useProductsStore = defineStore("products", {
  state: () => ({
    products: [],
    collections: [],
    isLoading: false,
    filter: null,
  }),
  actions: {
    async fetchAllProducts() {
      this.isLoading = true;
      try {
        const res = await axios.get(`${BASE_URL}/products`);
        this.products = res.data.data;
        this.collections = res.data.collections;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
});
