import axios from "axios";
import { BASE_URL } from "~/helpers/config";

export const useProductDetailsStore = defineStore("product", {
  state: () => ({
    product: null,
    productThumbnail: "",
    productImages: [],
    isLoading: false,
    errorMessage: "",
  }),
  actions: {
    async fetchProduct(slug) {
      this.productImages = [];
      this.isLoading = true;
      try {
        const res = await axios.get(`${BASE_URL}/products/${slug}/show`);
        this.product = res.data.data;
        this.productThumbnail = res.data.data.thumbnail;

        const imageKeys = ['first_img', 'second_img', 'third_img', 'fourth_img'];
        let id = 1;
        imageKeys.forEach((key) => {
          if (res.data.data[key]) {
            this.productImages.push({
              id: id++,
              src: res.data.data[key],
            });
          }
        });
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
});
