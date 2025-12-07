import { defineStore } from "pinia";
import axios from "axios";
import { error } from "#build/ui";
import { BASE_URL } from "~/helpers/config";

export const useCollectionsStore = defineStore("colletions", {
  state: () => ({
    collections: [],
    isLoading: false,
    error: null,
  }),
  actions: {
    async fetchCollections() {
      this.isLoading = true;
      this.error = null;
      try {
        const res = await axios.get(`${BASE_URL}/collections`);
        this.collections = res.data.data;
      } catch (error) {
        this.error = reactive;
      } finally {
        this.isLoading = false;
      }
    },
  },
});
