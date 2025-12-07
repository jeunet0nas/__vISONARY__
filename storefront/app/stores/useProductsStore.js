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

    async fetchProducts({ collection_slug } = {}) {
      this.isLoading = true;
      try {
        let url = `${BASE_URL}/products`;
        if (collection_slug) {
          url = `${BASE_URL}/products/${collection_slug}/collection`;
        }
        const res = await axios.get(url);
        this.products = res.data.data;
        this.collections = res.data.collections;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },

    async fetchProductsMulti({
      collections = [],
      shapes = [],
      materials = [],
    } = {}) {
      this.isLoading = true;
      try {
        const url = `${BASE_URL}/products/filter`;
        // axios sẽ tự encode mảng thành query string: ?collections[]=a&collections[]=b
        const params = {};
        if (collections.length) params.collections = collections;
        if (shapes.length) params.shapes = shapes;
        if (materials.length) params.materials = materials;
        const res = await axios.get(url, { params });
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
